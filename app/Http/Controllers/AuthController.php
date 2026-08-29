<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the login page.
     */
    public function login(): View|RedirectResponse
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            return $this->redirectBasedOnRole($user);
        }

        return view('auth.auth', [
            'tab' => 'signin',
        ]);
    }

    /**
     * Show the registration page.
     */
    public function register(): View|RedirectResponse
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            return $this->redirectBasedOnRole($user);
        }

        return view('auth.auth', [
            'tab' => 'register',
        ]);
    }

    /**
     * Process the login authentication credentials.
     */
    public function auth(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            return $this->redirectBasedOnRole($user);
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau password salah.',
            ]);
    }

    /**
     * Process the registration form and store a new user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number'],
            'driving_license_number' => ['required', 'string', 'max:50', 'unique:users,driving_license_number'],
            'driving_license_expiry_date' => ['required', 'date', 'after_or_equal:today'],
            'driving_license_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'address' => ['required', 'string', 'max:500'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.unique' => 'Nomor telepon sudah terdaftar.',
            'driving_license_number.required' => 'Nomor SIM A wajib diisi.',
            'driving_license_number.unique' => 'Nomor SIM sudah terdaftar.',
            'driving_license_expiry_date.required' => 'Masa berlaku SIM A wajib diisi.',
            'driving_license_expiry_date.date' => 'Format tanggal masa berlaku SIM A tidak valid.',
            'driving_license_expiry_date.after_or_equal' => 'Masa berlaku SIM A minimal harus masih aktif hari ini.',
            'driving_license_photo.required' => 'Foto SIM A wajib diunggah.',
            'driving_license_photo.image' => 'Berkas foto SIM A harus berupa gambar.',
            'driving_license_photo.mimes' => 'Format gambar SIM A harus berupa JPG, JPEG, PNG, atau WEBP.',
            'driving_license_photo.max' => 'Ukuran berkas foto SIM A tidak boleh lebih dari 2MB.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'address.required' => 'Alamat domisili lengkap wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $photoPath = $request->file('driving_license_photo')->store('driving_license', 'public');

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'driving_license_number' => $validated['driving_license_number'],
            'driving_license_expiry_date' => $validated['driving_license_expiry_date'],
            'driving_license_photo' => $photoPath,
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'role' => 'user',
            'verification_status' => 'pending',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended('/dashboard')->with('success', 'Pendaftaran berhasil! Akun Anda telah aktif dan SIM A sedang diverifikasi.');
    }

    /**
     * Invalidate the session and logout the user.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    /**
     * Redirect authenticated user based on role.
     */
    protected function redirectBasedOnRole(User $user): RedirectResponse
    {
        return $user->role === 'admin'
            ? redirect()->intended('/admin/dashboard')
            : redirect()->intended('/dashboard');
    }
}
