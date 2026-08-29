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
                        @foreach($allThumbnails as $idx => $thumbUrl)
                            <button type="button" onclick="changeGalleryImage('{{ $thumbUrl }}', this)" class="gallery-thumb-btn h-20 rounded-xl overflow-hidden border-2 {{ $idx === 0 ? 'border-primary dark:border-inverse-primary' : 'border-slate-200 dark:border-slate-800' }} hover:border-primary dark:hover:border-inverse-primary cursor-pointer focus:outline-none transition-all">
                                <img src="{{ $thumbUrl }}" alt="Thumbnail {{ $idx + 1 }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=400&q=80';" />
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Vehicle Specs Bento -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 space-y-6 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-outline-variant/50 dark:border-outline-dark/50 pb-5">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-primary dark:text-inverse-primary">Spesifikasi Lengkap</span>
                        <h1 class="text-2xl sm:text-3xl font-bold text-on-surface dark:text-on-surface-dark mt-1">
                            {{ $car->brand }} {{ $car->model }}
                        </h1>
                    </div>
                    <span class="font-mono font-bold text-sm px-3 py-1 rounded-lg bg-surface-container dark:bg-surface-container-dark text-primary dark:text-inverse-primary border border-outline-variant/60 dark:border-outline-dark/60 w-fit">
                        {{ $car->plate_number }}
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-1">
                        <span class="material-symbols-outlined text-primary dark:text-inverse-primary text-2xl">airline_seat_recline_normal</span>
                        <span class="text-xs text-text-muted dark:text-text-muted-dark block">Kapasitas</span>
                        <span class="text-sm font-bold text-on-surface dark:text-on-surface-dark">{{ $car->seat_capacity }} Penumpang</span>
                    </div>
                    <div class="p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-1">
                        <span class="material-symbols-outlined text-primary dark:text-inverse-primary text-2xl">settings</span>
                        <span class="text-xs text-text-muted dark:text-text-muted-dark block">Transmisi</span>
                        <span class="text-sm font-bold text-on-surface dark:text-on-surface-dark">{{ $car->transmission }}</span>
                    </div>
                    <div class="p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-1">
                        <span class="material-symbols-outlined text-primary dark:text-inverse-primary text-2xl">local_gas_station</span>
                        <span class="text-xs text-text-muted dark:text-text-muted-dark block">Bahan Bakar</span>
                        <span class="text-sm font-bold text-on-surface dark:text-on-surface-dark">{{ $car->fuel_type }}</span>
                    </div>
                    <div class="p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-1">
                        <span class="material-symbols-outlined text-primary dark:text-inverse-primary text-2xl">calendar_today</span>
                        <span class="text-xs text-text-muted dark:text-text-muted-dark block">Tahun / Warna</span>
                        <span class="text-sm font-bold text-on-surface dark:text-on-surface-dark">{{ $car->year }} • {{ $car->color }}</span>
                    </div>
                </div>

                <!-- Description Prose -->
                <div class="space-y-3 text-sm text-text-muted dark:text-text-muted-dark leading-relaxed border-t border-outline-variant/50 dark:border-outline-dark/50 pt-5">
                    <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark">Deskripsi & Kondisi Unit</h3>
                    <p>
                        Unit <strong>{{ $car->brand }} {{ $car->model }}</strong> (Tahun {{ $car->year }}) adalah kendaraan kategori {{ $car->type }} pilihan utama untuk operasional keluarga, dinas perkantoran, maupun perjalanan luar kota. Dilengkapi pendingin kabin (AC) ganda yang sejuk, sistem audio multimedia modern, serta fitur keselamatan terkini.
                    </p>
                    <p>
                        Setiap unit mobil di Indrasari selalu melalui inspeksi kebersihan 100 poin, servis rutin resmi, serta dibekali perlengkapan darurat standar (ban cadangan, dongkrak, dan kotak P3K).
                    </p>
                </div>
            </div>

            <!-- Rental Terms & Requirements -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 space-y-4 shadow-xs">
                <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[22px]">verified</span>
                    <span>Persyaratan & Jaminan Sewa</span>
                </h3>
                <ul class="space-y-2.5 text-xs sm:text-sm text-text-muted dark:text-text-muted-dark leading-relaxed">
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">check_circle</span>
                        <span>Wajib memiliki <strong>SIM A aktif</strong> yang masih berlaku sesuai identitas peminjam.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">check_circle</span>
                        <span>Menunjukkan identitas resmi asli (KTP / Paspor) saat serah terima kendaraan di lokasi.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">check_circle</span>
                        <span>Kebijakan BBM <em>Full-to-Full</em> (diserahkan penuh dan dikembalikan dalam kondisi penuh).</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">check_circle</span>
                        <span>Termasuk perlindungan asuransi standar (All-Risk Coverage) selama masa sewa aktif.</span>
                    </li>
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

                <!-- Booking Schedule Form -->
                <form action="{{ url('/rentals') }}" method="GET" class="space-y-4">
                    
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Tanggal Mulai Sewa <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">calendar_today</span>
                            <input type="date" id="bookStartDate" name="start_date" value="{{ date('Y-m-d') }}" onchange="calculateRentalPrice()" class="w-full pl-10 pr-3 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" required />
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Tanggal Pengembalian (Selesai) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">event</span>
                            <input type="date" id="bookEndDate" name="end_date" value="{{ date('Y-m-d', strtotime('+3 days')) }}" onchange="calculateRentalPrice()" class="w-full pl-10 pr-3 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" required />
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

                    @if($car->availability === 'available')
                        @auth
                            <button type="submit" class="w-full py-3 px-6 rounded-lg bg-primary hover:bg-primary-hover text-white text-sm font-semibold shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">task_alt</span>
                                <span>Pesan Mobil Ini Sekarang</span>
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="w-full py-3 px-6 rounded-lg bg-primary hover:bg-primary-hover text-white text-sm font-semibold shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">login</span>
                                <span>Masuk Akun untuk Memesan</span>
                            </a>
                        @endauth
                    @else
                        <button type="button" disabled class="w-full py-3 px-6 rounded-lg bg-slate-200 dark:bg-slate-800 text-slate-500 text-sm font-semibold cursor-not-allowed flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">block</span>
                            <span>Unit Sedang Tidak Tersedia</span>
                        </button>
                    @endif

                    <p class="text-center text-[11px] text-text-muted dark:text-text-muted-dark">
                        Bebas biaya pembatalan hingga 24 jam sebelum jadwal sewa dimulai.
                    </p>
                </form>

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
            
            const diffTime = endDate - startDate;
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            if (diffDays < 1) diffDays = 1;

            const total = diffDays * DAILY_RATE;

            document.getElementById('displayDuration').innerText = diffDays + ' Hari';
            document.getElementById('displayDailyCalc').innerText = diffDays + ' x Rp ' + DAILY_RATE.toLocaleString('id-ID');
            document.getElementById('displaySubtotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('displayTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
    }

    document.addEventListener('DOMContentLoaded', calculateRentalPrice);
</script>
@endpush

