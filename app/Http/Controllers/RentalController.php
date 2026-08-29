<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RentalController extends Controller
{
    /**
     * Display a listing of the authenticated customer's rentals.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $activeRentals = $user->rentals()
            ->with('fleet')
            ->whereIn('status', ['pending', 'active', 'pending_return'])
            ->latest('created_at')
            ->get();

        $historyRentals = $user->rentals()
            ->with('fleet')
            ->whereIn('status', ['completed', 'cancelled'])
            ->latest('updated_at')
            ->get();

        return view('rentals.index', compact('activeRentals', 'historyRentals'));
    }

    /**
     * Store a newly created rental booking in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Gate: Verified Driver License (SIM A) required
        if (! $user->isVerified()) {
            return back()
                ->withInput()
                ->with('error', 'Pemesanan ditolak: Hanya pelanggan dengan SIM A terverifikasi yang dapat menyewa mobil. Silakan periksa status profil Anda.');
        }

        // 2. Validate input parameters
        $validated = $request->validate([
            'fleet_id' => ['required', 'integer', 'exists:fleets,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'notes' => ['nullable', 'string', 'max:500'],
        ], [
            'fleet_id.required' => 'Unit mobil wajib dipilih.',
            'fleet_id.exists' => 'Unit mobil yang dipilih tidak ditemukan dalam sistem.',
            'start_date.required' => 'Tanggal mulai sewa wajib diisi.',
            'start_date.date' => 'Format tanggal mulai sewa tidak valid.',
            'start_date.after_or_equal' => 'Tanggal mulai sewa tidak boleh di masa lalu.',
            'end_date.required' => 'Tanggal selesai sewa wajib diisi.',
            'end_date.date' => 'Format tanggal selesai sewa tidak valid.',
            'end_date.after_or_equal' => 'Tanggal selesai sewa harus sama atau setelah tanggal mulai sewa.',
            'notes.max' => 'Catatan sewa maksimal 500 karakter.',
        ]);

        $fleet = Fleet::findOrFail($validated['fleet_id']);

        // 3. Gate: Check vehicle maintenance status
        if ($fleet->availability === 'maintenance') {
            return back()
                ->withInput()
                ->with('error', 'Mobil '.$fleet->brand.' '.$fleet->model.' sedang dalam masa perawatan/bengkel dan tidak dapat dipesan.');
        }

        $startDate = Carbon::parse($validated['start_date'])->startOfDay()->format('Y-m-d');
        $endDate = Carbon::parse($validated['end_date'])->startOfDay()->format('Y-m-d');

        // 4. Gate: Interval Overlap Check (Allen's Interval Algebra)
        $isOverlapping = Rental::where('fleet_id', $fleet->id)
            ->whereIn('status', ['pending', 'active', 'pending_return'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate);
            })
            ->exists();

        if ($isOverlapping) {
            return back()
                ->withInput()
                ->with('error', 'Mobil '.$fleet->brand.' '.$fleet->model.' sudah memiliki jadwal sewa pada rentang tanggal '.Carbon::parse($startDate)->format('d/m/Y').' s.d. '.Carbon::parse($endDate)->format('d/m/Y').'. Silakan pilih tanggal lain.');
        }

        // 5. Calculations
        $totalDays = Rental::calculateInclusiveDays($startDate, $endDate);
        $dailyRate = (float) $fleet->price;
        $totalPrice = Rental::calculateTotalPrice($dailyRate, $totalDays);
        $rentalCode = Rental::generateRentalCode();

        // 6. Persistence within DB Transaction
        $rental = DB::transaction(function () use ($user, $fleet, $startDate, $endDate, $dailyRate, $totalDays, $totalPrice, $rentalCode, $validated) {
            $rentalRecord = Rental::create([
                'rental_code' => $rentalCode,
                'user_id' => $user->id,
                'fleet_id' => $fleet->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'return_date' => null,
                'daily_rate' => (string) $dailyRate,
                'total_days' => $totalDays,
                'total_price' => (string) $totalPrice,
                'penalty_price' => '0',
                'status' => 'active',
                'notes' => $validated['notes'] ?? null,
            ]);

            $fleet->update(['availability' => 'rented']);

            return $rentalRecord;
        });

        return redirect()->route('rentals.index')->with('success', 'Pemesanan mobil '.$fleet->brand.' '.$fleet->model.' berhasil dikonfirmasi! Kode Booking: '.$rental->rental_code);
    }

    /**
     * Cancel an upcoming rental reservation.
     */
    public function cancel(Request $request, Rental $rental): RedirectResponse
    {
        $user = $request->user();

        // Authorization check
        if ($rental->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403, 'Akses Terlarang: Anda tidak berhak membatalkan pesanan ini.');
        }

        if (! $rental->isCancellable()) {
            return back()->with('error', 'Pesanan sewa ini tidak dapat dibatalkan karena periode sewa sudah berjalan atau telah selesai.');
        }

        DB::transaction(function () use ($rental) {
            $rental->update(['status' => 'cancelled']);

            // If no other active booking exists for this car, reset availability to available
            $hasOtherActive = Rental::where('fleet_id', $rental->fleet_id)
                ->where('id', '!=', $rental->id)
                ->whereIn('status', ['active', 'pending_return'])
                ->exists();

            if (! $hasOtherActive) {
                $rental->fleet->update(['availability' => 'available']);
            }
        });

        return redirect()->route('rentals.index')->with('success', 'Pesanan sewa dengan kode '.$rental->rental_code.' berhasil dibatalkan.');
    }
}
