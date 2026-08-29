<?php

use App\Models\Fleet;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot book a car and are redirected to login', function () {
    $car = Fleet::factory()->create();

    $response = $this->post(route('rentals.store'), [
        'fleet_id' => $car->id,
        'start_date' => Carbon::now()->addDay()->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
    ]);

    $response->assertRedirect(route('login'));
    expect(Rental::count())->toBe(0);
});

test('unverified users with pending SIM status cannot book a car', function () {
    $user = User::factory()->pending()->create();
    $car = Fleet::factory()->create();

    $response = $this->actingAs($user)->post(route('rentals.store'), [
        'fleet_id' => $car->id,
        'start_date' => Carbon::now()->addDay()->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
    expect(Rental::count())->toBe(0);
});

test('unverified users with rejected SIM status cannot book a car', function () {
    $user = User::factory()->rejected()->create();
    $car = Fleet::factory()->create();

    $response = $this->actingAs($user)->post(route('rentals.store'), [
        'fleet_id' => $car->id,
        'start_date' => Carbon::now()->addDay()->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
    expect(Rental::count())->toBe(0);
});

test('verified user can successfully book an available car', function () {
    $user = User::factory()->verified()->create();
    $car = Fleet::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Innova Zenix 2.0 Q',
        'price' => 650000,
        'availability' => 'available',
    ]);

    $startDate = Carbon::now()->addDays(2)->format('Y-m-d');
    $endDate = Carbon::now()->addDays(4)->format('Y-m-d'); // 3 inclusive days

    $response = $this->actingAs($user)->post(route('rentals.store'), [
        'fleet_id' => $car->id,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'notes' => 'Perjalanan dinas ke Pekanbaru',
    ]);

    $response->assertRedirect(route('rentals.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('rentals', [
        'user_id' => $user->id,
        'fleet_id' => $car->id,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'daily_rate' => 650000,
        'total_days' => 3,
        'total_price' => 1950000,
        'status' => 'active',
        'notes' => 'Perjalanan dinas ke Pekanbaru',
    ]);

    $rental = Rental::where('user_id', $user->id)->first();
    expect($rental->rental_code)->toStartWith('IND-BK-');

    $car->refresh();
    expect($car->availability)->toBe('rented');
});

test('booking calculates inclusive days and price accurately for same-day and multi-day rentals', function () {
    $user = User::factory()->verified()->create();
    $car = Fleet::factory()->create(['price' => 500000]);

    // 1. Same-day rental (1 inclusive day)
    $today = Carbon::now()->addDay()->format('Y-m-d');
    $this->actingAs($user)->post(route('rentals.store'), [
        'fleet_id' => $car->id,
        'start_date' => $today,
        'end_date' => $today,
    ]);

    $sameDayRental = Rental::first();
    expect($sameDayRental->total_days)->toBe(1);
    expect((float) $sameDayRental->total_price)->toBe(500000.0);

    // 2. Multi-day rental helper formula test
    expect(Rental::calculateInclusiveDays('2026-03-01', '2026-03-01'))->toBe(1);
    expect(Rental::calculateInclusiveDays('2026-03-01', '2026-03-02'))->toBe(2);
    expect(Rental::calculateInclusiveDays('2026-03-01', '2026-03-05'))->toBe(5);
});

test('booking fails if start date is in the past', function () {
    $user = User::factory()->verified()->create();
    $car = Fleet::factory()->create();

    $response = $this->actingAs($user)->post(route('rentals.store'), [
        'fleet_id' => $car->id,
        'start_date' => Carbon::now()->subDay()->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
    ]);

    $response->assertSessionHasErrors(['start_date']);
    expect(Rental::count())->toBe(0);
});

test('booking fails if end date is before start date', function () {
    $user = User::factory()->verified()->create();
    $car = Fleet::factory()->create();

    $response = $this->actingAs($user)->post(route('rentals.store'), [
        'fleet_id' => $car->id,
        'start_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
    ]);

    $response->assertSessionHasErrors(['end_date']);
    expect(Rental::count())->toBe(0);
});

test('booking fails if car is currently in maintenance', function () {
    $user = User::factory()->verified()->create();
    $car = Fleet::factory()->create(['availability' => 'maintenance']);

    $response = $this->actingAs($user)->post(route('rentals.store'), [
        'fleet_id' => $car->id,
        'start_date' => Carbon::now()->addDay()->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
    expect(Rental::count())->toBe(0);
});

test('booking fails if selected date range overlaps with an active rental', function () {
    $user1 = User::factory()->verified()->create();
    $user2 = User::factory()->verified()->create();
    $car = Fleet::factory()->create(['availability' => 'rented']);

    // Existing active rental: 5 to 10 days from now
    Rental::factory()->create([
        'fleet_id' => $car->id,
        'start_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
        'status' => 'active',
    ]);

    // Request overlapping range: 8 to 12 days from now
    $response = $this->actingAs($user2)->post(route('rentals.store'), [
        'fleet_id' => $car->id,
        'start_date' => Carbon::now()->addDays(8)->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(12)->format('Y-m-d'),
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');
    expect(Rental::count())->toBe(1); // No new rental created
});

test('booking succeeds for non-overlapping dates on the same car', function () {
    $user1 = User::factory()->verified()->create();
    $user2 = User::factory()->verified()->create();
    $car = Fleet::factory()->create(['availability' => 'available']);

    // First booking: Days 1 to 3
    Rental::factory()->create([
        'fleet_id' => $car->id,
        'user_id' => $user1->id,
        'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
        'status' => 'active',
    ]);

    // Second booking on non-overlapping dates: Days 5 to 7
    $response = $this->actingAs($user2)->post(route('rentals.store'), [
        'fleet_id' => $car->id,
        'start_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
    ]);

    $response->assertRedirect(route('rentals.index'));
    $response->assertSessionHas('success');
    expect(Rental::count())->toBe(2);
});

test('user can cancel upcoming booking and vehicle reverts to available', function () {
    $user = User::factory()->verified()->create();
    $car = Fleet::factory()->create(['availability' => 'rented']);

    $rental = Rental::factory()->create([
        'user_id' => $user->id,
        'fleet_id' => $car->id,
        'start_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(8)->format('Y-m-d'),
        'status' => 'active',
    ]);

    expect($rental->isCancellable())->toBeTrue();

    $response = $this->actingAs($user)->delete(route('rentals.cancel', $rental));

    $response->assertRedirect(route('rentals.index'));
    $response->assertSessionHas('success');

    $rental->refresh();
    expect($rental->status)->toBe('cancelled');

    $car->refresh();
    expect($car->availability)->toBe('available');
});

test('user cannot cancel booking that has already started', function () {
    $user = User::factory()->verified()->create();
    $car = Fleet::factory()->create();

    $rental = Rental::factory()->create([
        'user_id' => $user->id,
        'fleet_id' => $car->id,
        'start_date' => Carbon::now()->subDay()->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
        'status' => 'active',
    ]);

    expect($rental->isCancellable())->toBeFalse();

    $response = $this->actingAs($user)->delete(route('rentals.cancel', $rental));

    $response->assertRedirect();
    $response->assertSessionHas('error');

    $rental->refresh();
    expect($rental->status)->toBe('active');
});

test('user cannot cancel another user rental booking', function () {
    $owner = User::factory()->verified()->create();
    $intruder = User::factory()->verified()->create();
    $car = Fleet::factory()->create();

    $rental = Rental::factory()->create([
        'user_id' => $owner->id,
        'fleet_id' => $car->id,
        'start_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
        'status' => 'active',
    ]);

    $response = $this->actingAs($intruder)->delete(route('rentals.cancel', $rental));

    $response->assertForbidden();

    $rental->refresh();
    expect($rental->status)->toBe('active');
});
