<?php

namespace Database\Factories;

use App\Models\Fleet;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rental>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = Carbon::now()->subDays(fake()->numberBetween(1, 10));
        $totalDays = fake()->numberBetween(2, 7);
        $endDate = (clone $startDate)->addDays($totalDays - 1);
        $dailyRate = 650000;
        $totalPrice = $dailyRate * $totalDays;

        return [
            'user_id' => User::factory(),
            'fleet_id' => Fleet::factory(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'return_date' => null,
            'daily_rate' => (string) $dailyRate,
            'total_days' => $totalDays,
            'total_price' => (string) $totalPrice,
            'penalty_price' => '0',
            'status' => 'active',
            'notes' => 'Rental pemesanan via sistem.',
        ];
    }

    /**
     * State for active rental.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'return_date' => null,
            'penalty_price' => '0',
        ]);
    }

    /**
     * State for pending return rental.
     */
    public function pendingReturn(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending_return',
            'return_date' => Carbon::now()->format('Y-m-d'),
            'penalty_price' => '0',
        ]);
    }

    /**
     * State for completed rental.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'return_date' => Carbon::now()->format('Y-m-d'),
        ]);
    }
}
