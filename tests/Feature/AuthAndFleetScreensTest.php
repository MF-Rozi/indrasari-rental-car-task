<?php

use App\Models\Fleet;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('homepage loads successfully with hero and featured cars', function () {
    $car = Fleet::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Innova Zenix 2.0 Q Hybrid',
        'availability' => 'available',
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('INDRASARI', false);
    $response->assertSee('Sewa Mobil Nyaman', false);
    $response->assertSee('Innova Zenix 2.0 Q Hybrid', false);
});

test('auth page loads with sign-in and registration tabs', function () {
    $response = $this->get('/auth');

    $response->assertStatus(200);
    $response->assertSee('Masuk Akun', false);
    $response->assertSee('Daftar Baru', false);
    $response->assertSee('Nomor SIM A', false);
});

test('login and register routes render auth page directly with active tab', function () {
    $loginResponse = $this->get('/login');
    $loginResponse->assertStatus(200);
    $loginResponse->assertSee('Masuk Akun');

    $registerResponse = $this->get('/register');
    $registerResponse->assertStatus(200);
    $registerResponse->assertSee('Daftar Baru');
});

test('dedicated customer dashboard loads with active booking and stats', function () {
    $user = User::factory()->create(['role' => 'user', 'name' => 'Budi Santoso']);
    $car = Fleet::factory()->create(['brand' => 'Toyota', 'model' => 'Innova Zenix 2.0 Q', 'plate_number' => 'B 2419 IND']);
    Rental::factory()->create([
        'user_id' => $user->id,
        'fleet_id' => $car->id,
        'status' => 'active',
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Selamat Datang, Budi Santoso', false);
    $response->assertSee('Sewa Aktif Saat Ini', false);
    $response->assertSee('B 2419 IND', false);
    $response->assertSee('Kembalikan Unit Ini', false);
});

test('fleet catalog loads with filters and car list', function () {
    $car1 = Fleet::factory()->create(['brand' => 'Toyota', 'model' => 'Innova Zenix 2.0 Q Hybrid']);
    $car2 = Fleet::factory()->create(['brand' => 'Mitsubishi', 'model' => 'Pajero Sport Dakar 4x2']);

    $response = $this->get('/fleet');

    $response->assertStatus(200);
    $response->assertSee('Pilih Armada Mobil Anda', false);
    $response->assertSee('Filter Pencarian', false);
    $response->assertSee('Innova Zenix 2.0 Q Hybrid', false);
    $response->assertSee('Pajero Sport Dakar 4x2', false);
});

test('fleet detail page loads with vehicle specs and live pricing calculator', function () {
    $car = Fleet::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Innova Zenix 2.0 Q Hybrid',
        'price' => 650000,
        'availability' => 'available',
    ]);

    // As guest
    $response = $this->get('/fleet/'.$car->id);
    $response->assertStatus(200);
    $response->assertSee('Toyota Innova Zenix 2.0 Q Hybrid', false);
    $response->assertSee('Spesifikasi Lengkap', false);
    $response->assertSee('Masuk Akun untuk Memesan', false);

    // As unverified user
    $unverifiedUser = User::factory()->pending()->create(['role' => 'user']);
    $unverifiedResponse = $this->actingAs($unverifiedUser)->get('/fleet/'.$car->id);
    $unverifiedResponse->assertStatus(200);
    $unverifiedResponse->assertSee('Menunggu Verifikasi SIM A', false);

    // As verified user
    $verifiedUser = User::factory()->verified()->create(['role' => 'user']);
    $authResponse = $this->actingAs($verifiedUser)->get('/fleet/'.$car->id);
    $authResponse->assertStatus(200);
    $authResponse->assertSee('Lanjutkan Pemesanan Unit', false);
});

test('admin executive dashboard loads with revenue, utilization and live rentals monitor', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $response = $this->actingAs($admin)->get('/admin');

    $response->assertStatus(200);
    $response->assertSee('Pusat Kontrol Rental Indrasari', false);
    $response->assertSee('Total Pendapatan Selesai', false);
    $response->assertSee('Komposisi Status Operasional Armada Mobil', false);
    $response->assertSee('Antrean Verifikasi Legalitas SIM A', false);
});

test('admin cars index loads with metric badges and vehicle table', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    Fleet::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Innova Zenix 2.0 Q',
    ]);
    $response = $this->actingAs($admin)->get('/admin/cars');

    $response->assertStatus(200);
    $response->assertSee('Manajemen Armada Mobil', false);
    $response->assertSee('Tambah Mobil Baru', false);
    $response->assertSee('Toyota Innova Zenix 2.0 Q', false);
});

