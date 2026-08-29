<?php

namespace Database\Factories;

use App\Models\Fleet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fleet>
 */
class FleetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = [
            'Toyota' => [
                ['model' => 'Avanza 1.5 G TSS', 'type' => 'MPV', 'seats' => '7', 'fuel' => 'Bensin', 'price' => '350000', 'image' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=1200&q=80'],
                ['model' => 'Innova Zenix 2.0 Q Hybrid', 'type' => 'MPV', 'seats' => '7', 'fuel' => 'Hybrid', 'price' => '650000', 'image' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80'],
                ['model' => 'Fortuner 2.8 GR Sport', 'type' => 'SUV', 'seats' => '7', 'fuel' => 'Diesel', 'price' => '850000', 'image' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=1200&q=80'],
                ['model' => 'Alphard 2.5 G Executive', 'type' => 'Luxury', 'seats' => '7', 'fuel' => 'Bensin', 'price' => '1750000', 'image' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80'],
            ],
            'Mitsubishi' => [
                ['model' => 'Xpander Ultimate', 'type' => 'MPV', 'seats' => '7', 'fuel' => 'Bensin', 'price' => '375000', 'image' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80'],
                ['model' => 'Pajero Sport Dakar 4x2', 'type' => 'SUV', 'seats' => '7', 'fuel' => 'Diesel', 'price' => '800000', 'image' => 'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=1200&q=80'],
            ],
            'Honda' => [
                ['model' => 'HR-V 1.5 SE RS', 'type' => 'SUV', 'seats' => '5', 'fuel' => 'Bensin', 'price' => '500000', 'image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1200&q=80'],
                ['model' => 'CR-V 2.0 RS e:HEV', 'type' => 'SUV', 'seats' => '7', 'fuel' => 'Hybrid', 'price' => '900000', 'image' => 'https://images.unsplash.com/photo-1590362891991-f776e747a588?auto=format&fit=crop&w=1200&q=80'],
            ],
            'Hyundai' => [
                ['model' => 'IONIQ 5 Signature Long Range', 'type' => 'Electric', 'seats' => '5', 'fuel' => 'Listrik', 'price' => '950000', 'image' => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?auto=format&fit=crop&w=1200&q=80'],
                ['model' => 'Stargazer Prime IVT', 'type' => 'MPV', 'seats' => '7', 'fuel' => 'Bensin', 'price' => '360000', 'image' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=1200&q=80'],
            ],
        ];

        $brandKey = fake()->randomElement(array_keys($brands));
        $carItem = fake()->randomElement($brands[$brandKey]);

        return [
            'brand' => $brandKey,
            'type' => $carItem['type'],
            'model' => $carItem['model'],
            'year' => (string) fake()->numberBetween(2022, 2024),
            'color' => fake()->randomElement(['Hitam Metalik', 'Putih Mutiara', 'Abu-abu Metalik', 'Silver']),
            'plate_number' => fake()->unique()->regexify('B [1-9]{4} [A-Z]{2,3}'),
            'transmission' => fake()->randomElement(['Automatic', 'Manual']),
            'fuel_type' => $carItem['fuel'],
            'seat_capacity' => (string) $carItem['seats'],
            'price' => (string) $carItem['price'],
            'availability' => 'available',
            'image' => $carItem['image'],
        ];
    }

    /**
     * Indicate that the fleet is in maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'availability' => 'maintenance',
        ]);
    }

    /**
     * Indicate that the fleet is currently rented.
     */
    public function rented(): static
    {
        return $this->state(fn (array $attributes) => [
            'availability' => 'rented',
        ]);
    }
}
