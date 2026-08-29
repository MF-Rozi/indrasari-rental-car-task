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
        // 1. Super Admin
        User::factory()->create([
            'name' => 'Admin Indrasari',
            'email' => 'admin@rsudindrasari.com',
            'driving_license_number' => '9876543210987654',
            'driving_license_expiry_date' => '2028-12-31',
            'driving_license_photo' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=800&q=80',
            'phone_number' => '081234567890',
            'address' => 'RSUD Indrasari, Pematang Reba, Rengat Barat, Kab. Indragiri Hulu, Riau 29351',
            'role' => 'admin',
            'verification_status' => 'verified',
            'password' => Hash::make('password'),
        ]);

        // 2. Default Verified Customer
        User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'customer@example.com',
            'driving_license_number' => '1234567890123456',
            'driving_license_expiry_date' => '2027-08-15',
            'driving_license_photo' => 'https://images.unsplash.com/photo-1628157582853-a796fa650a6a?auto=format&fit=crop&w=800&q=80',
            'phone_number' => '081234567891',
            'address' => 'Jl. Sudirman No. 45, Pekanbaru, Riau',
            'role' => 'user',
            'verification_status' => 'verified',
            'password' => Hash::make('password'),
        ]);

        // 3. Pending SIM Verification Customer 1
        User::factory()->create([
            'name' => 'Hendra Pratama',
            'email' => 'hendra.pratama@gmail.com',
            'driving_license_number' => '3201123456780001',
            'driving_license_expiry_date' => '2028-05-20',
            'driving_license_photo' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=800&q=80',
            'phone_number' => '081922334455',
            'address' => 'Jl. Diponegoro No. 18, Rengat Barat, Inhu',
            'role' => 'user',
            'verification_status' => 'pending',
            'password' => Hash::make('password'),
        ]);

        // 4. Verified Customer 2
        User::factory()->create([
            'name' => 'Siti Rahmawati',
            'email' => 'siti.rahmawati@yahoo.com',
            'driving_license_number' => '3174987654320002',
            'driving_license_expiry_date' => '2026-11-10',
            'driving_license_photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=800&q=80',
            'phone_number' => '081388776655',
            'address' => 'Jl. Tuanku Tambusai No. 88, Pekanbaru',
            'role' => 'user',
            'verification_status' => 'verified',
            'password' => Hash::make('password'),
        ]);

        // 5. Rejected SIM Customer
        User::factory()->create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi.lestari@gmail.com',
            'driving_license_number' => '3273112233440003',
            'driving_license_expiry_date' => '2023-01-01',
            'driving_license_photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=800&q=80',
            'phone_number' => '082199887766',
            'address' => 'Jl. Hangtuah No. 12, Pematang Reba',
            'role' => 'user',
            'verification_status' => 'rejected',
            'password' => Hash::make('password'),
        ]);

        // 6. Pending SIM Verification Customer 2
        User::factory()->create([
            'name' => 'Rizky Ramadhan',
            'email' => 'rizky.ramadhan@gmail.com',
            'driving_license_number' => '3515887766550004',
            'driving_license_expiry_date' => '2029-03-25',
            'driving_license_photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80',
            'phone_number' => '085711223344',
            'address' => 'Jl. Lintas Timur Sumatera KM 180, Inhu',
            'role' => 'user',
            'verification_status' => 'pending',
            'password' => Hash::make('password'),
        ]);
    }
}
