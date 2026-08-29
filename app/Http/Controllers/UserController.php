<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display the authenticated user's profile.
     */
    public function show(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $user->loadCount('rentals');

        return view('profile.index', [
            'user' => $user,
        ]);
    }

    /**
     * Update the authenticated user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20', Rule::unique('users', 'phone_number')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'address' => ['required', 'string', 'max:500'],
            'driving_license_number' => ['required', 'string', 'max:50', Rule::unique('users', 'driving_license_number')->ignore($user->id)],
            'driving_license_expiry_date' => ['required', 'date'],
            'driving_license_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone_number.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'phone_number.unique' => 'Nomor WhatsApp / HP sudah digunakan akun lain.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email sudah digunakan akun lain.',
            'address.required' => 'Alamat domisili lengkap wajib diisi.',
            'driving_license_number.required' => 'Nomor SIM A wajib diisi.',
            'driving_license_number.unique' => 'Nomor SIM A sudah digunakan akun lain.',
            'driving_license_expiry_date.required' => 'Masa berlaku SIM A wajib diisi.',
            'driving_license_photo.image' => 'Berkas foto SIM A harus berupa gambar.',
            'driving_license_photo.mimes' => 'Format gambar SIM A harus berupa JPG, JPEG, PNG, atau WEBP.',
            'driving_license_photo.max' => 'Ukuran berkas foto SIM A tidak boleh lebih dari 2MB.',
        ]);

        $userData = [
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'driving_license_number' => $validated['driving_license_number'],
            'driving_license_expiry_date' => $validated['driving_license_expiry_date'],
        ];

        $licenseChanged = $user->driving_license_number !== $validated['driving_license_number']
            || $user->driving_license_expiry_date?->format('Y-m-d') !== $validated['driving_license_expiry_date']
            || $request->hasFile('driving_license_photo');

        if ($licenseChanged && $user->role !== 'admin') {
            $userData['verification_status'] = 'pending';
        }

        if ($request->hasFile('driving_license_photo')) {
            if ($user->driving_license_photo && ! str_starts_with($user->driving_license_photo, 'http') && Storage::disk('public')->exists($user->driving_license_photo)) {
                Storage::disk('public')->delete($user->driving_license_photo);
            }
            $userData['driving_license_photo'] = $request->file('driving_license_photo')->store('driving_license', 'public');
        }

        $user->update($userData);

        return redirect()->route('profile.index')->with('success', 'Data profil Anda berhasil diperbarui.');
    }

    /**
     * Update the authenticated user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini tidak sesuai.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.index')->with('success_password', 'Kata sandi Anda berhasil diperbarui.');
    }

    /**
     * Display a listing of registered users and SIM verification queue (Admin).
     */
    public function adminIndex(Request $request): View
    {
        $query = User::query()->withCount([
            'rentals as total_rentals_count',
            'rentals as active_rentals_count' => function ($q) {
                $q->whereIn('status', ['active', 'pending_return']);
            },
        ]);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('driving_license_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('verification_status') && in_array($request->verification_status, ['verified', 'pending', 'rejected'])) {
            $query->where('verification_status', $request->verification_status);
        }

        if ($request->filled('role') && in_array($request->role, ['user', 'admin'])) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total_users' => User::count(),
            'verified_users' => User::where('verification_status', 'verified')->count(),
            'pending_users' => User::where('verification_status', 'pending')->count(),
            'rejected_users' => User::where('verification_status', 'rejected')->count(),
            'active_renters' => User::whereHas('rentals', function ($q) {
                $q->whereIn('status', ['active', 'pending_return']);
            })->count(),
        ];

        return view('admin.users.index', [
            'users' => $users,
            'stats' => $stats,
            'filters' => [
                'search' => $request->search ?? '',
                'verification_status' => $request->verification_status ?? 'all',
                'role' => $request->role ?? 'all',
            ],
        ]);
    }

    /**
     * Verify a user's driving license (SIM A).
     */
    public function verifySim(User $user): RedirectResponse
    {
        $user->update([
            'verification_status' => 'verified',
        ]);

        return redirect()->back()->with('success', "Dokumen SIM A milik {$user->name} berhasil diverifikasi.");
    }

    /**
     * Reject a user's driving license (SIM A) verification.
     */
    public function rejectSim(Request $request, User $user): RedirectResponse
    {
        $user->update([
            'verification_status' => 'rejected',
        ]);

        return redirect()->back()->with('success', "Verifikasi SIM A milik {$user->name} telah ditolak.");
    }

    /**
     * Update a user's role (user/admin).
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', Rule::in(['user', 'admin'])],
        ]);

        /** @var User $currentUser */
        $currentUser = Auth::user();

        if ($currentUser->id === $user->id && $validated['role'] !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak dapat mencabut hak akses administrator dari akun Anda sendiri.');
        }

        $user->update([
            'role' => $validated['role'],
        ]);

        $roleName = $validated['role'] === 'admin' ? 'Administrator' : 'Customer (Pelanggan)';

        return redirect()->back()->with('success', "Peran akun {$user->name} berhasil diperbarui menjadi {$roleName}.");
    }
}
