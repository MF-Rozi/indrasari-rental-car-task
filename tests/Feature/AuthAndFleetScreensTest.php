<?php

test('home page renders successfully with hero and fleet preview', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('INDRASARI');
    $response->assertSee('Armada Mobil Unggulan');
    $response->assertSee('Innova Zenix');
});

test('auth page renders with login and registration forms and required ID fields', function () {
    $response = $this->get('/auth');

    $response->assertStatus(200);
    $response->assertSee('Selamat Datang di Indrasari');
    $response->assertSee('Nomor SIM A');
    $response->assertSee('Alamat Domisili Lengkap');
    $response->assertSee('Nomor Telepon');
});

test('fleet catalog page renders with search filters and car grid', function () {
    $response = $this->get('/fleet');

    $response->assertStatus(200);
    $response->assertSee('Pilih Armada Mobil Anda');
    $response->assertSee('Filter Pencarian');
    $response->assertSee('Toyota Alphard');
    $response->assertSee('Innova Zenix');
});

test('fleet show page renders with specs and interactive booking estimator', function () {
    $response = $this->get('/fleet/1');

    $response->assertStatus(200);
    $response->assertSee('Toyota Innova Zenix');
    $response->assertSee('Spesifikasi Lengkap');
    $response->assertSee('Persyaratan');
    $response->assertSee('Pesan Mobil Ini Sekarang');
});

test('admin fleet index renders management table and metrics', function () {
    $response = $this->get('/admin/cars');

    $response->assertStatus(200);
    $response->assertSee('Manajemen Armada Mobil');
    $response->assertSee('Total Mobil');
    $response->assertSee('Tambah Mobil Baru');
    $response->assertSee('B 2419 IND');
});

test('admin create car page renders with complete vehicle attributes form', function () {
    $response = $this->get('/admin/cars/create');

    $response->assertStatus(200);
    $response->assertSee('Spesifikasi Unit Kendaraan');
    $response->assertSee('Merek Mobil');
    $response->assertSee('Nomor Plat Polisi');
    $response->assertSee('Tarif Sewa / Hari');
    $response->assertSee('Simpan Data Mobil');
});
