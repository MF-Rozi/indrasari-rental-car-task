<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('profile page requires authentication', function () {
    $this->get('/profile')->assertRedirect('/login');
});

test('profile page displays authenticated user actual values and verification badge', function () {
    $user = User::factory()->create([
        'name' => 'Ahmad Dahlan',
        'email' => 'ahmad@example.test',
        'phone_number' => '081122334455',
        'driving_license_number' => '9988-7766-5544',
        'driving_license_expiry_date' => '2028-06-30',
        'address' => 'Jl. Merdeka No. 45, Bandung',
        'role' => 'user',
        'verification_status' => 'verified',
    ]);

    $response = $this->actingAs($user)->get('/profile');

    $response->assertStatus(200);
    $response->assertSee('Ahmad Dahlan');
    $response->assertSee('ahmad@example.test');
    $response->assertSee('081122334455');
    $response->assertSee('9988-7766-5544');
    $response->assertSee('30 Jun 2028');
    $response->assertSee('Jl. Merdeka No. 45, Bandung');
    $response->assertSee('SIM A Terverifikasi');
});

test('user can update their profile information successfully', function () {
    $user = User::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.test',
        'phone_number' => '081111111111',
        'driving_license_number' => 'SIM-1111',
        'driving_license_expiry_date' => '2027-01-01',
        'address' => 'Old Address',
    ]);

    $response = $this->actingAs($user)->put('/profile', [
        'name' => 'Updated Name',
        'email' => 'updated@example.test',
        'phone_number' => '082222222222',
        'driving_license_number' => 'SIM-2222',
        'driving_license_expiry_date' => '2029-12-31',
        'address' => 'New Updated Address',
    ]);

    $response->assertRedirect('/profile');
    $response->assertSessionHas('success', 'Data profil Anda berhasil diperbarui.');

    $user->refresh();
    expect($user->name)->toBe('Updated Name')
        ->and($user->email)->toBe('updated@example.test')
        ->and($user->phone_number)->toBe('082222222222')
        ->and($user->driving_license_number)->toBe('SIM-2222')
        ->and($user->driving_license_expiry_date->format('Y-m-d'))->toBe('2029-12-31')
        ->and($user->address)->toBe('New Updated Address');
});

test('user can update profile with a new driving license photo', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $file = UploadedFile::fake()->create('new_sim.jpg', 200, 'image/jpeg');

    $response = $this->actingAs($user)->put('/profile', [
        'name' => $user->name,
        'email' => $user->email,
        'phone_number' => $user->phone_number,
        'driving_license_number' => $user->driving_license_number,
        'driving_license_expiry_date' => $user->driving_license_expiry_date->format('Y-m-d'),
        'address' => $user->address,
        'driving_license_photo' => $file,
    ]);

    $response->assertRedirect('/profile');

    $user->refresh();
    Storage::disk('public')->assertExists($user->driving_license_photo);
});

test('user can update password via separated password endpoint with current password verification', function () {
    $user = User::factory()->create([
        'password' => Hash::make('oldpassword123'),
    ]);

    $response = $this->actingAs($user)->put('/profile/password', [
        'current_password' => 'oldpassword123',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);

    $response->assertRedirect('/profile');
    $response->assertSessionHas('success_password', 'Kata sandi Anda berhasil diperbarui.');
    $user->refresh();
    expect(Hash::check('newpassword123', $user->password))->toBeTrue();
});

test('user cannot update password if current password is incorrect', function () {
    $user = User::factory()->create([
        'password' => Hash::make('oldpassword123'),
    ]);

    $response = $this->actingAs($user)->put('/profile/password', [
        'current_password' => 'wrongpassword',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);

    $response->assertSessionHasErrors('current_password');
    $user->refresh();
    expect(Hash::check('oldpassword123', $user->password))->toBeTrue();
});

test('user cannot update password if confirmation does not match', function () {
    $user = User::factory()->create([
        'password' => Hash::make('oldpassword123'),
    ]);

    $response = $this->actingAs($user)->put('/profile/password', [
        'current_password' => 'oldpassword123',
        'password' => 'newpassword123',
        'password_confirmation' => 'mismatchedpassword',
    ]);

    $response->assertSessionHasErrors('password');
    $user->refresh();
    expect(Hash::check('oldpassword123', $user->password))->toBeTrue();
});
