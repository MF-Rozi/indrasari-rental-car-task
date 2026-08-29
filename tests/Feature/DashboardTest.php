<?php

use App\Models\Fleet;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest cannot access customer dashboard and is redirected to login', function () {
    $response = $this->get(route('dashboard'));

    $response->assertRedirect(route('login'));
});

test('authenticated customer can access customer dashboard with their active booking and personal statistics', function () {
    $user = User::factory()->verified()->create([
        'name' => 'Ahmad Fauzi',
    ]);

    $car = Fleet::factory()->create([
        'brand' => 'Honda',
        'model' => 'CR-V 1.5 Turbo',
        'plate_number' => 'B 7777 CRV',
    ]);

    $rental = Rental::factory()->create([
        'user_id' => $user->id,
        'fleet_id' => $car->id,
        'rental_code' => 'IND-BK-202608-7777',
        'status' => 'active',
        'start_date' => Carbon::now()->format('Y-m-d'),
        'end_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    $response->assertViewIs('dashboard.index');
    $response->assertViewHas('activeRental');
    $response->assertViewHas('stats', function ($stats) {
        return $stats['total_bookings'] === 1
            && $stats['active_count'] === 1
            && $stats['completed_count'] === 0;
    });
});

test('customer with no active booking receives null active rental in dashboard view', function () {
    $user = User::factory()->verified()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    $response->assertViewIs('dashboard.index');
    $response->assertViewHas('activeRental', null);
    $response->assertViewHas('stats', function ($stats) {
        return $stats['active_count'] === 0;
    });
});

test('regular customer receives 403 forbidden when accessing admin dashboard', function () {
    $user = User::factory()->verified()->create(['role' => 'user']);

    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    $response->assertForbidden();
});

test('admin can access admin dashboard with aggregated revenue, fleet stats, and user stats', function () {
    $admin = User::factory()->admin()->create();

    // Create fleets with various availabilities
    Fleet::factory()->create(['availability' => 'available']);
    Fleet::factory()->create(['availability' => 'rented']);
    Fleet::factory()->create(['availability' => 'maintenance']);

    // Create completed rental with revenue
    $customer = User::factory()->verified()->create();
    $car = Fleet::factory()->create();

    Rental::factory()->create([
        'user_id' => $customer->id,
        'fleet_id' => $car->id,
        'status' => 'completed',
        'total_price' => 2000000,
        'penalty_price' => 150000,
        'return_date' => Carbon::now()->format('Y-m-d'),
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk();
    $response->assertViewIs('admin.dashboard.index');
    $response->assertViewHas('stats', function ($stats) {
        return $stats['total_rentals'] === 1
            && $stats['completed_rentals'] === 1
            && $stats['total_revenue'] == 2150000;
    });
    $response->assertViewHas('fleetStats', function ($fleetStats) {
        return $fleetStats['total_fleets'] === 4
            && $fleetStats['available_fleets'] === 2
            && $fleetStats['rented_fleets'] === 1
            && $fleetStats['maintenance_fleets'] === 1;
    });
    $response->assertViewHas('userStats', function ($userStats) {
        return $userStats['total_users'] === 1
            && $userStats['verified_users'] === 1;
    });
});

test('admin dashboard identifies pending returns and pending user verifications in action queues', function () {
    $admin = User::factory()->admin()->create();

    $pendingCustomer = User::factory()->pending()->create();
    $verifiedCustomer = User::factory()->verified()->create();
    $car = Fleet::factory()->create();

    $pendingRental = Rental::factory()->create([
        'user_id' => $verifiedCustomer->id,
        'fleet_id' => $car->id,
        'status' => 'pending_return',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk();
    $response->assertViewHas('pendingReturns', function ($pendingReturns) use ($pendingRental) {
        return $pendingReturns->contains('id', $pendingRental->id);
    });
    $response->assertViewHas('pendingVerifications', function ($pendingVerifications) use ($pendingCustomer) {
        return $pendingVerifications->contains('id', $pendingCustomer->id);
    });
});