test('admin car create page loads with all required specification fields', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $response = $this->actingAs($admin)->get('/admin/cars/create');

    $response->assertStatus(200);
    $response->assertSee('Informasi & Spesifikasi Unit Kendaraan', false);
    $response->assertSee('Nomor Plat Polisi', false);
    $response->assertSee('Tarif Sewa / Hari (IDR)', false);
});

test('customer rentals page loads with active and completed rental tabs', function () {
    $user = User::factory()->verified()->create(['role' => 'user']);
    $car = Fleet::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Innova Zenix 2.0 Q Hybrid',
        'plate_number' => 'B 2419 IND',
    ]);
    Rental::factory()->create([
        'user_id' => $user->id,
        'fleet_id' => $car->id,
        'status' => 'active',
    ]);

    $response = $this->actingAs($user)->get('/rentals');

    $response->assertStatus(200);
    $response->assertSee('Daftar Sewa Mobil Saya', false);
    $response->assertSee('Sedang Disewa (Aktif)', false);
    $response->assertSee('Toyota Innova Zenix 2.0 Q Hybrid', false);
    $response->assertSee('B 2419 IND', false);
});

test('car returns page loads with plate verification and cost calculation', function () {
    $user = User::factory()->create(['role' => 'user']);
    $car = Fleet::factory()->create(['plate_number' => 'B 2419 IND', 'brand' => 'Toyota', 'model' => 'Innova Zenix']);
    Rental::factory()->create([
        'user_id' => $user->id,
        'fleet_id' => $car->id,
        'status' => 'active',
    ]);

    $response = $this->actingAs($user)->get('/returns');

    $response->assertStatus(200);
    $response->assertSee('Formulir Pengembalian Unit Mobil', false);
    $response->assertSee('Verifikasi Nomor Plat Kendaraan', false);
    $response->assertSee('B 2419 IND', false);
    $response->assertSee('Ajukan Serah Terima Pengembalian', false);
});

test('customer profile page loads with user data and SIM A verification', function () {
    $user = User::factory()->create([
        'name' => 'Budi Santoso',
        'role' => 'user',
        'driving_license_number' => '1234-5678-9012',
        'verification_status' => 'verified',
    ]);
    $response = $this->actingAs($user)->get('/profile');

    $response->assertStatus(200);
    $response->assertSee('Budi Santoso', false);
    $response->assertSee('SIM A Terverifikasi', false);
    $response->assertSee('1234-5678-9012', false);
});

test('admin rentals management loads with metrics and transaction table', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get('/admin/rentals');

    $response->assertStatus(200);
    $response->assertSee('Kelola Transaksi Sewa dan Pengembalian', false);
    $response->assertSee('Total Peminjaman', false);
});

test('admin users management loads with metrics and customer SIM list', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $customer = User::factory()->create([
        'name' => 'Budi Santoso',
        'driving_license_number' => '1234-5678-9012',
        'verification_status' => 'verified',
    ]);

    $response = $this->actingAs($admin)->get('/admin/users');

    $response->assertStatus(200);
    $response->assertSee('Kelola Pengguna', false);
    $response->assertSee('SIM A Terverifikasi', false);
    $response->assertSee('Budi Santoso', false);
    $response->assertSee('1234-5678-9012', false);
});

test('admin executive dashboard loads with financial metrics, fleet composition, and queues', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $customer = User::factory()->create([
        'name' => 'Budi Santoso',
        'verification_status' => 'verified',
    ]);
    $car = Fleet::factory()->create(['plate_number' => 'B 2419 IND', 'brand' => 'Toyota', 'model' => 'Innova Zenix']);
    Rental::factory()->create([
        'user_id' => $customer->id,
        'fleet_id' => $car->id,
        'rental_code' => 'IND-BK-202608-0091',
        'status' => 'completed',
        'total_price' => 1950000,
    ]);

    $response = $this->actingAs($admin)->get('/admin/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Pusat Kontrol Rental Indrasari', false);
    $response->assertSee('Total Pendapatan Selesai', false);
    $response->assertSee('Komposisi Status Operasional Armada Mobil', false);
    $response->assertSee('Antrean Pengembalian Fisik Unit', false);
    $response->assertSee('Antrean Verifikasi Legalitas SIM A', false);
    $response->assertSee('IND-BK-202608-0091', false);
});
