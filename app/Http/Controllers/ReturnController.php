<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReturnController extends Controller
{
    /**
     * Display the car return submission page for the authenticated customer.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $activeRentals = $user->rentals()
            ->with('fleet')
            ->whereIn('status', ['active', 'pending_return'])
            ->latest('created_at')
            ->get();

        $selectedRental = null;
        $settlement = null;

        $requestedPlate = $request->query('plate');
        if ($requestedPlate) {
            $normalizedRequested = strtoupper(preg_replace('/\s+/', '', (string) $requestedPlate));
            $selectedRental = $activeRentals->first(function ($rental) use ($normalizedRequested) {
                $normalizedPlate = strtoupper(preg_replace('/\s+/', '', (string) $rental->fleet->plate_number));

                return $normalizedPlate === $normalizedRequested;
            });

            if ($selectedRental) {
                $settlement = $selectedRental->calculateSettlementSummary();
            }
        } elseif ($activeRentals->isNotEmpty()) {
            $selectedRental = $activeRentals->first();
            $settlement = $selectedRental->calculateSettlementSummary();
        }

        return view('returns.index', compact('activeRentals', 'selectedRental', 'settlement'));
    }

    /**
     * Verify a license plate number for return and return its financial & schedule dossier.
     */
    public function verify(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'plate_number' => ['required', 'string'],
        ], [
            'plate_number.required' => 'Nomor plat kendaraan wajib diisi.',
        ]);

        $user = $request->user();
        $normalizedInput = strtoupper(preg_replace('/\s+/', '', (string) $validated['plate_number']));

        $activeRentals = $user->rentals()
            ->with('fleet')
            ->whereIn('status', ['active', 'pending_return'])
            ->get();

        $matchedRental = $activeRentals->first(function ($rental) use ($normalizedInput) {
            $normalizedPlate = strtoupper(preg_replace('/\s+/', '', (string) $rental->fleet->plate_number));

            return $normalizedPlate === $normalizedInput;
        });

        if (! $matchedRental) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kendaraan dengan nomor plat "'.$validated['plate_number'].'" tidak ditemukan di daftar sewa aktif akun Anda.',
                ], 404);
            }

            return back()->withInput()->with('error', 'Kendaraan dengan nomor plat "'.$validated['plate_number'].'" tidak ditemukan di daftar sewa aktif akun Anda.');
        }

        $settlement = $matchedRental->calculateSettlementSummary();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'rental' => [
                    'id' => $matchedRental->id,
                    'rental_code' => $matchedRental->rental_code,
                    'status' => $matchedRental->status,
                    'start_date' => $matchedRental->start_date->format('Y-m-d'),
                    'start_date_formatted' => $matchedRental->start_date->format('d M Y'),
                    'end_date' => $matchedRental->end_date->format('Y-m-d'),
                    'end_date_formatted' => $matchedRental->end_date->format('d M Y'),
                    'total_days' => $matchedRental->total_days,
                    'daily_rate' => (float) $matchedRental->daily_rate,
                    'total_price' => (float) $matchedRental->total_price,
                    'notes' => $matchedRental->notes,
                    'fleet' => [
                        'id' => $matchedRental->fleet->id,
                        'brand' => $matchedRental->fleet->brand,
                        'model' => $matchedRental->fleet->model,
                        'full_name' => $matchedRental->fleet->full_name,
                        'plate_number' => $matchedRental->fleet->plate_number,
                        'transmission' => $matchedRental->fleet->transmission,
                        'fuel_type' => $matchedRental->fleet->fuel_type,
                        'color' => $matchedRental->fleet->color,
                        'image_url' => $matchedRental->fleet->image_url,
                    ],
                ],
                'settlement' => $settlement,
            ]);
        }

        return redirect()->route('returns.index', ['plate' => $matchedRental->fleet->plate_number]);
    }

    /**
     * Submit a car return request from customer to initiate physical inspection.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'rental_id' => ['required', 'integer', 'exists:rentals,id'],
            'return_notes' => ['nullable', 'string', 'max:500'],
        ], [
            'rental_id.required' => 'ID pesanan sewa wajib disertakan.',
            'rental_id.exists' => 'Data peminjaman mobil tidak ditemukan.',
            'return_notes.max' => 'Catatan serah terima maksimal 500 karakter.',
        ]);

        $rental = Rental::with('fleet')
            ->where('id', $validated['rental_id'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($rental->status === 'completed') {
            return redirect()->route('rentals.index')->with('info', 'Transaksi sewa ini sudah selesai dikembalikan sebelumnya.');
        }

        $returnDate = now();
        $penalty = $rental->calculateLateFee($returnDate);

        $notes = $rental->notes;
        if (! empty($validated['return_notes'])) {
            $notes = $notes ? $notes."\n[Catatan Pengembalian Pelanggan: ".$validated['return_notes'].']' : 'Catatan Pengembalian Pelanggan: '.$validated['return_notes'];
        }

        $rental->update([
            'status' => 'pending_return',
            'return_date' => $returnDate->toDateString(),
            'penalty_price' => (string) $penalty,
            'notes' => $notes,
        ]);

        return redirect()->route('rentals.index')->with('success', 'Pengajuan pengembalian mobil '.$rental->fleet->brand.' '.$rental->fleet->model.' ('.$rental->fleet->plate_number.') berhasil dikirim! Silakan lakukan serah terima fisik unit kepada staf operasional RSUD Indrasari.');
    }
}
