<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('auth page displays sign-in and register forms with csrf and inputs', function () {
    $response = $this->get('/auth');

    $response->assertStatus(200);
    $response->assertSee('Masuk Akun');
    $response->assertSee('Daftar Baru');
    $response->assertSee('name="email"', false);
    $response->assertSee('name="password"', false);
    $response->assertSee('name="driving_license_number"', false);
    $response->assertSee('name="driving_license_expiry_date"', false);
    $response->assertSee('name="driving_license_photo"', false);
});

test('login page loads directly at /login and register page loads directly at /register', function () {
    $loginResponse = $this->get('/login');
    $loginResponse->assertStatus(200);
    $loginResponse->assertSee('Masuk Akun');

    $registerResponse = $this->get('/register');
    $registerResponse->assertStatus(200);
    $registerResponse->assertSee('Daftar Baru');
});

test('already authenticated users are redirected away from /login and /register', function () {
    $user = User::factory()->create(['role' => 'user']);
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)->get('/login')->assertRedirect('/dashboard');
    $this->actingAs($user)->get('/register')->assertRedirect('/dashboard');

    $this->actingAs($admin)->get('/login')->assertRedirect('/admin/dashboard');
    $this->actingAs($admin)->get('/register')->assertRedirect('/admin/dashboard');
});

test('regular user can login successfully and is redirected to /dashboard', function () {
    $user = User::factory()->create([
        'email' => 'user@indrasari.test',
        'password' => Hash::make('secret123'),
        'role' => 'user',
    ]);

    $response = $this->post('/login', [
        'email' => 'user@indrasari.test',
        'password' => 'secret123',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
});

test('admin can login successfully and is redirected to /admin/dashboard', function () {
    $admin = User::factory()->create([
        'email' => 'admin@indrasari.test',
        'password' => Hash::make('secret123'),
        'role' => 'admin',
    ]);

    $response = $this->post('/login', [
        'email' => 'admin@indrasari.test',
        'password' => 'secret123',
    ]);

    $response->assertRedirect('/admin/dashboard');
    $this->assertAuthenticatedAs($admin);
});

test('login fails with invalid credentials and returns validation error', function () {
    User::factory()->create([
        'email' => 'user@indrasari.test',
        'password' => Hash::make('secret123'),
    ]);

    $response = $this->from('/auth')->post('/login', [
        'email' => 'user@indrasari.test',
        'password' => 'wrongpassword',
    ]);

    $response->assertRedirect('/auth');
    $response->assertSessionHasErrors(['email' => 'Email atau password salah.']);
    $this->assertGuest();
});

test('user registration validates unique driving license number and required fields', function () {
    User::factory()->create([
        'driving_license_number' => 'SIM-123456789',
        'email' => 'existing@indrasari.test',
        'phone_number' => '081299998888',
    ]);

    $response = $this->from('/auth?tab=register')->post('/register', [
        'name' => '',
        'email' => 'existing@indrasari.test',
        'phone_number' => '081299998888',
        'driving_license_number' => 'SIM-123456789',
        'driving_license_expiry_date' => '',
        'address' => '',
        'password' => 'pass1234',
        'password_confirmation' => 'mismatch',
    ]);

    $response->assertRedirect('/auth?tab=register');
    $response->assertSessionHasErrors([
        'name',
        'email',
        'phone_number',
        'driving_license_number',
        'driving_license_expiry_date',
        'driving_license_photo',
        'address',
        'password',
    ]);
    $this->assertGuest();
});

test('user registration stores sim photo, creates user with pending status, and auto-logs in', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('driving_license.jpg', 150, 'image/jpeg');

    $response = $this->post('/register', [
        'name' => 'Ahmad Driver',
        'email' => 'ahmad@indrasari.test',
        'phone_number' => '081234567899',
        'driving_license_number' => 'SIM-9988776655',
        'driving_license_expiry_date' => now()->addYears(3)->format('Y-m-d'),
        'driving_license_photo' => $file,
        'address' => 'Jl. Merdeka No. 45, Jakarta',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');

    $this->assertDatabaseHas('users', [
        'name' => 'Ahmad Driver',
        'email' => 'ahmad@indrasari.test',
        'phone_number' => '081234567899',
        'driving_license_number' => 'SIM-9988776655',
        'role' => 'user',
        'verification_status' => 'pending',
    ]);

    $user = User::where('email', 'ahmad@indrasari.test')->first();
    expect($user)->not->toBeNull();
    Storage::disk('public')->assertExists($user->driving_license_photo);
    expect($user->driving_license_photo)->toStartWith('driving_license/');

    $this->assertAuthenticatedAs($user);
});

test('user can logout successfully, invalidating session and redirecting to home', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect('/');
    $this->assertGuest();
});

test('navbar displays user name and logout button when logged in, and guest buttons when logged out', function () {
    // Guest state
    $guestResponse = $this->get('/');
    $guestResponse->assertStatus(200);
    $guestResponse->assertSee('Masuk');
    $guestResponse->assertSee('Daftar');

    // Authenticated state
    $user = User::factory()->create([
        'name' => 'Farhan Santoso',
    ]);

    $authResponse = $this->actingAs($user)->get('/');
    $authResponse->assertStatus(200);
    $authResponse->assertSee('Farhan Santoso');
    $authResponse->assertSee('Keluar');
    $authResponse->assertDontSee('Masuk');
});
