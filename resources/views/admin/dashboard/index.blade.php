@extends('layouts.admin')

@section('title', 'Executive Dashboard - Admin Indrasari')
@section('header_title', 'Dashboard Operasional Pusat')

@section('content')
<div class="space-y-8">

    <!-- Executive Greeting & Quick Action Banner -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="space-y-1.5">
            <div class="flex items-center gap-2 text-xs font-bold text-primary dark:text-inverse-primary uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Sistem Operasional Real-Time • {{ date('d F Y') }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface dark:text-on-surface-dark">
                Pusat Kontrol Rental Indrasari
            </h1>
            <p class="text-xs sm:text-sm text-text-muted dark:text-text-muted-dark">
                Monitoring armada sewa, verifikasi legalitas SIM pelanggan, dan rekapitulasi performa finansial harian.
            </p>
        </div>

        <!-- Quick Shortcut Actions -->
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ url('/admin/cars/create') }}" class="px-4 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Tambah Mobil</span>
            </a>
            <a href="{{ url('/admin/rentals') }}" class="px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">assignment_return</span>
                <span>Proses Kembali</span>
            </a>
            <a href="{{ url('/admin/users') }}" class="px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">verified_user</span>
                <span>Antrean SIM A</span>
            </a>
        </div>
    </div>

    <!-- KPI Metric Bento Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Metric 1: Monthly Revenue -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Pendapatan Bulan Ini</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">payments</span>
                </div>
            </div>
            <div class="space-y-1">
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">Rp 28.450.000</span>
                <div class="flex items-center gap-1 text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    <span>+14.8% vs bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Metric 2: Fleet Utilization -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Okupansi Armada</span>
                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">directions_car</span>
                </div>
            </div>
            <div class="space-y-1">
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">75% Aktif</span>
                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">6 Tersedia • 2 Sedang Disewa</span>
            </div>
        </div>

        <!-- Metric 3: Total Completed Bookings -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Transaksi Sewa</span>
                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">receipt_long</span>
                </div>
            </div>
            <div class="space-y-1">
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">24 Transaksi</span>
                <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold block">22 Selesai • 2 Berjalan</span>
            </div>
        </div>

        <!-- Metric 4: Verified Users & Drivers -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Pengguna Terdaftar</span>
                <div class="w-9 h-9 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">badge</span>
                </div>
            </div>
            <div class="space-y-1">
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">142 Pengguna</span>
                <span class="text-[11px] text-amber-600 dark:text-amber-400 font-semibold block">14 Butuh Verifikasi SIM</span>
            </div>
        </div>

    </div>

    <!-- Main Grid: Live Monitoring Table & Sidebar Widgets -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left 8 Cols: Live Active Rentals Monitoring -->
        <div class="lg:col-span-8 space-y-6">
            
            <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5 sm:p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-outline-variant/50 dark:border-outline-dark/50 pb-4">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-ping"></span>
                        <h2 class="font-bold text-base text-on-surface dark:text-on-surface-dark">
                            Monitoring Unit Sedang Disewa
                        </h2>
                    </div>
                    <a href="{{ url('/admin/rentals') }}" class="text-xs font-semibold text-primary dark:text-inverse-primary hover:underline">
                        Lihat Semua Transaksi &rarr;
                    </a>
                </div>

                <!-- Active Rentals Cards/Rows -->
                <div class="space-y-3">
                    
                    <!-- Unit 1 -->
                    <div class="p-4 rounded-xl border border-outline-variant/60 dark:border-outline-dark/60 bg-surface-container/40 dark:bg-surface-container-dark/40 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=200&q=80" alt="Innova" class="w-16 h-12 object-cover rounded-lg border border-slate-200 dark:border-slate-800 shrink-0" />
                            <div class="space-y-0.5 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-bold text-sm text-on-surface dark:text-on-surface-dark truncate">Toyota Innova Zenix 2.0 Q</h3>
                                    <span class="font-mono text-[10px] font-bold px-1.5 py-0.5 rounded bg-primary text-white">B 2419 IND</span>
                                </div>
                                <span class="text-xs text-text-muted dark:text-text-muted-dark block truncate">
                                    Penyewa: <strong>Budi Santoso</strong> (0812-3456-7890)
                                </span>
                                <span class="text-[11px] text-primary dark:text-inverse-primary font-medium block">
                                    Periode: 28 - 31 Ags 2026 • Tarif Total Rp 1.950.000
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                            <a href="{{ url('/admin/rentals') }}" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                <span>Verifikasi Kembali</span>
                            </a>
                        </div>
                    </div>

                    <!-- Unit 2 -->
                    <div class="p-4 rounded-xl border border-outline-variant/60 dark:border-outline-dark/60 bg-surface-container/40 dark:bg-surface-container-dark/40 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=200&q=80" alt="HR-V" class="w-16 h-12 object-cover rounded-lg border border-slate-200 dark:border-slate-800 shrink-0" />
                            <div class="space-y-0.5 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-bold text-sm text-on-surface dark:text-on-surface-dark truncate">Honda HR-V 1.5 SE RS Look</h3>
                                    <span class="font-mono text-[10px] font-bold px-1.5 py-0.5 rounded bg-primary text-white">B 1667 HRV</span>
                                </div>
                                <span class="text-xs text-text-muted dark:text-text-muted-dark block truncate">
                                    Penyewa: <strong>Rian Hidayat</strong> (0818-7766-5544)
                                </span>
                                <span class="text-[11px] text-primary dark:text-inverse-primary font-medium block">
                                    Periode: 27 - 30 Ags 2026 • Tarif Total Rp 1.500.000
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                            <a href="{{ url('/admin/rentals') }}" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                <span>Verifikasi Kembali</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Fleet Category Health & Utilization -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5 sm:p-6 space-y-4">
                <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark">
                    Tingkat Utilisasi Kategori Mobil
                </h3>

                <div class="space-y-3 text-xs">
                    <!-- MPV -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between font-semibold">
                            <span class="text-on-surface dark:text-on-surface-dark">MPV Keluarga (Avanza, Innova)</span>
                            <span class="text-primary dark:text-inverse-primary">85% Terpakai (3 dari 4 Unit)</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden">
                            <div class="h-full bg-primary rounded-full" style="width: 85%;"></div>
                        </div>
                    </div>

                    <!-- Luxury -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between font-semibold">
                            <span class="text-on-surface dark:text-on-surface-dark">Luxury VIP (Alphard Transformer)</span>
                            <span class="text-emerald-600 dark:text-emerald-400">100% Terpakai (1 dari 1 Unit)</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: 100%;"></div>
                        </div>
                    </div>

                    <!-- SUV -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between font-semibold">
                            <span class="text-on-surface dark:text-on-surface-dark">SUV Tangguh (Pajero Sport)</span>
                            <span class="text-on-surface dark:text-on-surface-dark">60% Terpakai (1 dari 2 Unit)</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden">
                            <div class="h-full bg-blue-400 rounded-full" style="width: 60%;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right 4 Cols: SIM Verification Queue & Audit Activity -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Pending Verification Queue Card -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-outline-variant/50 dark:border-outline-dark/50 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500 text-lg">pending_actions</span>
                        <h3 class="font-bold text-sm text-on-surface dark:text-on-surface-dark">
                            Antrean Verifikasi SIM A
                        </h3>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 dark:bg-amber-950 dark:text-amber-300">
                        14 Baru
                    </span>
                </div>

                <div class="space-y-3">
                    <!-- Pending User 1 -->
                    <div class="p-3 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-xs text-on-surface dark:text-on-surface-dark">Hendra Pratama</span>
                            <span class="font-mono text-[10px] font-semibold text-text-muted dark:text-text-muted-dark">0819-2233-4455</span>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-text-muted dark:text-text-muted-dark">
                            <span>No. SIM: <strong class="font-mono text-on-surface dark:text-on-surface-dark">5566-7788-9900</strong></span>
                        </div>
                        <div class="pt-1 flex items-center justify-end gap-2">
                            <a href="{{ url('/admin/users') }}" class="px-2.5 py-1 rounded bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-semibold transition-colors">
                                Verifikasi Sekarang
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/admin/users') }}" class="block text-center py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors">
                    Lihat Semua Pengguna
                </a>
            </div>

            <!-- Activity Stream -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-5 shadow-sm space-y-4">
                <h3 class="font-bold text-sm text-on-surface dark:text-on-surface-dark border-b border-outline-variant/50 dark:border-outline-dark/50 pb-3">
                    Aktivitas Operasional Terkini
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex items-start gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                        <div class="space-y-0.5">
                            <p class="text-on-surface dark:text-on-surface-dark font-semibold">Pengembalian Disetujui</p>
                            <p class="text-text-muted dark:text-text-muted-dark text-[11px]">Siti Rahmawati menyelesaikan sewa Avanza B 1872 IND.</p>
                            <span class="text-[10px] text-text-muted dark:text-text-muted-dark">10 menit yang lalu</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                        <div class="space-y-0.5">
                            <p class="text-on-surface dark:text-on-surface-dark font-semibold">Sewa Baru Berjalan</p>
                            <p class="text-text-muted dark:text-text-muted-dark text-[11px]">Budi Santoso mulai sewa Innova Zenix B 2419 IND (3 hari).</p>
                            <span class="text-[10px] text-text-muted dark:text-text-muted-dark">2 jam yang lalu</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
