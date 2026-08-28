<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'customer',
            'email' => 'customer@example.com',
            'driving_license_number' => '1234567890123456',
            'driving_license_expiry_date' => '2026-12-31',
            'driving_license_photo' => 'public/storage/driving_license/driving_license_photo.jpg',
            'phone_number' => '081234567891',
            'address' => '123 Main St',
            'role' => 'user',
            'verification_status' => 'verified',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@rsudindrasari.com',
            'driving_license_number' => '9876543210987654',
            'driving_license_expiry_date' => '2026-12-31',
            'driving_license_photo' => 'public/storage/driving_license/driving_license_photo.jpg',
            'phone_number' => '081234567890',
            'address' => 'RSUD Indrasari, Pematang Reba, Rengat Barat, Indragiri Hulu Regency, Riau 29351',
            'role' => 'admin',
            'verification_status' => 'verified',
            'password' => Hash::make('password'),
        ]);
    }
}
