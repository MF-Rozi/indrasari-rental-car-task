<?php

namespace Database\Seeders;

use App\Models\Fleet;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::where('email', 'customer@example.com')->first();
        if (! $customer) {
            $customer = User::first();
        }

        // 1. Rental 1: Active rental
        $fleet1 = Fleet::where('plate_number', 'B 2419 IND')->first() ?? Fleet::first();
        if ($fleet1) {
            $fleet1->update(['availability' => 'rented']);

            $startDate1 = Carbon::now()->subDays(2)->format('Y-m-d');
            $endDate1 = Carbon::now()->addDays(2)->format('Y-m-d');
            $totalDays1 = 5;
            $dailyRate1 = (int) ($fleet1->price ?? 650000);
            $totalPrice1 = $dailyRate1 * $totalDays1;

            Rental::create([
                'user_id' => $customer->id,
                'fleet_id' => $fleet1->id,
                'start_date' => $startDate1,
                'end_date' => $endDate1,
                'return_date' => null,
                'daily_rate' => (string) $dailyRate1,
                'total_days' => $totalDays1,
                'total_price' => (string) $totalPrice1,
                'penalty_price' => '0',
                'status' => 'active',
                'notes' => 'Penyewaan aktif untuk perjalanan dinas keluar kota.',
            ]);
        }

        // 2. Rental 2: Pending return rental
        $fleet2 = Fleet::where('plate_number', 'B 2731 XPD')->first() ?? Fleet::skip(1)->first();
        if ($fleet2) {
            $fleet2->update(['availability' => 'rented']);

            $startDate2 = Carbon::now()->subDays(4)->format('Y-m-d');
            $endDate2 = Carbon::now()->format('Y-m-d');
            $totalDays2 = 5;
            $dailyRate2 = (int) ($fleet2->price ?? 375000);
            $totalPrice2 = $dailyRate2 * $totalDays2;

            Rental::create([
                'user_id' => $customer->id,
                'fleet_id' => $fleet2->id,
                'start_date' => $startDate2,
                'end_date' => $endDate2,
                'return_date' => Carbon::now()->format('Y-m-d'),
                'daily_rate' => (string) $dailyRate2,
                'total_days' => $totalDays2,
                'total_price' => (string) $totalPrice2,
                'penalty_price' => '0',
                'status' => 'pending_return',
                'notes' => 'Pengajuan pengembalian unit telah dikirim oleh customer, menunggu inspeksi admin.',
            ]);
        }
    }
}
