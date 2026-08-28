<?php

test('homepage loads successfully with hero and featured cars', function () {
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

test('login and register routes redirect to auth page with tab parameters', function () {
    $loginResponse = $this->get('/login');
    $loginResponse->assertRedirect(route('auth', ['tab' => 'signin']));

    $registerResponse = $this->get('/register');
    $registerResponse->assertRedirect(route('auth', ['tab' => 'register']));
});

test('dedicated customer dashboard loads with active booking and stats', function () {
    $response = $this->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Selamat Datang, Budi Santoso', false);
    $response->assertSee('Sewa Aktif Saat Ini', false);
    $response->assertSee('B 2419 IND', false);
    $response->assertSee('Kembalikan Unit Ini', false);
});

test('fleet catalog loads with filters and car list', function () {
    $response = $this->get('/fleet');

    $response->assertStatus(200);
    $response->assertSee('Pilih Armada Mobil Anda', false);
    $response->assertSee('Filter Pencarian', false);
    $response->assertSee('Innova Zenix 2.0 Q Hybrid', false);
    $response->assertSee('Pajero Sport Dakar 4x2', false);
});

test('fleet detail page loads with vehicle specs and live pricing calculator', function () {
    $response = $this->get('/fleet/1');

    $response->assertStatus(200);
    $response->assertSee('Toyota Innova Zenix 2.0 Q Hybrid', false);
    $response->assertSee('Fitur & Performa Kendaraan', false);
    $response->assertSee('Pesan Mobil Ini Sekarang', false);
});

test('admin executive dashboard loads with revenue, utilization and live rentals monitor', function () {
    $response = $this->get('/admin');

    $response->assertStatus(200);
    $response->assertSee('Pusat Kontrol Rental Indrasari', false);
    $response->assertSee('Pendapatan Bulan Ini', false);
    $response->assertSee('Monitoring Unit Sedang Disewa', false);
    $response->assertSee('Antrean Verifikasi SIM A', false);
});

test('admin cars index loads with metric badges and vehicle table', function () {
    $response = $this->get('/admin/cars');

    $response->assertStatus(200);
    $response->assertSee('Manajemen Armada Mobil', false);
    $response->assertSee('Tambah Mobil Baru', false);
    $response->assertSee('Toyota Innova Zenix 2.0 Q', false);
});

test('admin car create page loads with all required specification fields', function () {
    $response = $this->get('/admin/cars/create');

    $response->assertStatus(200);
    $response->assertSee('Informasi & Spesifikasi Unit Kendaraan', false);
    $response->assertSee('Nomor Plat Polisi', false);
    $response->assertSee('Tarif Sewa / Hari (IDR)', false);
});

test('customer rentals page loads with active and completed rental tabs', function () {
    $response = $this->get('/rentals');

    $response->assertStatus(200);
    $response->assertSee('Daftar Sewa Mobil Saya', false);
    $response->assertSee('Sedang Disewa (Aktif)', false);
    $response->assertSee('Toyota Innova Zenix 2.0 Q Hybrid', false);
    $response->assertSee('B 2419 IND', false);
});

test('car returns page loads with plate verification and cost calculation', function () {
    $response = $this->get('/returns');

    $response->assertStatus(200);
    $response->assertSee('Formulir Pengembalian Unit Mobil', false);
    $response->assertSee('Verifikasi Nomor Plat Kendaraan', false);
    $response->assertSee('B 2419 IND', false);
    $response->assertSee('Konfirmasi dan Selesaikan Pengembalian', false);
});

test('customer profile page loads with user data and SIM A verification', function () {
    $response = $this->get('/profile');

    $response->assertStatus(200);
    $response->assertSee('Budi Santoso', false);
    $response->assertSee('SIM A Terverifikasi', false);
    $response->assertSee('1234-5678-9012', false);
});

test('admin rentals management loads with metrics and transaction table', function () {
    $response = $this->get('/admin/rentals');

    $response->assertStatus(200);
    $response->assertSee('Kelola Transaksi Sewa dan Pengembalian', false);
    $response->assertSee('IND-BK-0091', false);
    $response->assertSee('Sedang Disewa', false);
    $response->assertSee('Verifikasi Kembali', false);
});

test('admin users management loads with metrics and customer SIM list', function () {
    $response = $this->get('/admin/users');

    $response->assertStatus(200);
    $response->assertSee('Kelola Pengguna', false);
    $response->assertSee('SIM A Terverifikasi', false);
    $response->assertSee('Budi Santoso', false);
    $response->assertSee('1234-5678-9012', false);
});
