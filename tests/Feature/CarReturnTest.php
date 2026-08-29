<?php

use App\Models\Fleet;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest cannot access car return page and is redirected to login', function () {
    $response = $this->get(route('returns.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated customer can view return page with their active rentals', function () {
    $user = User::factory()->verified()->create();
    $car1 = Fleet::factory()->create(['brand' => 'Toyota', 'model' => 'Avanza', 'plate_number' => 'B 1111 TYA']);
    $car2 = Fleet::factory()->create(['brand' => 'Honda', 'model' => 'HR-V', 'plate_number' => 'B 2222 HND']);

    Rental::factory()->create([
        'user_id' => $user->id,
        'fleet_id' => $car1->id,
        'status' => 'active',
    ]);

    $response = $this->actingAs($user)->get(route('returns.index'));

    $response->assertOk();
    $response->assertViewIs('returns.index');
    $response->assertViewHas('activeRentals');
});

test('customer can verify plate number via json and receive accurate settlement summary', function () {
    $user = User::factory()->verified()->create();
    $car = Fleet::factory()->create([
        'brand' => 'Mitsubishi',
        'model' => 'Pajero Sport',
        'plate_number' => 'B 1888 MFS',
        'price' => 800000,
    ]);

    $rental = Rental::factory()->create([
        'user_id' => $user->id,
        'fleet_id' => $car->id,
        'daily_rate' => 800000,
        'start_date' => Carbon::now()->subDays(3)->format('Y-m-d'),
        'end_date' => Carbon::now()->subDay()->format('Y-m-d'), // 1 day overdue
        'total_days' => 3,
        'total_price' => 2400000,
        'status' => 'active',
    ]);

    $response = $this->actingAs($user)->postJson(route('returns.verify'), [
        'plate_number' => 'B 1888 MFS',
    ]);

    $response->assertOk();
    $response->assertJson([
        'success' => true,
        'rental' => [
            'id' => $rental->id,
            'rental_code' => $rental->rental_code,
            'daily_rate' => 800000,
        ],
        'settlement' => [
            'is_overdue' => true,
            'days_overdue' => 1,
            'penalty_price' => 800000,
            'grand_total' => 3200000,
        ],
    ]);
});

test('verifying plate number of car not actively rented by authenticated user returns error', function () {
    $user1 = User::factory()->verified()->create();
    $user2 = User::factory()->verified()->create();

    $car = Fleet::factory()->create(['plate_number' => 'B 9999 XYZ']);

    Rental::factory()->create([
        'user_id' => $user2->id,
        'fleet_id' => $car->id,
        'status' => 'active',
    ]);

    $response = $this->actingAs($user1)->postJson(route('returns.verify'), [
        'plate_number' => 'B 9999 XYZ',
    ]);

    $response->assertStatus(404);
    $response->assertJson([
        'success' => false,
    ]);
});

test('customer can submit car return request and status becomes pending_return with auto penalty calculation', function () {
    $user = User::factory()->verified()->create();
    $car = Fleet::factory()->create([
        'price' => 500000,
        'availability' => 'rented',
    ]);

    $rental = Rental::factory()->create([
        'user_id' => $user->id,
        'fleet_id' => $car->id,
        'daily_rate' => 500000,
        'start_date' => Carbon::now()->subDays(5)->format('Y-m-d'),
        'end_date' => Carbon::now()->subDays(2)->format('Y-m-d'), // 2 days overdue
        'total_days' => 4,
        'total_price' => 2000000,
        'status' => 'active',
    ]);

    $response = $this->actingAs($user)->post(route('returns.store'), [
        'rental_id' => $rental->id,
        'return_notes' => 'Mobil dikembalikan dalam kondisi bersih, bensin full.',
    ]);

    $response->assertRedirect(route('rentals.index'));
    $response->assertSessionHas('success');

    $rental->refresh();
    expect($rental->status)->toBe('pending_return');
    expect((float) $rental->penalty_price)->toBe(1000000.0); // 2 days overdue * 500k
    expect($rental->return_date)->not->toBeNull();
    expect($rental->notes)->toContain('Mobil dikembalikan dalam kondisi bersih, bensin full.');
});

test('regular customer cannot access admin rentals management page', function () {
    $user = User::factory()->verified()->create(['role' => 'user']);

    $response = $this->actingAs($user)->get(route('admin.rentals.index'));

    $response->assertForbidden();
});

test('admin can access admin rentals management page with KPI statistics and filters', function () {
    $admin = User::factory()->admin()->create();

    $user = User::factory()->verified()->create();
    $car = Fleet::factory()->create();

    Rental::factory()->create([
        'user_id' => $user->id,
        'fleet_id' => $car->id,
        'status' => 'active',
    ]);

    Rental::factory()->create([
        'user_id' => $user->id,
        'fleet_id' => $car->id,
        'status' => 'completed',
        'total_price' => 1500000,
        'penalty_price' => 200000,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.rentals.index'));

    $response->assertOk();
    $response->assertViewIs('admin.rentals.index');
    $response->assertViewHas('rentals');
    $response->assertViewHas('stats', function ($stats) {
        return $stats['total_rentals'] === 2
            && $stats['active_rentals'] === 1
            && $stats['completed_rentals'] === 1
            && $stats['total_revenue'] == 1700000;
    });
});

test('admin can confirm physical car return which marks rental as completed and frees car to available', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->verified()->create();

    $car = Fleet::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Innova Zenix',
        'plate_number' => 'B 2419 IND',
        'availability' => 'rented',
        'price' => 650000,
    ]);

    $rental = Rental::factory()->create([
        'user_id' => $customer->id,
        'fleet_id' => $car->id,
        'daily_rate' => 650000,
        'start_date' => Carbon::now()->subDays(3)->format('Y-m-d'),
        'end_date' => Carbon::now()->subDay()->format('Y-m-d'), // 1 day overdue
        'total_days' => 3,
        'total_price' => 1950000,
        'status' => 'pending_return',
    ]);

    $response = $this->actingAs($admin)->patch(route('admin.rentals.confirm-return', $rental), [
        'penalty_price' => 650000,
        'admin_notes' => 'Body mulus, kunci dan STNK lengkap diserahkan.',
    ]);

    $response->assertRedirect(route('admin.rentals.index'));
    $response->assertSessionHas('success');

    $rental->refresh();
    $car->refresh();

    expect($rental->status)->toBe('completed');
    expect((float) $rental->penalty_price)->toBe(650000.0);
    expect($rental->admin_notes)->toBe('Body mulus, kunci dan STNK lengkap diserahkan.');
    expect($car->availability)->toBe('available');
});

test('admin cannot confirm return on rental that is already completed or cancelled', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->verified()->create();
    $car = Fleet::factory()->create();

    $completedRental = Rental::factory()->create([
        'user_id' => $customer->id,
        'fleet_id' => $car->id,
        'status' => 'completed',
    ]);

    $response = $this->actingAs($admin)->patch(route('admin.rentals.confirm-return', $completedRental), [
        'admin_notes' => 'Coba konfirmasi lagi',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
});
