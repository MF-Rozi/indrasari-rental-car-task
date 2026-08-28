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

            <!-- Sign In Form Panel -->
            <div id="panelSignIn" class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-outline-variant/70 dark:border-outline-dark/70 shadow-sm transition-colors">
                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Demo UI: Berhasil Masuk!');" class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">mail</span>
                            <input type="email" required placeholder="nama@email.com" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
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
                            <input type="password" required placeholder="••••••••" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-xs text-text-muted dark:text-text-muted-dark">
                            <input type="checkbox" class="w-4 h-4 rounded text-primary focus:ring-primary border-slate-300 dark:border-slate-700 dark:bg-background-dark">
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
                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Demo UI: Registrasi Pengguna Berhasil!');" class="space-y-4">
                    
                    <!-- Nama Lengkap & Nomor Telepon -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">badge</span>
                                <input type="text" required placeholder="Sesuai KTP / SIM" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Nomor Telepon / WA <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">phone</span>
                                <input type="tel" required placeholder="0812-3456-7890" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                        </div>
                    </div>

                    <!-- Nomor SIM A & Email -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Nomor SIM A (Wajib) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">credit_card</span>
                                <input type="text" required placeholder="Contoh: 1234-5678-9012" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark">Diperlukan untuk verifikasi legalitas berkendara</span>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Alamat Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">mail</span>
                                <input type="email" required placeholder="nama@email.com" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Alamat Domisili Lengkap <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-3 text-text-muted dark:text-text-muted-dark text-[20px]">home</span>
                            <textarea required rows="2" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota / Kabupaten" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none"></textarea>
                        </div>
                    </div>

                    <!-- Kata Sandi & Konfirmasi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Kata Sandi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">lock</span>
                                <input type="password" required placeholder="Min. 8 karakter" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Ulangi Kata Sandi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">lock_reset</span>
                                <input type="password" required placeholder="Ulangi kata sandi" class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
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
            history.replaceState(null, '', '?tab=register');
        } else {
            tabSignIn.className = "flex-1 py-2.5 px-4 text-sm font-semibold rounded-lg transition-all cursor-pointer text-center bg-primary text-white shadow-sm";
            tabRegister.className = "flex-1 py-2.5 px-4 text-sm font-semibold rounded-lg transition-all cursor-pointer text-center text-on-surface-variant dark:text-on-surface-variant-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-white/40 dark:hover:bg-surface-container-high-dark";
            panelSignIn.classList.remove('hidden');
            panelRegister.classList.add('hidden');
            history.replaceState(null, '', '?tab=signin');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tab') === 'register') {
            switchAuthTab('register');
        }
    });
</script>
@endpush
