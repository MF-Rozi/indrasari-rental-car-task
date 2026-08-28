@extends('layouts.app')

@section('title', 'Indrasari Rental Car - Sewa Mobil Terpercaya di Indonesia')

@section('content')
<div class="space-y-16 lg:space-y-24 pb-20">

    <!-- Hero Section with Booking Search Card -->
    <section class="relative min-h-[560px] lg:min-h-[620px] flex items-center justify-center bg-surface-container-dark text-white overflow-hidden">
        <!-- Background Banner -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=2000&q=80');"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#0b1c30]/95 via-[#0b1c30]/80 to-[#0b1c30]/60"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full">
            <div class="max-w-3xl space-y-6">
                <!-- Tagline Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold uppercase tracking-wider text-inverse-primary">
                    <span class="material-symbols-outlined text-[16px] text-emerald-400">verified</span>
                    <span>Rental Mobil Terpercaya & Berpengalaman</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight" style="text-wrap: balance;">
                    Sewa Mobil Nyaman, <br><span class="text-inverse-primary">Tarif Transparan</span> di Indonesia.
                </h1>

                <p class="text-base sm:text-lg text-slate-300 max-w-2xl leading-relaxed">
                    Armada bersih, terawat, dan siap menemani perjalanan bisnis maupun liburan keluarga Anda. Tarif mulai dari <span class="text-white font-bold">Rp 350.000/hari</span> tanpa biaya tersembunyi.
                </p>
            </div>

            <!-- Interactive Quick Booking Search Box -->
            <div class="mt-10 bg-white dark:bg-surface-dark rounded-2xl p-5 sm:p-6 lg:p-7 border border-outline-variant/70 dark:border-outline-dark/70 shadow-xl text-on-surface dark:text-on-surface-dark">
                <form action="{{ url('/fleet') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Search Term / Model -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Cari Merek / Model
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">search</span>
                            <input type="text" name="search" placeholder="Contoh: Avanza, Innova..." class="w-full pl-10 pr-3 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                        </div>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Tanggal Mulai Sewa
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">calendar_today</span>
                            <input type="date" name="start_date" value="{{ date('Y-m-d') }}" class="w-full pl-10 pr-3 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                        </div>
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Tanggal Selesai Sewa
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">event</span>
                            <input type="date" name="end_date" value="{{ date('Y-m-d', strtotime('+3 days')) }}" class="w-full pl-10 pr-3 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                        </div>
                    </div>

                    <!-- CTA Search Button -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full py-2.5 px-6 rounded-lg bg-primary hover:bg-primary-hover text-white text-sm font-semibold shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center justify-center gap-2 h-[42px]">
                            <span class="material-symbols-outlined text-[20px]">search</span>
                            <span>Cari Mobil Tersedia</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <!-- Featured Fleet Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-primary dark:text-inverse-primary tracking-widest uppercase">Pilihan Terfavorit</span>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface dark:text-on-surface-dark mt-1">
                    Armada Mobil Unggulan Kami
                </h2>
                <p class="text-sm text-text-muted dark:text-text-muted-dark mt-1">
                    Unit terawat berkala, siap pakai dengan asuransi all-risk dan layanan darurat 24 jam.
                </p>
            </div>
            <a href="{{ url('/fleet') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary dark:text-inverse-primary hover:underline group">
                <span>Lihat Semua Armada</span>
                <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>

        <!-- Vehicle Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            
            <!-- Car Card 1: Toyota Innova Zenix -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg hover:border-primary/40 dark:hover:border-inverse-primary/40 transition-all group flex flex-col">
                <!-- Vehicle Image -->
                <div class="relative h-52 bg-surface-container dark:bg-surface-container-dark overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80" alt="Toyota Innova Zenix" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Tersedia
                        </span>
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-black/60 backdrop-blur-md text-white">
                            MPV Premium
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-text-muted dark:text-text-muted-dark">Toyota</span>
                            <span class="text-xs font-mono font-semibold px-2 py-0.5 rounded bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark">B 2419 IND</span>
                        </div>
                        <h3 class="text-lg font-bold text-on-surface dark:text-on-surface-dark mt-1 group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors">
                            Innova Zenix 2.0 Q Hybrid
                        </h3>
                    </div>

                    <!-- Specs Chips -->
                    <div class="grid grid-cols-3 gap-2 py-3 border-y border-outline-variant/50 dark:border-outline-dark/50 text-xs text-text-muted dark:text-text-muted-dark">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-primary dark:text-inverse-primary">airline_seat_recline_normal</span>
                            <span>7 Kursi</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-primary dark:text-inverse-primary">settings</span>
                            <span>Matic (CVT)</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-primary dark:text-inverse-primary">local_gas_station</span>
                            <span>Hybrid</span>
                        </div>
                    </div>

                    <!-- Pricing & CTA -->
                    <div class="flex items-center justify-between pt-1">
                        <div>
                            <span class="text-xs text-text-muted dark:text-text-muted-dark block">Tarif Sewa</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-xl font-bold text-on-surface dark:text-on-surface-dark">Rp 650.000</span>
                                <span class="text-xs text-text-muted dark:text-text-muted-dark font-medium">/ hari</span>
                            </div>
                        </div>
                        <a href="{{ url('/fleet/1') }}" class="py-2.5 px-4 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-1.5">
                            <span>Detail & Pesan</span>
                            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Car Card 2: Toyota Alphard Executive Lounge -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg hover:border-primary/40 dark:hover:border-inverse-primary/40 transition-all group flex flex-col">
                <!-- Vehicle Image -->
                <div class="relative h-52 bg-surface-container dark:bg-surface-container-dark overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=80" alt="Toyota Alphard" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Tersedia
                        </span>
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-black/60 backdrop-blur-md text-white">
                            Luxury VIP
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-text-muted dark:text-text-muted-dark">Toyota</span>
                            <span class="text-xs font-mono font-semibold px-2 py-0.5 rounded bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark">B 1008 SRI</span>
                        </div>
                        <h3 class="text-lg font-bold text-on-surface dark:text-on-surface-dark mt-1 group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors">
                            Alphard 2.5 Transformer VIP
                        </h3>
                    </div>

                    <!-- Specs Chips -->
                    <div class="grid grid-cols-3 gap-2 py-3 border-y border-outline-variant/50 dark:border-outline-dark/50 text-xs text-text-muted dark:text-text-muted-dark">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-primary dark:text-inverse-primary">airline_seat_recline_normal</span>
                            <span>6 Kursi VIP</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-primary dark:text-inverse-primary">settings</span>
                            <span>Matic (AT)</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-primary dark:text-inverse-primary">local_gas_station</span>
                            <span>Bensin</span>
                        </div>
                    </div>

                    <!-- Pricing & CTA -->
                    <div class="flex items-center justify-between pt-1">
                        <div>
                            <span class="text-xs text-text-muted dark:text-text-muted-dark block">Tarif Sewa</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-xl font-bold text-on-surface dark:text-on-surface-dark">Rp 1.850.000</span>
                                <span class="text-xs text-text-muted dark:text-text-muted-dark font-medium">/ hari</span>
                            </div>
                        </div>
                        <a href="{{ url('/fleet/2') }}" class="py-2.5 px-4 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-1.5">
                            <span>Detail & Pesan</span>
                            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Car Card 3: Toyota Avanza -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-lg hover:border-primary/40 dark:hover:border-inverse-primary/40 transition-all group flex flex-col">
                <!-- Vehicle Image -->
                <div class="relative h-52 bg-surface-container dark:bg-surface-container-dark overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=800&q=80" alt="Toyota Avanza" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Tersedia
                        </span>
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-black/60 backdrop-blur-md text-white">
                            MPV Hemat
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-text-muted dark:text-text-muted-dark">Toyota</span>
                            <span class="text-xs font-mono font-semibold px-2 py-0.5 rounded bg-surface-container dark:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark">B 1872 IND</span>
                        </div>
                        <h3 class="text-lg font-bold text-on-surface dark:text-on-surface-dark mt-1 group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors">
                            All New Avanza 1.5 G
                        </h3>
                    </div>

                    <!-- Specs Chips -->
                    <div class="grid grid-cols-3 gap-2 py-3 border-y border-outline-variant/50 dark:border-outline-dark/50 text-xs text-text-muted dark:text-text-muted-dark">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-primary dark:text-inverse-primary">airline_seat_recline_normal</span>
                            <span>7 Kursi</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-primary dark:text-inverse-primary">settings</span>
                            <span>Matic (CVT)</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-primary dark:text-inverse-primary">local_gas_station</span>
                            <span>Bensin</span>
                        </div>
                    </div>

                    <!-- Pricing & CTA -->
                    <div class="flex items-center justify-between pt-1">
                        <div>
                            <span class="text-xs text-text-muted dark:text-text-muted-dark block">Tarif Sewa</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-xl font-bold text-on-surface dark:text-on-surface-dark">Rp 375.000</span>
                                <span class="text-xs text-text-muted dark:text-text-muted-dark font-medium">/ hari</span>
                            </div>
                        </div>
                        <a href="{{ url('/fleet/3') }}" class="py-2.5 px-4 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-1.5">
                            <span>Detail & Pesan</span>
                            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Why Choose Indrasari (Trust Bento) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold text-primary dark:text-inverse-primary tracking-widest uppercase">Keunggulan Layanan</span>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface dark:text-on-surface-dark mt-1">
                Mengapa Memilih Indrasari Rental Car?
            </h2>
            <p class="text-sm text-text-muted dark:text-text-muted-dark mt-2">
                Kami berkomitmen memberikan standar tertinggi dalam kebersihan unit, transparansi harga, dan kenyamanan pelanggan.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Bento Item 1 -->
            <div class="bg-white dark:bg-surface-dark p-6 sm:p-8 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">car_repair</span>
                </div>
                <h3 class="text-lg font-bold text-on-surface dark:text-on-surface-dark">Unit Bersih & Servis Rutin</h3>
                <p class="text-sm text-text-muted dark:text-text-muted-dark leading-relaxed">
                    Setiap unit melalui pengecekan mesin, tekanan ban, sistem AC, dan pembersihan menyeluruh sebelum diserahkan ke pelanggan.
                </p>
            </div>

            <!-- Bento Item 2 -->
            <div class="bg-white dark:bg-surface-dark p-6 sm:p-8 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">price_check</span>
                </div>
                <h3 class="text-lg font-bold text-on-surface dark:text-on-surface-dark">Harga Pasti Tanpa Biaya Tersembunyi</h3>
                <p class="text-sm text-text-muted dark:text-text-muted-dark leading-relaxed">
                    Semua biaya dihitung transparan per hari. Tidak ada biaya tambahan mendadak saat pengambilan maupun pengembalian unit.
                </p>
            </div>

            <!-- Bento Item 3 -->
            <div class="bg-white dark:bg-surface-dark p-6 sm:p-8 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">support_agent</span>
                </div>
                <h3 class="text-lg font-bold text-on-surface dark:text-on-surface-dark">Layanan & Bantuan 24/7</h3>
                <p class="text-sm text-text-muted dark:text-text-muted-dark leading-relaxed">
                    Tim customer support dan teknisi siaga 24 jam untuk membantu jika Anda memerlukan bantuan selama masa sewa.
                </p>
            </div>
        </div>
    </section>

</div>
@endsection
