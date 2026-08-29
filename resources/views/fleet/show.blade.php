@extends('layouts.app')

@section('title', $car->brand . ' ' . $car->model . ' (' . $car->year . ') - Indrasari Rental Car')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-8">

    <!-- Breadcrumb Nav -->
    <nav class="flex items-center gap-2 text-xs text-text-muted dark:text-text-muted-dark">
        <a href="{{ url('/') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('fleet.index') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Armada Mobil</a>
        <span>/</span>
        <span class="text-on-surface dark:text-on-surface-dark font-semibold">{{ $car->brand }} {{ $car->model }}</span>
    </nav>

    <!-- Main 2-Column Showcase Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
        
        <!-- Left 7 Cols: Image Gallery, Specs, Description -->
        <div class="lg:col-span-7 space-y-8">
            
            <!-- Vehicle Gallery -->
            <div class="space-y-3">
                <div class="relative h-[320px] sm:h-[420px] bg-surface-container dark:bg-surface-container-dark rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm group">
                    <img id="mainVehicleImage" src="{{ $car->image_url }}" alt="{{ $car->full_name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-102" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80';" />
                    <div class="absolute top-4 left-4">
                        @if($car->availability === 'available')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/80 dark:text-emerald-300 dark:border-emerald-800 shadow-sm backdrop-blur-xs">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Unit Siap Disewa
                            </span>
                        @elseif($car->availability === 'rented')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/80 dark:text-blue-300 dark:border-blue-800 shadow-sm backdrop-blur-xs">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                Sedang Disewa
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/80 dark:text-amber-300 dark:border-amber-800 shadow-sm backdrop-blur-xs">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                Dalam Perawatan
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Thumbnails Strip -->
                @php
                    $allThumbnails = [$car->image_url];
                    if (!empty($car->gallery_urls)) {
                        foreach ($car->gallery_urls as $gUrl) {
                            if (!in_array($gUrl, $allThumbnails)) {
                                $allThumbnails[] = $gUrl;
                            }
                        }
                    }
                @endphp

                @if(count($allThumbnails) > 1)
                    <div class="grid grid-cols-4 sm:grid-cols-5 gap-3">
                        @foreach($allThumbnails as $idx => $thumb)
                            <button type="button" onclick="changeGalleryImage('{{ $thumb }}', this)" class="gallery-thumb-btn relative h-18 sm:h-20 rounded-xl overflow-hidden border-2 {{ $idx === 0 ? 'border-primary dark:border-inverse-primary' : 'border-slate-200 dark:border-slate-800' }} focus:outline-none transition-all hover:opacity-90 cursor-pointer">
                                <img src="{{ $thumb }}" alt="Thumbnail {{ $idx + 1 }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=300&q=80';" />
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Vehicle Header Info -->
            <div class="space-y-2 border-b border-outline-variant/60 dark:border-outline-dark/60 pb-6">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary dark:text-inverse-primary">
                        Kategori {{ $car->type }}
                    </span>
                    <span class="font-mono text-xs font-semibold px-2.5 py-1 rounded-md bg-surface-container dark:bg-surface-container-dark text-on-surface dark:text-on-surface-dark border border-outline-variant/50 dark:border-outline-dark/50">
                        {{ $car->plate_number }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-on-surface dark:text-on-surface-dark tracking-tight">
                    {{ $car->brand }} {{ $car->model }}
                </h1>
                <p class="text-xs text-text-muted dark:text-text-muted-dark">
                    Tahun Pembuatan {{ $car->year }} • Warna {{ $car->color }} • Operasional Pool RSUD Indrasari
                </p>
            </div>

            <!-- Specifications Grid -->
            <div class="space-y-4">
                <h2 class="text-base font-bold text-on-surface dark:text-on-surface-dark">
                    Spesifikasi Lengkap Unit Kendaraan
                </h2>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div class="p-3.5 rounded-xl bg-surface-container dark:bg-surface-container-dark border border-outline-variant/40 dark:border-outline-dark/40 space-y-1">
                        <div class="flex items-center gap-1.5 text-text-muted dark:text-text-muted-dark text-xs">
                            <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">settings</span>
                            <span>Transmisi</span>
                        </div>
                        <strong class="text-sm font-semibold text-on-surface dark:text-on-surface-dark block">
                            {{ $car->transmission }}
                        </strong>
                    </div>

                    <div class="p-3.5 rounded-xl bg-surface-container dark:bg-surface-container-dark border border-outline-variant/40 dark:border-outline-dark/40 space-y-1">
                        <div class="flex items-center gap-1.5 text-text-muted dark:text-text-muted-dark text-xs">
                            <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">local_gas_station</span>
                            <span>Bahan Bakar</span>
                        </div>
                        <strong class="text-sm font-semibold text-on-surface dark:text-on-surface-dark block">
                            {{ $car->fuel_type }}
                        </strong>
                    </div>

                    <div class="p-3.5 rounded-xl bg-surface-container dark:bg-surface-container-dark border border-outline-variant/40 dark:border-outline-dark/40 space-y-1">
                        <div class="flex items-center gap-1.5 text-text-muted dark:text-text-muted-dark text-xs">
                            <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">airline_seat_recline_extra</span>
                            <span>Kapasitas</span>
                        </div>
                        <strong class="text-sm font-semibold text-on-surface dark:text-on-surface-dark block">
                            {{ $car->seat_capacity }} Penumpang
                        </strong>
                    </div>

                    <div class="p-3.5 rounded-xl bg-surface-container dark:bg-surface-container-dark border border-outline-variant/40 dark:border-outline-dark/40 space-y-1">
                        <div class="flex items-center gap-1.5 text-text-muted dark:text-text-muted-dark text-xs">
                            <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">calendar_month</span>
                            <span>Tahun</span>
                        </div>
                        <strong class="text-sm font-semibold text-on-surface dark:text-on-surface-dark block">
                            {{ $car->year }}
                        </strong>
                    </div>

                    <div class="p-3.5 rounded-xl bg-surface-container dark:bg-surface-container-dark border border-outline-variant/40 dark:border-outline-dark/40 space-y-1">
                        <div class="flex items-center gap-1.5 text-text-muted dark:text-text-muted-dark text-xs">
                            <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">palette</span>
                            <span>Warna Unit</span>
                        </div>
                        <strong class="text-sm font-semibold text-on-surface dark:text-on-surface-dark block">
                            {{ $car->color }}
                        </strong>
                    </div>

                    <div class="p-3.5 rounded-xl bg-surface-container dark:bg-surface-container-dark border border-outline-variant/40 dark:border-outline-dark/40 space-y-1">
                        <div class="flex items-center gap-1.5 text-text-muted dark:text-text-muted-dark text-xs">
                            <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">verified_user</span>
                            <span>Asuransi</span>
                        </div>
                        <strong class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 block">
                            All-Risk Proteksi
                        </strong>
                    </div>
                </div>
            </div>

            <!-- Rental Rules & Terms -->
            <div class="p-5 rounded-2xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/60 dark:border-outline-dark/60 space-y-3">
                <h3 class="font-bold text-sm text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary dark:text-inverse-primary text-[18px]">info</span>
                    <span>Ketentuan dan Syarat Sewa Lepas Kunci</span>
                </h3>
                <ul class="space-y-2 text-xs text-text-muted dark:text-text-muted-dark list-disc list-inside">
                    <li>Wajib memiliki akun terverifikasi dengan **SIM A aktif** dan **e-KTP asli**.</li>
                    <li>Perhitungan tarif menggunakan durasi hari kalender inklusif $((\text{Tgl Selesai} - \text{Tgl Mulai}) + 1\text{ Hari})$.</li>
                    <li>Pengambilan dan serah terima unit dilakukan di Pool Rental Mobil Indrasari / RSUD Indrasari.</li>
                    <li>Bebas pembatalan tanpa penalti hingga 24 jam sebelum jadwal sewa dimulai.</li>
                </ul>
            </div>

        </div>

        <!-- Right 5 Cols: Interactive Sticky Booking & Price Calculator -->
        <div class="lg:col-span-5">
            <div class="sticky top-24 bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-xl space-y-6">
                
                <!-- Pricing Header -->
                <div class="flex items-baseline justify-between border-b border-outline-variant/50 dark:border-outline-dark/50 pb-5">
                    <div>
                        <span class="text-xs text-text-muted dark:text-text-muted-dark block">Tarif Sewa Harian</span>
                        <div class="flex items-baseline gap-1.5 mt-0.5">
                            <span class="text-3xl font-extrabold text-on-surface dark:text-on-surface-dark">Rp {{ number_format((int)$car->price, 0, ',', '.') }}</span>
                            <span class="text-xs text-text-muted dark:text-text-muted-dark font-medium">/ 24 Jam</span>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-800 dark:bg-blue-950/70 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                        Lepas Kunci
                    </span>
                </div>

                <!-- Schedule Selection Box -->
                <div class="space-y-4">
                    
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Tanggal Mulai Sewa <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">calendar_today</span>
                            <input type="date" id="bookStartDate" name="start_date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" onchange="calculateRentalPrice()" class="w-full pl-10 pr-3 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" required />
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Tanggal Pengembalian (Selesai) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">event</span>
                            <input type="date" id="bookEndDate" name="end_date" value="{{ date('Y-m-d', strtotime('+2 days')) }}" min="{{ date('Y-m-d') }}" onchange="calculateRentalPrice()" class="w-full pl-10 pr-3 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" required />
                        </div>
                    </div>

                    <!-- Live Calculation Breakdown -->
                    <div class="p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-2.5 text-xs text-text-muted dark:text-text-muted-dark">
                        <div class="flex items-center justify-between">
                            <span>Durasi Sewa:</span>
                            <strong id="displayDuration" class="text-on-surface dark:text-on-surface-dark font-semibold">3 Hari</strong>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Tarif (<span id="displayDailyCalc">3 x Rp {{ number_format((int)$car->price, 0, ',', '.') }}</span>):</span>
                            <span id="displaySubtotal" class="text-on-surface dark:text-on-surface-dark font-medium">Rp {{ number_format((int)$car->price * 3, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-emerald-600 dark:text-emerald-400">
                            <span>Asuransi All-Risk:</span>
                            <span class="font-semibold">Termasuk (Gratis)</span>
                        </div>
                        <div class="pt-2.5 border-t border-outline-variant/60 dark:border-outline-dark/60 flex items-baseline justify-between text-sm">
                            <span class="font-bold text-on-surface dark:text-on-surface-dark">Total Estimasi:</span>
                            <strong id="displayTotal" class="text-xl font-extrabold text-primary dark:text-inverse-primary">Rp {{ number_format((int)$car->price * 3, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <!-- Booking Action Gating based on Auth & Verification -->
                    @if($car->availability === 'available')
                        @guest
                            <a href="{{ route('login') }}" class="w-full py-3 px-6 rounded-lg bg-primary hover:bg-primary-hover text-white text-sm font-semibold shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">login</span>
                                <span>Masuk Akun untuk Memesan</span>
                            </a>
                        @else
                            @if(auth()->user()->isVerified())
                                <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 flex items-center gap-2 text-xs text-emerald-800 dark:text-emerald-300 font-semibold">
                                    <span class="material-symbols-outlined text-[18px]">verified</span>
                                    <span>SIM A Anda Terverifikasi (Siap Sewa)</span>
                                </div>

                                <button type="button" onclick="openBookingModal()" class="w-full py-3 px-6 rounded-lg bg-primary hover:bg-primary-hover text-white text-sm font-semibold shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]">task_alt</span>
                                    <span>Lanjutkan Pemesanan Unit</span>
                                </button>
                            @elseif(auth()->user()->verification_status === 'pending')
                                <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 space-y-2">
                                    <div class="flex items-center gap-2 text-xs font-bold text-amber-900 dark:text-amber-300">
                                        <span class="material-symbols-outlined text-[18px]">hourglass_top</span>
                                        <span>Menunggu Verifikasi SIM A</span>
                                    </div>
                                    <p class="text-[11px] text-amber-800 dark:text-amber-400 leading-relaxed">
                                        Akun Anda sedang dalam antrean verifikasi dokumen SIM A oleh admin. Anda dapat memesan kendaraan setelah SIM disetujui.
                                    </p>
                                    <a href="{{ route('profile.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-amber-900 dark:text-amber-200 hover:underline mt-1">
                                        <span>Lihat status profil</span>
                                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                    </a>
                                </div>

                                <button type="button" disabled class="w-full py-3 px-6 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-400 dark:text-slate-600 text-sm font-semibold cursor-not-allowed flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]">lock</span>
                                    <span>Menunggu Verifikasi SIM</span>
                                </button>
                            @else
                                <div class="p-4 rounded-xl bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 space-y-2">
                                    <div class="flex items-center gap-2 text-xs font-bold text-red-900 dark:text-red-300">
                                        <span class="material-symbols-outlined text-[18px]">cancel</span>
                                        <span>Verifikasi SIM A Ditolak</span>
                                    </div>
                                    <p class="text-[11px] text-red-800 dark:text-red-400 leading-relaxed">
                                        Dokumen SIM A Anda belum memenuhi syarat. Silakan perbarui foto dokumen pada halaman profil untuk dapat menyewa mobil.
                                    </p>
                                    <a href="{{ route('profile.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-red-900 dark:text-red-200 hover:underline mt-1">
                                        <span>Perbarui SIM A di Profil</span>
                                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                    </a>
                                </div>

                                <button type="button" disabled class="w-full py-3 px-6 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-400 dark:text-slate-600 text-sm font-semibold cursor-not-allowed flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[20px]">block</span>
                                    <span>SIM A Ditolak</span>
                                </button>
                            @endif
                        @endguest
                    @else
                        <button type="button" disabled class="w-full py-3 px-6 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-500 text-sm font-semibold cursor-not-allowed flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">block</span>
                            <span>Unit Sedang Tidak Tersedia</span>
                        </button>
                    @endif

                    <p class="text-center text-[11px] text-text-muted dark:text-text-muted-dark">
                        Bebas biaya pembatalan hingga 24 jam sebelum jadwal sewa dimulai.
                    </p>
                </div>

            </div>
        </div>

    </div>

    <!-- Related Vehicles Recommendations -->
    @if(isset($relatedCars) && $relatedCars->count() > 0)
        <div class="pt-8 border-t border-outline-variant/60 dark:border-outline-dark/60 space-y-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-primary dark:text-inverse-primary">Rekomendasi Pilihan</span>
                <h2 class="text-xl sm:text-2xl font-bold text-on-surface dark:text-on-surface-dark mt-0.5">
                    Armada Serupa yang Tersedia
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedCars as $rel)
                    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-md transition-shadow flex flex-col">
                        <div class="relative h-44 bg-surface-container dark:bg-surface-container-dark overflow-hidden">
                            <img src="{{ $rel->image_url }}" alt="{{ $rel->full_name }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=600&q=80';" />
                            <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/80 dark:text-emerald-300 dark:border-emerald-800">
                                Tersedia
                            </span>
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark">{{ $rel->brand }} {{ $rel->model }}</h3>
                                <p class="text-xs text-text-muted dark:text-text-muted-dark mt-1">Tahun {{ $rel->year }} • {{ $rel->transmission }} • {{ $rel->seat_capacity }} Kursi</p>
                            </div>
                            <div class="flex items-center justify-between pt-3 border-t border-outline-variant/40 dark:border-outline-dark/40">
                                <div>
                                    <span class="text-base font-bold text-primary dark:text-inverse-primary">Rp {{ number_format((int)$rel->price, 0, ',', '.') }}</span>
                                    <span class="text-[10px] text-text-muted dark:text-text-muted-dark">/ hari</span>
                                </div>
                                <a href="{{ route('fleet.show', $rel) }}" class="px-3.5 py-1.5 rounded-lg bg-primary/10 hover:bg-primary text-primary hover:text-white dark:text-inverse-primary text-xs font-semibold transition-colors">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

<!-- Booking Confirmation Modal Dialog -->
@auth
@if(auth()->user()->isVerified())
<div id="bookingModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6 transition-all duration-200" onclick="if(event.target === this) closeBookingModal()">
    <div class="bg-white dark:bg-surface-dark border border-outline-variant/70 dark:border-outline-dark/70 rounded-2xl w-full max-w-2xl max-h-[90vh] shadow-2xl overflow-hidden flex flex-col animate-in fade-in zoom-in-95 duration-150">
        
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-outline-variant/60 dark:border-outline-dark/60 flex items-center justify-between bg-surface-container dark:bg-[#0e1b2e] shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary/10 dark:bg-primary/20 text-primary dark:text-inverse-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[22px]">directions_car</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-on-surface dark:text-on-surface-dark">
                        Konfirmasi Pemesanan Mobil
                    </h3>
                    <p class="text-xs text-text-muted dark:text-text-muted-dark">
                        {{ $car->brand }} {{ $car->model }} ({{ $car->year }})
                    </p>
                </div>
            </div>
            <button type="button" onclick="closeBookingModal()" class="w-8 h-8 rounded-lg text-text-muted hover:text-on-surface dark:hover:text-on-surface-dark hover:bg-surface-container-high dark:hover:bg-slate-800 transition-colors flex items-center justify-center cursor-pointer" title="Tutup">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Modal Scrollable Content Form -->
        <form action="{{ route('rentals.store') }}" method="POST" class="overflow-y-auto p-6 space-y-5 flex-1 text-xs">
            @csrf
            <input type="hidden" name="fleet_id" value="{{ $car->id }}">
            <input type="hidden" id="modalStartDateInput" name="start_date" value="{{ date('Y-m-d') }}">
            <input type="hidden" id="modalEndDateInput" name="end_date" value="{{ date('Y-m-d', strtotime('+2 days')) }}">

            <!-- Vehicle Summary Bento -->
            <div class="p-4 rounded-xl bg-surface-container dark:bg-[#132238] border border-outline-variant/50 dark:border-slate-700/60 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <img src="{{ $car->image_url }}" alt="{{ $car->full_name }}" class="w-full sm:w-28 h-20 rounded-lg object-cover shrink-0" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=400&q=80';" />
                <div class="space-y-1 flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-sm text-on-surface dark:text-on-surface-dark truncate">{{ $car->brand }} {{ $car->model }}</span>
                        <span class="font-mono text-[10px] font-bold px-2 py-0.5 rounded bg-white dark:bg-surface-dark text-primary dark:text-inverse-primary border border-primary/20 shrink-0">
                            {{ $car->plate_number }}
                        </span>
                    </div>
                    <p class="text-text-muted dark:text-text-muted-dark">
                        {{ $car->type }} • {{ $car->transmission }} • {{ $car->seat_capacity }} Kursi • Warna {{ $car->color }}
                    </p>
                </div>
            </div>

            <!-- Schedule & Identity Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Renter Identity -->
                <div class="p-4 rounded-xl bg-surface-container dark:bg-[#132238] border border-outline-variant/50 dark:border-slate-700/60 space-y-2">
                    <span class="font-bold text-on-surface dark:text-on-surface-dark block flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">person</span>
                        Identitas Penyewa
                    </span>
                    <div class="space-y-1 text-text-muted dark:text-text-muted-dark">
                        <p class="font-semibold text-on-surface dark:text-on-surface-dark">{{ auth()->user()->name }}</p>
                        <p>{{ auth()->user()->email }} • {{ auth()->user()->phone_number }}</p>
                        <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800 mt-1">
                            <span class="material-symbols-outlined text-[12px]">verified</span>
                            SIM A: {{ auth()->user()->driving_license_number }}
                        </div>
                    </div>
                </div>

                <!-- Schedule Span -->
                <div class="p-4 rounded-xl bg-surface-container dark:bg-[#132238] border border-outline-variant/50 dark:border-slate-700/60 space-y-2">
                    <span class="font-bold text-on-surface dark:text-on-surface-dark block flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">date_range</span>
                        Jadwal Penggunaan Unit
                    </span>
                    <div class="space-y-1">
                        <div class="flex items-center justify-between text-text-muted dark:text-text-muted-dark">
                            <span>Mulai:</span>
                            <strong id="modalDisplayStartDate" class="text-on-surface dark:text-on-surface-dark font-medium">-</strong>
                        </div>
                        <div class="flex items-center justify-between text-text-muted dark:text-text-muted-dark">
                            <span>Selesai:</span>
                            <strong id="modalDisplayEndDate" class="text-on-surface dark:text-on-surface-dark font-medium">-</strong>
                        </div>
                        <div class="flex items-center justify-between pt-1 border-t border-outline-variant/40 dark:border-slate-700/60">
                            <span>Total Durasi:</span>
                            <strong id="modalDisplayDuration" class="text-primary dark:text-inverse-primary font-bold">3 Hari</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Calculation Box -->
            <div class="p-4 rounded-xl bg-primary/5 dark:bg-primary/10 border border-primary/20 space-y-2.5">
                <div class="flex items-center justify-between text-text-muted dark:text-text-muted-dark">
                    <span>Tarif Sewa Harian:</span>
                    <span class="font-semibold text-on-surface dark:text-on-surface-dark">Rp {{ number_format((int)$car->price, 0, ',', '.') }} / hari</span>
                </div>
                <div class="flex items-center justify-between text-text-muted dark:text-text-muted-dark">
                    <span>Durasi Sewa Inklusif:</span>
                    <span id="modalDurationSpan" class="font-semibold text-on-surface dark:text-on-surface-dark">3 Hari</span>
                </div>
                <div class="flex items-center justify-between text-emerald-600 dark:text-emerald-400">
                    <span>Perlindungan Asuransi (All-Risk):</span>
                    <span class="font-bold">Gratis (Termasuk)</span>
                </div>
                <div class="pt-2 border-t border-primary/20 flex items-baseline justify-between">
                    <span class="font-bold text-sm text-on-surface dark:text-on-surface-dark">Total Biaya Sewa:</span>
                    <strong id="modalDisplayGrandTotal" class="text-xl font-extrabold text-primary dark:text-inverse-primary">
                        Rp {{ number_format((int)$car->price * 3, 0, ',', '.') }}
                    </strong>
                </div>
            </div>

            <!-- Notes Input -->
            <div class="space-y-1.5">
                <label class="block font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                    Catatan Tambahan / Tujuan Perjalanan (Opsional):
                </label>
                <textarea name="notes" rows="2" placeholder="Contoh: Perjalanan dinas ke Pekanbaru, pengambilan unit jam 08:00 WIB" class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-on-surface dark:text-on-surface-dark placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"></textarea>
            </div>

            <!-- Terms & Agreement Checkbox -->
            <div class="p-3 rounded-lg bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/40 dark:border-outline-dark/40 flex items-start gap-2">
                <input type="checkbox" id="agreeBookingTerms" required class="w-4 h-4 mt-0.5 rounded text-primary focus:ring-primary border-slate-300 dark:border-slate-700 dark:bg-background-dark cursor-pointer">
                <label for="agreeBookingTerms" class="text-[11px] text-text-muted dark:text-text-muted-dark leading-relaxed cursor-pointer">
                    Saya menyatakan data pemesanan di atas sudah benar dan menyetujui <a href="#" class="text-primary dark:text-inverse-primary font-semibold hover:underline">Syarat & Ketentuan Sewa Lepas Kunci</a> Indrasari Rental Car.
                </label>
            </div>

            <!-- Modal Footer CTA -->
            <div class="pt-2 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeBookingModal()" class="px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 transition-colors cursor-pointer">
                    Batal / Ubah Tanggal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">verified</span>
                    <span>Konfirmasi & Selesaikan Booking</span>
                </button>
            </div>
        </form>

    </div>
</div>
@endif
@endauth
@endsection

@push('scripts')
<script>
    const DAILY_RATE = {{ (int)$car->price }};

    function changeGalleryImage(url, btn) {
        document.getElementById('mainVehicleImage').src = url;
        document.querySelectorAll('.gallery-thumb-btn').forEach(b => {
            b.classList.remove('border-primary', 'dark:border-inverse-primary');
            b.classList.add('border-slate-200', 'dark:border-slate-800');
        });
        if (btn) {
            btn.classList.add('border-primary', 'dark:border-inverse-primary');
            btn.classList.remove('border-slate-200', 'dark:border-slate-800');
        }
    }

    function calculateRentalPrice() {
        const startVal = document.getElementById('bookStartDate').value;
        const endVal = document.getElementById('bookEndDate').value;

        if (startVal && endVal) {
            const startDate = new Date(startVal);
            const endDate = new Date(endVal);
            
            // Inclusive days calculation: (end - start) + 1 day
            const diffTime = endDate.getTime() - startDate.getTime();
            let diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24)) + 1;
            if (diffDays < 1) diffDays = 1;

            const total = diffDays * DAILY_RATE;

            document.getElementById('displayDuration').innerText = diffDays + ' Hari';
            document.getElementById('displayDailyCalc').innerText = diffDays + ' x Rp ' + DAILY_RATE.toLocaleString('id-ID');
            document.getElementById('displaySubtotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('displayTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');

            // Sync with Modal elements if present
            const modalStartInput = document.getElementById('modalStartDateInput');
            const modalEndInput = document.getElementById('modalEndDateInput');
            if (modalStartInput) modalStartInput.value = startVal;
            if (modalEndInput) modalEndInput.value = endVal;

            const modalDispStart = document.getElementById('modalDisplayStartDate');
            const modalDispEnd = document.getElementById('modalDisplayEndDate');
            if (modalDispStart) modalDispStart.innerText = startDate.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' });
            if (modalDispEnd) modalDispEnd.innerText = endDate.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' });

            const modalDispDur = document.getElementById('modalDisplayDuration');
            const modalDurSpan = document.getElementById('modalDurationSpan');
            if (modalDispDur) modalDispDur.innerText = diffDays + ' Hari Kalender';
            if (modalDurSpan) modalDurSpan.innerText = diffDays + ' Hari';

            const modalGrandTotal = document.getElementById('modalDisplayGrandTotal');
            if (modalGrandTotal) modalGrandTotal.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
    }

    function openBookingModal() {
        calculateRentalPrice();
        const modal = document.getElementById('bookingModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeBookingModal() {
        const modal = document.getElementById('bookingModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Keyboard ESC listener
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeBookingModal();
        }
    });

    document.addEventListener('DOMContentLoaded', calculateRentalPrice);
</script>
@endpush
