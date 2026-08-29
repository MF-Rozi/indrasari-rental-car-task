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

    /**
     * Display a listing of all customer rental transactions for administrators.
     */
    public function adminIndex(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $query = Rental::with(['user', 'fleet'])->latest('created_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('rental_code', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('fleet', function ($fq) use ($search) {
                        $fq->where('brand', 'like', "%{$search}%")
                            ->orWhere('model', 'like', "%{$search}%")
                            ->orWhere('plate_number', 'like', "%{$search}%");
                    });
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $rentals = $query->paginate(10)->withQueryString();

        $stats = [
            'total_rentals' => Rental::count(),
            'active_rentals' => Rental::where('status', 'active')->count(),
            'pending_return_rentals' => Rental::where('status', 'pending_return')->count(),
            'completed_rentals' => Rental::where('status', 'completed')->count(),
            'total_revenue' => (float) Rental::where('status', 'completed')->sum(DB::raw('total_price + COALESCE(penalty_price, 0)')),
        ];

        $filters = [
            'search' => $search,
            'status' => $status ?? 'all',
        ];

        return view('admin.rentals.index', compact('rentals', 'stats', 'filters'));
    }

    /**
     * Confirm and complete vehicle physical return by an administrator.
     */
    public function adminConfirmReturn(Request $request, Rental $rental): RedirectResponse
    {
        if (! in_array($rental->status, ['active', 'pending_return'], true)) {
            return back()->with('error', 'Transaksi sewa ini tidak dalam status yang dapat dikonfirmasi pengembaliannya.');
        }

        $validated = $request->validate([
            'penalty_price' => ['nullable', 'numeric', 'min:0'],
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $returnDate = now();
        $autoPenalty = $rental->calculateLateFee($returnDate);
        $finalPenalty = isset($validated['penalty_price']) && is_numeric($validated['penalty_price'])
            ? (float) $validated['penalty_price']
            : $autoPenalty;

        DB::transaction(function () use ($rental, $returnDate, $finalPenalty, $validated) {
            $rental->update([
                'status' => 'completed',
                'return_date' => $returnDate->toDateString(),
                'penalty_price' => (string) $finalPenalty,
                'admin_notes' => $validated['admin_notes'] ?? null,
            ]);

            // Set car back to available
            $rental->fleet->update(['availability' => 'available']);
        });

        return redirect()->route('admin.rentals.index')->with('success', 'Pengembalian unit mobil '.$rental->fleet->brand.' '.$rental->fleet->model.' ('.$rental->fleet->plate_number.') berhasil diverifikasi! Transaksi telah selesai dan armada kembali Tersedia.');
    }
}
