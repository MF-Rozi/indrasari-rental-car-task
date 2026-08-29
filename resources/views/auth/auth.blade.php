@extends('layouts.app')

@section('title', 'Masuk & Registrasi - Indrasari Rental Car')

@section('content')
<div class="min-h-[calc(100vh-4.5rem)] flex flex-col md:flex-row bg-background dark:bg-background-dark">
    
    <!-- Left Hero Cinematic Visual (Desktop) -->
    <div class="hidden md:flex md:w-5/12 lg:w-1/2 relative bg-surface-container-dark overflow-hidden flex-col justify-between p-8 lg:p-12 text-white">
        <!-- Background Car Visual with Overlay -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1600&q=80');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0b1c30] via-[#0b1c30]/75 to-[#0b1c30]/40"></div>

        <!-- Top Badge -->
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/50 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-wider text-white">
                <span class="material-symbols-outlined text-[16px] text-emerald-400">verified_user</span>
                <span>Armada Resmi & Bergaransi</span>
            </div>
        </div>

        <!-- Bottom Pitch Copy -->
        <div class="relative z-10 space-y-4 max-w-lg">
            <h2 class="text-3xl lg:text-4xl font-bold tracking-tight text-white leading-tight">
                Kenyamanan Perjalanan Anda Dimulai di Sini.
            </h2>
            <p class="text-sm lg:text-base text-slate-200 leading-relaxed">
                Nikmati kemudahan sewa mobil harian maupun mingguan dengan tarif terjangkau, unit terawat, dan jaminan ketersediaan instan di seluruh Indonesia.
            </p>
            
            <div class="pt-2 flex items-center gap-6 border-t border-white/10 text-xs text-slate-300">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-400 text-lg">check_circle</span>
                    <span>Proses Cepat & Mudah</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-400 text-lg">check_circle</span>
                    <span>Validasi SIM A Resmi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Auth Forms Card -->
    <div class="w-full md:w-7/12 lg:w-1/2 flex items-center justify-center p-4 sm:p-8 lg:p-12 overflow-y-auto">
        <div class="w-full max-w-xl space-y-6">
            
            <!-- Header Title -->
            <div class="text-center md:text-left">
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface dark:text-on-surface-dark">
                    Selamat Datang di Indrasari
                </h1>
                <p class="text-sm text-text-muted dark:text-text-muted-dark mt-1">
                    Silakan masuk atau buat akun baru untuk mulai menyewa mobil.
                </p>
            </div>

            <!-- Tab Switcher -->
            <div class="flex p-1 bg-surface-container dark:bg-surface-container-dark rounded-xl border border-outline-variant/60 dark:border-outline-dark/60">
                <button type="button" id="tabSignIn" onclick="switchAuthTab('signin')" class="flex-1 py-2.5 px-4 text-sm font-semibold rounded-lg transition-all cursor-pointer text-center bg-primary text-white shadow-sm">
                    Masuk Akun
                </button>
                <button type="button" id="tabRegister" onclick="switchAuthTab('register')" class="flex-1 py-2.5 px-4 text-sm font-semibold rounded-lg transition-all cursor-pointer text-center text-on-surface-variant dark:text-on-surface-variant-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-white/40 dark:hover:bg-surface-container-high-dark">
                    Daftar Baru
                </button>
            </div>

            <!-- Global / Flash Feedback Alerts -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[20px] text-emerald-600 dark:text-emerald-400 shrink-0">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-xs flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[20px] text-red-600 dark:text-red-400 shrink-0">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Sign In Form Panel -->
            <div id="panelSignIn" class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-outline-variant/70 dark:border-outline-dark/70 shadow-sm transition-colors">
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    @if($errors->has('email') && !old('tab') && !$errors->hasAny(['name', 'phone_number', 'driving_license_number', 'driving_license_expiry_date', 'driving_license_photo', 'address', 'password_confirmation']))
                        <div class="p-3.5 rounded-lg bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-xs flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-red-500 shrink-0">error</span>
                            <span>{{ $errors->first('email') }}</span>
                        </div>
                    @endif

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">mail</span>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border @error('email') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Kata Sandi
                            </label>
                            <a href="#" class="text-xs font-semibold text-primary dark:text-inverse-primary hover:underline">
                                Lupa sandi?
                            </a>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">lock</span>
                            <input type="password" name="password" required placeholder="••••••••" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border @error('password') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">error</span>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-xs text-text-muted dark:text-text-muted-dark">
                            <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 rounded text-primary focus:ring-primary border-slate-300 dark:border-slate-700 dark:bg-background-dark">
                            <span>Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full mt-2 py-3 px-4 rounded-lg bg-primary hover:bg-primary-hover text-white text-sm font-semibold shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center justify-center gap-2">
                        <span>Masuk ke Akun</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-outline-variant/50 dark:border-outline-dark/50 text-center">
                    <p class="text-xs text-text-muted dark:text-text-muted-dark">
                        Belum memiliki akun? 
                        <button type="button" onclick="switchAuthTab('register')" class="text-primary dark:text-inverse-primary font-semibold hover:underline cursor-pointer">
                            Daftar sekarang
                        </button>
                    </p>
                </div>
            </div>

            <!-- Registration Form Panel -->
            <div id="panelRegister" class="hidden bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-outline-variant/70 dark:border-outline-dark/70 shadow-sm transition-colors">
                <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="tab" value="register">
                    
                    <!-- Nama Lengkap & Nomor Telepon -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">badge</span>
                                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Sesuai KTP / SIM" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border @error('name') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                            @error('name')
                                <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">error</span>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Nomor Telepon / WA <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">phone</span>
                                <input type="tel" name="phone_number" value="{{ old('phone_number') }}" required placeholder="0812-3456-7890" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border @error('phone_number') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                            @error('phone_number')
                                <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">error</span>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nomor SIM A & Masa Berlaku -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Nomor SIM A (Wajib) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">credit_card</span>
                                <input type="text" name="driving_license_number" value="{{ old('driving_license_number') }}" required placeholder="Contoh: 1234-5678-9012" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border @error('driving_license_number') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark">Diperlukan untuk verifikasi legalitas berkendara</span>
                            @error('driving_license_number')
                                <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">error</span>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Masa Berlaku SIM A <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">calendar_today</span>
                                <input type="date" name="driving_license_expiry_date" value="{{ old('driving_license_expiry_date') }}" required class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border @error('driving_license_expiry_date') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                            @error('driving_license_expiry_date')
                                <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">error</span>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Upload Foto SIM A & Email -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Upload Foto SIM A <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="file" name="driving_license_photo" accept="image/jpeg,image/png,image/jpg,image/webp" required class="w-full text-xs text-on-surface dark:text-on-surface-dark file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary dark:file:bg-primary/20 dark:file:text-inverse-primary hover:file:bg-primary/20 border @error('driving_license_photo') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg bg-white dark:bg-background-dark cursor-pointer py-1.5 px-3 focus:outline-none" />
                            </div>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Format JPG/PNG/WEBP, maks. 2MB</span>
                            @error('driving_license_photo')
                                <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">error</span>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Alamat Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">mail</span>
                                <input type="email" name="email" value="{{ old('tab') === 'register' ? old('email') : '' }}" required placeholder="nama@email.com" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border @error('email') {{ old('tab') === 'register' ? 'border-red-500' : 'border-slate-300 dark:border-slate-700' }} @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                            @if(old('tab') === 'register')
                                @error('email')
                                    <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">error</span>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            @endif
                        </div>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Alamat Domisili Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-3 text-text-muted dark:text-text-muted-dark text-[20px]">home</span>
                            <textarea name="address" required rows="2" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota / Kabupaten" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border @error('address') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">error</span>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Kata Sandi & Konfirmasi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Kata Sandi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">lock</span>
                                <input type="password" name="password" required placeholder="Min. 8 karakter" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border @error('password') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                            @if(old('tab') === 'register')
                                @error('password')
                                    <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">error</span>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            @endif
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Ulangi Kata Sandi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">lock_reset</span>
                                <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border @error('password_confirmation') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                            @error('password_confirmation')
                                <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">error</span>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-start gap-2 pt-1 text-xs text-text-muted dark:text-text-muted-dark">
                        <input type="checkbox" required class="w-4 h-4 mt-0.5 rounded text-primary focus:ring-primary border-slate-300 dark:border-slate-700 dark:bg-background-dark">
                        <span>Saya menyetujui <a href="#" class="text-primary dark:text-inverse-primary hover:underline">Syarat & Ketentuan Sewa</a> serta menyatakan data SIM A yang dimasukkan adalah sah.</span>
                    </div>

                    <button type="submit" class="w-full mt-2 py-3 px-4 rounded-lg bg-primary hover:bg-primary-hover text-white text-sm font-semibold shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center justify-center gap-2">
                        <span>Daftar Akun Sekarang</span>
                        <span class="material-symbols-outlined text-[18px]">person_add</span>
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-outline-variant/50 dark:border-outline-dark/50 text-center">
                    <p class="text-xs text-text-muted dark:text-text-muted-dark">
                        Sudah punya akun? 
                        <button type="button" onclick="switchAuthTab('signin')" class="text-primary dark:text-inverse-primary font-semibold hover:underline cursor-pointer">
                            Masuk di sini
                        </button>
                    </p>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function switchAuthTab(tab) {
        const tabSignIn = document.getElementById('tabSignIn');
        const tabRegister = document.getElementById('tabRegister');
        const panelSignIn = document.getElementById('panelSignIn');
        const panelRegister = document.getElementById('panelRegister');

        if (tab === 'register') {
            tabRegister.className = "flex-1 py-2.5 px-4 text-sm font-semibold rounded-lg transition-all cursor-pointer text-center bg-primary text-white shadow-sm";
            tabSignIn.className = "flex-1 py-2.5 px-4 text-sm font-semibold rounded-lg transition-all cursor-pointer text-center text-on-surface-variant dark:text-on-surface-variant-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-white/40 dark:hover:bg-surface-container-high-dark";
            panelRegister.classList.remove('hidden');
            panelSignIn.classList.add('hidden');
            if (window.location.pathname.endsWith('/register') || window.location.pathname.endsWith('/login')) {
                history.replaceState(null, '', '{{ url('/register') }}');
            } else {
                history.replaceState(null, '', '?tab=register');
            }
        } else {
            tabSignIn.className = "flex-1 py-2.5 px-4 text-sm font-semibold rounded-lg transition-all cursor-pointer text-center bg-primary text-white shadow-sm";
            tabRegister.className = "flex-1 py-2.5 px-4 text-sm font-semibold rounded-lg transition-all cursor-pointer text-center text-on-surface-variant dark:text-on-surface-variant-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-white/40 dark:hover:bg-surface-container-high-dark";
            panelSignIn.classList.remove('hidden');
            panelRegister.classList.add('hidden');
            if (window.location.pathname.endsWith('/register') || window.location.pathname.endsWith('/login')) {
                history.replaceState(null, '', '{{ url('/login') }}');
            } else {
                history.replaceState(null, '', '?tab=signin');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const serverTab = '{{ $tab ?? (request()->routeIs('register') ? 'register' : (request()->routeIs('login') ? 'signin' : 'signin')) }}';
        const shouldShowRegister = serverTab === 'register' 
            || urlParams.get('tab') === 'register' 
            || window.location.pathname.endsWith('/register')
            || {{ ($errors->hasAny(['name', 'phone_number', 'driving_license_number', 'driving_license_expiry_date', 'driving_license_photo', 'address', 'password_confirmation']) || old('tab') === 'register') ? 'true' : 'false' }};
        
        if (shouldShowRegister) {
            switchAuthTab('register');
        } else {
            switchAuthTab('signin');
        }
    });
</script>
@endpush
