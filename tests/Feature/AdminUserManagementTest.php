<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot access admin users page and are redirected to login', function () {
    $response = $this->get(route('admin.users.index'));

    $response->assertRedirect(route('login'));
});

test('regular users cannot access admin users page and receive 403 forbidden', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)->get(route('admin.users.index'));

    $response->assertForbidden();
});

test('admin can view admin users page with KPI stats and user list', function () {
    $admin = User::factory()->admin()->create();
    $pendingUser = User::factory()->pending()->create(['name' => 'Pending Customer']);
    $verifiedUser = User::factory()->verified()->create(['name' => 'Verified Customer']);

    $response = $this->actingAs($admin)->get(route('admin.users.index'));

    $response->assertOk();
    $response->assertViewIs('admin.users.index');
    $response->assertViewHas('users');
    $response->assertViewHas('stats');
    $response->assertSee('Pending Customer');
    $response->assertSee('Verified Customer');
});

test('admin can filter users by search query', function () {
    $admin = User::factory()->admin()->create();
    $john = User::factory()->create(['name' => 'John Doe', 'email' => 'john@testdomain.com']);
    $jane = User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@testdomain.com']);

    $response = $this->actingAs($admin)->get(route('admin.users.index', ['search' => 'John']));

    $response->assertOk();
    $response->assertSee('John Doe');
    $response->assertDontSee('Jane Smith');
});

test('admin can filter users by verification status', function () {
    $admin = User::factory()->admin()->create();
    $pending = User::factory()->pending()->create(['name' => 'User In Queue']);
    $verified = User::factory()->verified()->create(['name' => 'User Approved']);

    $response = $this->actingAs($admin)->get(route('admin.users.index', ['verification_status' => 'pending']));

    $response->assertOk();
    $response->assertSee('User In Queue');
    $response->assertDontSee('User Approved');
});

test('admin can filter users by role', function () {
    $admin = User::factory()->admin()->create(['name' => 'Staff Admin']);
    $user = User::factory()->create(['name' => 'Regular Renter', 'role' => 'user']);

    $response = $this->actingAs($admin)->get(route('admin.users.index', ['role' => 'admin']));

    $response->assertOk();
    $response->assertSee('Staff Admin');
    $response->assertDontSee('Regular Renter');
});

test('admin can verify a customer driving license SIM A', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->pending()->create();

    expect($customer->verification_status)->toBe('pending');
    expect($customer->isVerified())->toBeFalse();

    $response = $this->actingAs($admin)->patch(route('admin.users.verify', $customer));

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $customer->refresh();
    expect($customer->verification_status)->toBe('verified');
    expect($customer->isVerified())->toBeTrue();
});

test('admin can reject a customer driving license SIM A', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->pending()->create();

    $response = $this->actingAs($admin)->patch(route('admin.users.reject', $customer));

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $customer->refresh();
    expect($customer->verification_status)->toBe('rejected');
    expect($customer->isVerified())->toBeFalse();
});

test('admin can update a user role', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($admin)->patch(route('admin.users.role', $customer), [
        'role' => 'admin',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $customer->refresh();
    expect($customer->role)->toBe('admin');
    expect($customer->isAdmin())->toBeTrue();
});

test('admin cannot demote their own account from admin', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->patch(route('admin.users.role', $admin), [
        'role' => 'user',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');

    $admin->refresh();
    expect($admin->role)->toBe('admin');
});

test('user model includes driving_license_photo_url in json and resolves storage path correctly', function () {
    $user = User::factory()->create([
        'driving_license_photo' => 'driving_licenses/my_test_license.jpg',
    ]);

    expect($user->driving_license_photo_url)->toContain('storage/driving_licenses/my_test_license.jpg');

    $json = $user->toArray();
    expect($json)->toHaveKey('driving_license_photo_url');
    expect($json['driving_license_photo_url'])->toContain('storage/driving_licenses/my_test_license.jpg');
});
