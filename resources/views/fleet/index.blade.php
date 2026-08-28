@extends('layouts.app')

@section('title', 'Daftar Armada Mobil - Indrasari Rental Car')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-8">

    <!-- Page Header & Search Banner -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-2 text-xs font-bold text-primary dark:text-inverse-primary uppercase tracking-wider">
                <span class="material-symbols-outlined text-[16px]">directions_car</span>
                <span>Katalog Unit Tersedia</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface dark:text-on-surface-dark">
                Pilih Armada Mobil Anda
            </h1>
            <p class="text-sm text-text-muted dark:text-text-muted-dark">
                Temukan kendaraan yang tepat untuk kebutuhan perjalanan Anda dengan tarif harian transparan.
            </p>
        </div>

        <!-- Quick Stats Chips -->
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 rounded-xl bg-surface-container dark:bg-surface-container-dark border border-outline-variant/60 dark:border-outline-dark/60 text-center">
                <span class="text-xs text-text-muted dark:text-text-muted-dark block">Total Armada</span>
                <span class="text-lg font-bold text-on-surface dark:text-on-surface-dark">8 Unit</span>
            </div>
            <div class="px-4 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-center">
                <span class="text-xs text-emerald-700 dark:text-emerald-400 block font-medium">Siap Disewa</span>
                <span class="text-lg font-bold text-emerald-800 dark:text-emerald-300">6 Unit</span>
            </div>
        </div>
    </div>

    <!-- Main Content Layout (Sidebar Filters + Car Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Left Sidebar Filter (Desktop) -->
        <aside class="space-y-6 lg:col-span-1">
            <div class="bg-white dark:bg-surface-dark rounded-2xl p-5 sm:p-6 border border-slate-200 dark:border-slate-800 space-y-6">
                <div class="flex items-center justify-between border-b border-outline-variant/50 dark:border-outline-dark/50 pb-4">
                    <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px] text-primary">tune</span>
                        <span>Filter Pencarian</span>
                    </h3>
                    <a href="{{ url('/fleet') }}" class="text-xs text-primary dark:text-inverse-primary font-semibold hover:underline">
                        Reset
                    </a>
                </div>

                <!-- Search Input -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Cari Merek / Model
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">search</span>
                        <input type="text" id="filterSearch" placeholder="Ketik Avanza, Alphard..." class="w-full pl-9 pr-3 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                    </div>
                </div>

                <!-- Category Filter Pills -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Tipe / Kategori
                    </label>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary text-white shadow-sm">
                            Semua
                        </button>
                        <button type="button" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-primary/10 hover:text-primary transition-colors">
                            MPV
                        </button>
                        <button type="button" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-primary/10 hover:text-primary transition-colors">
                            SUV
                        </button>
                        <button type="button" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-primary/10 hover:text-primary transition-colors">
                            Luxury VIP
                        </button>
                        <button type="button" class="px-3 py-1.5 rounded-lg text-xs font-medium bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-primary/10 hover:text-primary transition-colors">
                            Listrik (EV)
                        </button>
                    </div>
                </div>

                <!-- Transmission Radio -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Transmisi
                    </label>
                    <div class="space-y-1.5 text-xs text-on-surface dark:text-on-surface-dark">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="trans" checked class="text-primary focus:ring-primary border-slate-300 dark:border-slate-700">
                            <span>Semua Transmisi</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="trans" class="text-primary focus:ring-primary border-slate-300 dark:border-slate-700">
                            <span>Automatic (AT / CVT)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="trans" class="text-primary focus:ring-primary border-slate-300 dark:border-slate-700">
                            <span>Manual (MT)</span>
                        </label>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Ketersediaan
                    </label>
                    <div class="space-y-1.5 text-xs text-on-surface dark:text-on-surface-dark">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" checked class="rounded text-primary focus:ring-primary border-slate-300 dark:border-slate-700">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>Hanya Mobil Tersedia</span>
                            </span>
                        </label>
                    </div>
                </div>

                <button type="button" class="w-full py-2.5 px-4 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all">
                    Terapkan Filter
                </button>
            </div>
        </aside>

        <!-- Right Vehicle Grid -->
        <main class="lg:col-span-3 space-y-6">
            
            <!-- Filter Toolbar / Active Sort -->
            <div class="flex items-center justify-between text-xs text-text-muted dark:text-text-muted-dark">
                <span>Menampilkan <strong class="text-on-surface dark:text-on-surface-dark font-semibold">6 dari 8</strong> mobil tersedia</span>
                <div class="flex items-center gap-2">
                    <span>Urutkan:</span>
                    <select class="bg-white dark:bg-surface-dark border border-slate-300 dark:border-slate-700 rounded-lg px-2.5 py-1 text-xs text-on-surface dark:text-on-surface-dark focus:ring-primary focus:border-primary outline-none">
                        <option>Paling Populer</option>
                        <option>Tarif: Terendah ke Tertinggi</option>
                        <option>Tarif: Tertinggi ke Terendah</option>
                        <option>Kapasitas Kursi Terbanyak</option>
                    </select>
                </div>
            </div>

            <!-- Cars Cards List -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Car 1: Innova Zenix -->
                <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg hover:border-primary/40 dark:hover:border-inverse-primary/40 transition-all group flex flex-col">
                    <div class="relative h-48 bg-surface-container dark:bg-surface-container-dark overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80" alt="Innova Zenix" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Tersedia
                            </span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-black/60 backdrop-blur-md text-white">MPV</span>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase tracking-wider text-text-muted dark:text-text-muted-dark">Toyota</span>
                                <span class="text-xs font-mono font-semibold px-1.5 py-0.5 rounded bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark">B 2419 IND</span>
                            </div>
                            <h3 class="text-base font-bold text-on-surface dark:text-on-surface-dark mt-1 group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors">
                                Innova Zenix 2.0 Q Hybrid
                            </h3>
                        </div>
                        <div class="grid grid-cols-3 gap-2 py-2.5 border-y border-outline-variant/50 dark:border-outline-dark/50 text-xs text-text-muted dark:text-text-muted-dark">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">airline_seat_recline_normal</span>
                                <span>7 Kursi</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">settings</span>
                                <span>Matic</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">local_gas_station</span>
                                <span>Hybrid</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <div>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Tarif / Hari</span>
                                <span class="text-lg font-bold text-on-surface dark:text-on-surface-dark">Rp 650.000</span>
                            </div>
                            <a href="{{ url('/fleet/1') }}" class="py-2 px-3.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all">
                                Detail & Sewa
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Car 2: Toyota Alphard -->
                <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg hover:border-primary/40 dark:hover:border-inverse-primary/40 transition-all group flex flex-col">
                    <div class="relative h-48 bg-surface-container dark:bg-surface-container-dark overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=80" alt="Toyota Alphard" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Tersedia
                            </span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-black/60 backdrop-blur-md text-white">Luxury</span>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase tracking-wider text-text-muted dark:text-text-muted-dark">Toyota</span>
                                <span class="text-xs font-mono font-semibold px-1.5 py-0.5 rounded bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark">B 1008 SRI</span>
                            </div>
                            <h3 class="text-base font-bold text-on-surface dark:text-on-surface-dark mt-1 group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors">
                                Alphard 2.5 Transformer VIP
                            </h3>
                        </div>
                        <div class="grid grid-cols-3 gap-2 py-2.5 border-y border-outline-variant/50 dark:border-outline-dark/50 text-xs text-text-muted dark:text-text-muted-dark">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">airline_seat_recline_normal</span>
                                <span>6 VIP</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">settings</span>
                                <span>Matic</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">local_gas_station</span>
                                <span>Bensin</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <div>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Tarif / Hari</span>
                                <span class="text-lg font-bold text-on-surface dark:text-on-surface-dark">Rp 1.850.000</span>
                            </div>
                            <a href="{{ url('/fleet/2') }}" class="py-2 px-3.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all">
                                Detail & Sewa
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Car 3: Avanza -->
                <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg hover:border-primary/40 dark:hover:border-inverse-primary/40 transition-all group flex flex-col">
                    <div class="relative h-48 bg-surface-container dark:bg-surface-container-dark overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=800&q=80" alt="Toyota Avanza" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Tersedia
                            </span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-black/60 backdrop-blur-md text-white">MPV</span>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase tracking-wider text-text-muted dark:text-text-muted-dark">Toyota</span>
                                <span class="text-xs font-mono font-semibold px-1.5 py-0.5 rounded bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark">B 1872 IND</span>
                            </div>
                            <h3 class="text-base font-bold text-on-surface dark:text-on-surface-dark mt-1 group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors">
                                All New Avanza 1.5 G
                            </h3>
                        </div>
                        <div class="grid grid-cols-3 gap-2 py-2.5 border-y border-outline-variant/50 dark:border-outline-dark/50 text-xs text-text-muted dark:text-text-muted-dark">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">airline_seat_recline_normal</span>
                                <span>7 Kursi</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">settings</span>
                                <span>Matic</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">local_gas_station</span>
                                <span>Bensin</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <div>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Tarif / Hari</span>
                                <span class="text-lg font-bold text-on-surface dark:text-on-surface-dark">Rp 375.000</span>
                            </div>
                            <a href="{{ url('/fleet/3') }}" class="py-2 px-3.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all">
                                Detail & Sewa
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Car 4: Mitsubishi Pajero Sport -->
                <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg hover:border-primary/40 dark:hover:border-inverse-primary/40 transition-all group flex flex-col">
                    <div class="relative h-48 bg-surface-container dark:bg-surface-container-dark overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80" alt="Mitsubishi Pajero Sport" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Tersedia
                            </span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-black/60 backdrop-blur-md text-white">SUV</span>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase tracking-wider text-text-muted dark:text-text-muted-dark">Mitsubishi</span>
                                <span class="text-xs font-mono font-semibold px-1.5 py-0.5 rounded bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark">D 1945 PJ</span>
                            </div>
                            <h3 class="text-base font-bold text-on-surface dark:text-on-surface-dark mt-1 group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors">
                                Pajero Sport Dakar 4x2
                            </h3>
                        </div>
                        <div class="grid grid-cols-3 gap-2 py-2.5 border-y border-outline-variant/50 dark:border-outline-dark/50 text-xs text-text-muted dark:text-text-muted-dark">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">airline_seat_recline_normal</span>
                                <span>7 Kursi</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">settings</span>
                                <span>Matic</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">local_gas_station</span>
                                <span>Diesel</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <div>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Tarif / Hari</span>
                                <span class="text-lg font-bold text-on-surface dark:text-on-surface-dark">Rp 850.000</span>
                            </div>
                            <a href="{{ url('/fleet/1') }}" class="py-2 px-3.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all">
                                Detail & Sewa
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Car 5: Hyundai Ioniq 5 EV -->
                <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg hover:border-primary/40 dark:hover:border-inverse-primary/40 transition-all group flex flex-col">
                    <div class="relative h-48 bg-surface-container dark:bg-surface-container-dark overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=800&q=80" alt="Hyundai Ioniq 5" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Tersedia
                            </span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-black/60 backdrop-blur-md text-white">EV Eco</span>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase tracking-wider text-text-muted dark:text-text-muted-dark">Hyundai</span>
                                <span class="text-xs font-mono font-semibold px-1.5 py-0.5 rounded bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark">B 2024 EV</span>
                            </div>
                            <h3 class="text-base font-bold text-on-surface dark:text-on-surface-dark mt-1 group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors">
                                Ioniq 5 Signature Long Range
                            </h3>
                        </div>
                        <div class="grid grid-cols-3 gap-2 py-2.5 border-y border-outline-variant/50 dark:border-outline-dark/50 text-xs text-text-muted dark:text-text-muted-dark">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">airline_seat_recline_normal</span>
                                <span>5 Kursi</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">settings</span>
                                <span>Matic</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">bolt</span>
                                <span>100% Listrik</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <div>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Tarif / Hari</span>
                                <span class="text-lg font-bold text-on-surface dark:text-on-surface-dark">Rp 1.100.000</span>
                            </div>
                            <a href="{{ url('/fleet/1') }}" class="py-2 px-3.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all">
                                Detail & Sewa
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Car 6: Honda HR-V (Sedang Disewa state demo) -->
                <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm flex flex-col opacity-90">
                    <div class="relative h-48 bg-surface-container dark:bg-surface-container-dark overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?auto=format&fit=crop&w=800&q=80" alt="Honda HR-V" class="w-full h-full object-cover grayscale-[30%]" />
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                Sedang Disewa
                            </span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-black/60 backdrop-blur-md text-white">Compact SUV</span>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase tracking-wider text-text-muted dark:text-text-muted-dark">Honda</span>
                                <span class="text-xs font-mono font-semibold px-1.5 py-0.5 rounded bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark">B 1667 HRV</span>
                            </div>
                            <h3 class="text-base font-bold text-on-surface dark:text-on-surface-dark mt-1">
                                HR-V 1.5 SE RS Look
                            </h3>
                        </div>
                        <div class="grid grid-cols-3 gap-2 py-2.5 border-y border-outline-variant/50 dark:border-outline-dark/50 text-xs text-text-muted dark:text-text-muted-dark">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">airline_seat_recline_normal</span>
                                <span>5 Kursi</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">settings</span>
                                <span>Matic</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">local_gas_station</span>
                                <span>Bensin</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-1">
                            <div>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Tarif / Hari</span>
                                <span class="text-lg font-bold text-on-surface dark:text-on-surface-dark">Rp 500.000</span>
                            </div>
                            <button disabled class="py-2 px-3.5 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-semibold cursor-not-allowed">
                                Disewa s/d 30 Ags
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Pagination -->
            <div class="pt-6 border-t border-outline-variant/50 dark:border-outline-dark/50 flex items-center justify-between">
                <button class="px-4 py-2 text-xs font-semibold border border-slate-300 dark:border-slate-700 rounded-lg text-text-muted dark:text-text-muted-dark opacity-50 cursor-not-allowed">
                    &larr; Sebelumnya
                </button>
                <div class="flex items-center gap-1">
                    <span class="w-8 h-8 rounded-lg bg-primary text-white text-xs font-bold flex items-center justify-center">1</span>
                    <span class="w-8 h-8 rounded-lg text-xs font-semibold text-text-muted dark:text-text-muted-dark flex items-center justify-center hover:bg-surface-container cursor-pointer">2</span>
                </div>
                <button class="px-4 py-2 text-xs font-semibold border border-slate-300 dark:border-slate-700 rounded-lg text-on-surface dark:text-on-surface-dark hover:bg-surface-container transition-colors">
                    Selanjutnya &rarr;
                </button>
            </div>

        </main>
    </div>

</div>
@endsection
