<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the executive customer dashboard with active booking, metrics, and recent history.
     */
    public function customerDashboard(Request $request): View
    {
        $user = $request->user();

        // 1. Fetch Primary Active or In-Progress Rental
        $activeRental = $user->rentals()
            ->with('fleet')
            ->whereIn('status', ['pending', 'active', 'pending_return'])
            ->latest('created_at')
            ->first();

        $activeSettlement = $activeRental ? $activeRental->calculateSettlementSummary() : null;

        // 2. Personal Customer Statistics
        $stats = [
            'total_bookings' => $user->rentals()->count(),
            'active_count' => $user->rentals()->whereIn('status', ['pending', 'active', 'pending_return'])->count(),
            'completed_count' => $user->rentals()->where('status', 'completed')->count(),
            'total_spent' => (float) $user->rentals()
                ->where('status', 'completed')
                ->sum(DB::raw('total_price + COALESCE(penalty_price, 0)')),
        ];

        // 3. Quick Recent Bookings History (latest 4)
        $recentRentals = $user->rentals()
            ->with('fleet')
            ->latest('created_at')
            ->take(4)
            ->get();

        return view('dashboard.index', compact('user', 'activeRental', 'activeSettlement', 'stats', 'recentRentals'));
    }

    /**
     * Display the operational executive central dashboard for administrators.
     */
    public function adminDashboard(Request $request): View
    {
        // 1. Aggregate Financial & Transaction Metrics
        $stats = [
            'total_revenue' => (float) Rental::where('status', 'completed')
                ->sum(DB::raw('total_price + COALESCE(penalty_price, 0)')),
            'monthly_revenue' => (float) Rental::where('status', 'completed')
                ->whereMonth('return_date', now()->month)
                ->whereYear('return_date', now()->year)
                ->sum(DB::raw('total_price + COALESCE(penalty_price, 0)')),
            'total_rentals' => Rental::count(),
            'active_rentals' => Rental::where('status', 'active')->count(),
            'pending_return_rentals' => Rental::where('status', 'pending_return')->count(),
            'completed_rentals' => Rental::where('status', 'completed')->count(),
        ];

        // 2. Fleet Availability Breakdown
        $fleetStats = [
            'total_fleets' => Fleet::count(),
            'available_fleets' => Fleet::where('availability', 'available')->count(),
            'rented_fleets' => Fleet::where('availability', 'rented')->count(),
            'maintenance_fleets' => Fleet::where('availability', 'maintenance')->count(),
        ];

        // 3. User SIM Verification Breakdown
        $userStats = [
            'total_users' => User::where('role', 'user')->count(),
            'verified_users' => User::where('role', 'user')->where('verification_status', 'verified')->count(),
            'pending_users' => User::where('role', 'user')->where('verification_status', 'pending')->count(),
            'rejected_users' => User::where('role', 'user')->where('verification_status', 'rejected')->count(),
        ];

        // 4. Action Required Queues
        $pendingReturns = Rental::with(['user', 'fleet'])
            ->where('status', 'pending_return')
            ->latest('updated_at')
            ->take(5)
            ->get();

        $pendingVerifications = User::where('role', 'user')
            ->where('verification_status', 'pending')
            ->latest('created_at')
            ->take(5)
            ->get();

        // 5. Recent System-wide Transactions (latest 5)
        $recentRentals = Rental::with(['user', 'fleet'])
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'stats',
            'fleetStats',
            'userStats',
            'pendingReturns',
            'pendingVerifications',
            'recentRentals'
        ));
    }
}
