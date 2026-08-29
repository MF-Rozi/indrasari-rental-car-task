<?php

namespace Database\Seeders;

use App\Models\Fleet;
use Illuminate\Database\Seeder;

class FleetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fleets = [
            [
                'brand' => 'Mazda',
                'type' => 'SUV',
                'model' => 'CX-60 3.3L Kuro AWD',
                'year' => '2024',
                'color' => 'Soul Red Crystal',
                'plate_number' => 'B 3300 MZD',
                'transmission' => 'Automatic',
                'fuel_type' => 'Hybrid',
                'seat_capacity' => '5',
                'price' => '1250000',
                'availability' => 'available',
                'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            [
                'brand' => 'Toyota',
                'type' => 'MPV',
                'model' => 'Innova Zenix 2.0 Q Hybrid',
                'year' => '2024',
                'color' => 'Putih Mutiara',
                'plate_number' => 'B 2419 IND',
                'transmission' => 'Automatic',
                'fuel_type' => 'Hybrid',
                'seat_capacity' => '7',
                'price' => '650000',
                'availability' => 'available',
                'image' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            [
                'brand' => 'Mitsubishi',
                'type' => 'SUV',
                'model' => 'Pajero Sport Dakar 4x2',
                'year' => '2023',
                'color' => 'Hitam Metalik',
                'plate_number' => 'B 1888 MFS',
                'transmission' => 'Automatic',
                'fuel_type' => 'Diesel',
                'seat_capacity' => '7',
                'price' => '800000',
                'availability' => 'available',
                'image' => 'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'brand' => 'Toyota',
                'type' => 'Luxury',
                'model' => 'Alphard 2.5 G Executive',
                'year' => '2024',
                'color' => 'Hitam Metalik',
                'plate_number' => 'B 1 IND',
                'transmission' => 'Automatic',
                'fuel_type' => 'Bensin',
                'seat_capacity' => '7',
                'price' => '1750000',
                'availability' => 'available',
                'image' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80',
                'images' => [
                    'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80',
                    'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=1200&q=80',
                ],
            ],
            [
                'brand' => 'Honda',
                'type' => 'SUV',
                'model' => 'HR-V 1.5 SE RS',
                'year' => '2023',
                'color' => 'Merah Solid',
                'plate_number' => 'B 2034 HND',
                'transmission' => 'Automatic',
                'fuel_type' => 'Bensin',
                'seat_capacity' => '5',
                'price' => '500000',
                'availability' => 'available',
                'image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'brand' => 'Hyundai',
                'type' => 'Electric',
                'model' => 'IONIQ 5 Signature Long Range',
                'year' => '2024',
                'color' => 'Gravity Gold Matte',
                'plate_number' => 'B 1055 EV',
                'transmission' => 'Automatic',
                'fuel_type' => 'Listrik',
                'seat_capacity' => '5',
                'price' => '950000',
                'availability' => 'available',
                'image' => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'brand' => 'Toyota',
                'type' => 'MPV',
                'model' => 'Avanza 1.5 G TSS',
                'year' => '2023',
                'color' => 'Silver Metalik',
                'plate_number' => 'B 1492 AVZ',
                'transmission' => 'Manual',
                'fuel_type' => 'Bensin',
                'seat_capacity' => '7',
                'price' => '350000',
                'availability' => 'available',
                'image' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'brand' => 'Mitsubishi',
                'type' => 'MPV',
                'model' => 'Xpander Ultimate',
                'year' => '2023',
                'color' => 'Abu-abu Metalik',
                'plate_number' => 'B 2731 XPD',
                'transmission' => 'Automatic',
                'fuel_type' => 'Bensin',
                'seat_capacity' => '7',
                'price' => '375000',
                'availability' => 'available',
                'image' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'brand' => 'Honda',
                'type' => 'SUV',
                'model' => 'CR-V 2.0 RS e:HEV',
                'year' => '2024',
                'color' => 'Platinum White Pearl',
                'plate_number' => 'B 1999 CRV',
                'transmission' => 'Automatic',
                'fuel_type' => 'Hybrid',
                'seat_capacity' => '7',
                'price' => '900000',
                'availability' => 'available',
                'image' => 'https://images.unsplash.com/photo-1590362891991-f776e747a588?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'brand' => 'Hyundai',
                'type' => 'MPV',
                'model' => 'Stargazer Prime IVT',
                'year' => '2023',
                'color' => 'Putih Mutiara',
                'plate_number' => 'B 2108 HYU',
                'transmission' => 'Automatic',
                'fuel_type' => 'Bensin',
                'seat_capacity' => '7',
                'price' => '360000',
                'availability' => 'available',
                'image' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'brand' => 'Daihatsu',
                'type' => 'SUV',
                'model' => 'Terios 1.5 R Custom',
                'year' => '2022',
                'color' => 'Hitam Metalik',
                'plate_number' => 'B 1765 TRS',
                'transmission' => 'Manual',
                'fuel_type' => 'Bensin',
                'seat_capacity' => '7',
                'price' => '400000',
                'availability' => 'maintenance', // 1 in maintenance
                'image' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=1200&q=80',
            ],
        ];

        foreach ($fleets as $fleet) {
            Fleet::updateOrCreate(
                ['plate_number' => $fleet['plate_number']],
                $fleet
            );
        }
    }
}
