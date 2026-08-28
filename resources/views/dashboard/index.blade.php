@extends('layouts.app')

@section('title', 'Dashboard Pelanggan - Indrasari Rental Car')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-8">

    <!-- Customer Welcome Hero Banner -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-primary text-white text-2xl font-bold flex items-center justify-center shadow-md shadow-primary/20 shrink-0">
                BS
            </div>
            <div class="space-y-1">
                <div class="flex flex-wrap items-center gap-2.5">
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface dark:text-on-surface-dark">
                        Selamat Datang, Budi Santoso
                    </h1>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                        <span class="material-symbols-outlined text-[14px]">verified</span>
                        Verified Driver
                    </span>
                </div>
                <p class="text-xs text-text-muted dark:text-text-muted-dark">
                    Kelola armada sewaan aktif Anda, pantau tagihan, dan pesan kendaraan berikutnya dengan cepat.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ url('/returns') }}" class="px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">assignment_return</span>
                <span>Kembalikan Mobil</span>
            </a>
            <a href="{{ url('/fleet') }}" class="px-4 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Sewa Mobil Baru</span>
            </a>
        </div>
    </div>

    <!-- Active Booking Command Center Card -->
    <div class="bg-gradient-to-br from-primary/5 via-white to-surface-container/30 dark:from-[#0f233d] dark:via-surface-dark dark:to-surface-dark rounded-2xl border border-primary/20 dark:border-primary/30 p-6 sm:p-8 shadow-sm space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-outline-variant/60 dark:border-outline-dark/60 pb-4">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-ping"></span>
                <h2 class="text-base font-bold text-on-surface dark:text-on-surface-dark">
                    Sewa Aktif Saat Ini
                </h2>
                <span class="font-mono text-xs font-bold px-2 py-0.5 rounded bg-primary text-white">
                    B 2419 IND
                </span>
            </div>
            <span class="text-xs text-text-muted dark:text-text-muted-dark">
                Kode Reservasi: <strong class="text-on-surface dark:text-on-surface-dark font-mono">IND-BK-0091</strong>
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
            
            <!-- Car Image & Specs -->
            <div class="lg:col-span-4 flex items-center gap-4">
                <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=400&q=80" alt="Innova Zenix" class="w-32 sm:w-40 h-24 sm:h-28 object-cover rounded-xl border border-slate-200 dark:border-slate-800 shrink-0" />
                <div class="space-y-1">
                    <span class="text-[11px] font-bold text-text-muted dark:text-text-muted-dark uppercase tracking-wider">Toyota MPV Hybrid</span>
                    <h3 class="text-base sm:text-lg font-bold text-on-surface dark:text-on-surface-dark">
                        Innova Zenix 2.0 Q
                    </h3>
                    <span class="text-xs text-primary dark:text-inverse-primary font-semibold block">
                        Rp 650.000 / hari
                    </span>
                </div>
            </div>

            <!-- Rental Timeline Bar -->
            <div class="lg:col-span-5 space-y-3">
                <div class="flex items-center justify-between text-xs font-semibold text-on-surface dark:text-on-surface-dark">
                    <div class="space-y-0.5">
                        <span class="text-[11px] text-text-muted dark:text-text-muted-dark block font-normal">Mulai Sewa</span>
                        <span>28 Ags 2026</span>
                    </div>
                    <div class="text-center space-y-0.5">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300">
                            3 Hari Sewa
                        </span>
                    </div>
                    <div class="text-right space-y-0.5">
                        <span class="text-[11px] text-text-muted dark:text-text-muted-dark block font-normal">Selesai Sewa</span>
                        <span>31 Ags 2026</span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="w-full h-2.5 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden">
                    <div class="h-full bg-primary rounded-full" style="width: 33%;"></div>
                </div>
                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block text-right">
                    Waktu tersisa: <strong>2 Hari 14 Jam</strong>
                </span>
            </div>

            <!-- Total Cost & Actions -->
            <div class="lg:col-span-3 flex flex-col items-start lg:items-end justify-between gap-3 border-t lg:border-t-0 border-outline-variant/50 dark:border-outline-dark/50 pt-4 lg:pt-0">
                <div class="text-left lg:text-right">
                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Total Biaya Sewa</span>
                    <strong class="text-2xl font-bold text-on-surface dark:text-on-surface-dark">Rp 1.950.000</strong>
                </div>

                <a href="{{ url('/returns?plate=B2419IND') }}" class="w-full lg:w-auto py-2.5 px-5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition-all text-center flex items-center justify-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">assignment_return</span>
                    <span>Kembalikan Unit Ini</span>
                </a>
            </div>

        </div>

    </div>

    <!-- Stats & Account Overview Bento Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Completed Rentals -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Sewa Selesai</span>
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">3 Transaksi</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">task_alt</span>
            </div>
        </div>

        <!-- Total Rental Days -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Total Hari Berkendara</span>
                <span class="text-2xl font-bold text-primary dark:text-inverse-primary block">7 Hari</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">schedule</span>
            </div>
        </div>

        <!-- Indrasari Reward Points -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Poin Loyalitas</span>
                <span class="text-2xl font-bold text-amber-600 dark:text-amber-400 block">1.250 Poin</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">loyalty</span>
            </div>
        </div>

        <!-- SIM A Verification Status -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Status SIM A</span>
                <span class="text-base font-bold text-emerald-600 dark:text-emerald-400 block">Aktif (Valid 2028)</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">credit_card</span>
            </div>
        </div>

    </div>

    <!-- Bottom Section: Quick Links & Recent History -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Recent Activity & Invoices -->
        <div class="lg:col-span-2 bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-outline-variant/50 dark:border-outline-dark/50 pb-3">
                <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark">
                    Riwayat Transaksi Terakhir
                </h3>
                <a href="{{ url('/rentals') }}" class="text-xs font-semibold text-primary dark:text-inverse-primary hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="divide-y divide-outline-variant/40 dark:divide-outline-dark/40">
                <!-- Item 1 -->
                <div class="py-3.5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-surface-container dark:bg-surface-container-dark flex items-center justify-center text-primary dark:text-inverse-primary">
                            <span class="material-symbols-outlined text-[20px]">directions_car</span>
                        </div>
                        <div class="space-y-0.5">
                            <h4 class="font-bold text-xs text-on-surface dark:text-on-surface-dark">
                                Toyota All New Avanza 1.5 G
                            </h4>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">
                                10 - 12 Ags 2026 • Plat <strong>B 1872 IND</strong>
                            </span>
                        </div>
                    </div>
                    <div class="text-right space-y-0.5">
                        <span class="font-bold text-xs text-on-surface dark:text-on-surface-dark block">Rp 750.000</span>
                        <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase">Selesai</span>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="py-3.5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-surface-container dark:bg-surface-container-dark flex items-center justify-center text-primary dark:text-inverse-primary">
                            <span class="material-symbols-outlined text-[20px]">directions_car</span>
                        </div>
                        <div class="space-y-0.5">
                            <h4 class="font-bold text-xs text-on-surface dark:text-on-surface-dark">
                                Toyota Alphard 2.5 Transformer
                            </h4>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">
                                01 - 03 Ags 2026 • Plat <strong>B 1008 SRI</strong>
                            </span>
                        </div>
                    </div>
                    <div class="text-right space-y-0.5">
                        <span class="font-bold text-xs text-on-surface dark:text-on-surface-dark block">Rp 3.700.000</span>
                        <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase">Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Col: Quick Recommendations -->
        <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm space-y-4">
            <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark border-b border-outline-variant/50 dark:border-outline-dark/50 pb-3">
                Rekomendasi Mobil Pilihan
            </h3>

            <div class="space-y-3">
                <!-- Rec 1 -->
                <div class="p-3 rounded-xl bg-surface-container dark:bg-surface-container-dark flex items-center gap-3">
                    <img src="https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=200&q=80" alt="Alphard" class="w-16 h-12 object-cover rounded-lg shrink-0" />
                    <div class="space-y-0.5 min-w-0 flex-1">
                        <h4 class="font-bold text-xs text-on-surface dark:text-on-surface-dark truncate">Toyota Alphard VIP</h4>
                        <span class="text-[11px] text-primary dark:text-inverse-primary font-semibold block">Rp 1.850.000 / hari</span>
                    </div>
                    <a href="{{ url('/fleet/2') }}" class="p-1.5 rounded-lg bg-primary text-white hover:bg-primary-hover transition-colors">
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                <!-- Rec 2 -->
                <div class="p-3 rounded-xl bg-surface-container dark:bg-surface-container-dark flex items-center gap-3">
                    <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=200&q=80" alt="Pajero" class="w-16 h-12 object-cover rounded-lg shrink-0" />
                    <div class="space-y-0.5 min-w-0 flex-1">
                        <h4 class="font-bold text-xs text-on-surface dark:text-on-surface-dark truncate">Mitsubishi Pajero Sport</h4>
                        <span class="text-[11px] text-primary dark:text-inverse-primary font-semibold block">Rp 850.000 / hari</span>
                    </div>
                    <a href="{{ url('/fleet/4') }}" class="p-1.5 rounded-lg bg-primary text-white hover:bg-primary-hover transition-colors">
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
            </div>

            <a href="{{ url('/fleet') }}" class="block w-full py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-center text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors">
                Lihat Semua Armada
            </a>
        </div>

    </div>

</div>
@endsection
