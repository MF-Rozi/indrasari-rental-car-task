@extends('layouts.app')

@section('title', 'Toyota Innova Zenix 2.0 Q Hybrid - Indrasari Rental Car')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-8">

    <!-- Breadcrumb Nav -->
    <nav class="flex items-center gap-2 text-xs text-text-muted dark:text-text-muted-dark">
        <a href="{{ url('/') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ url('/fleet') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Armada Mobil</a>
        <span>/</span>
        <span class="text-on-surface dark:text-on-surface-dark font-semibold">Toyota Innova Zenix 2.0 Q Hybrid</span>
    </nav>

    <!-- Main 2-Column Showcase Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
        
        <!-- Left 7 Cols: Image Gallery, Specs, Description -->
        <div class="lg:col-span-7 space-y-8">
            
            <!-- Vehicle Gallery -->
            <div class="space-y-3">
                <div class="relative h-[320px] sm:h-[420px] bg-surface-container dark:bg-surface-container-dark rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm">
                    <img id="mainVehicleImage" src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80" alt="Toyota Innova Zenix" class="w-full h-full object-cover" />
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Unit Siap Disewa
                        </span>
                    </div>
                </div>

                <!-- Thumbnails -->
                <div class="grid grid-cols-4 gap-3">
                    <button type="button" onclick="changeGalleryImage('https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80')" class="h-20 rounded-xl overflow-hidden border-2 border-primary dark:border-inverse-primary cursor-pointer focus:outline-none">
                        <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" />
                    </button>
                    <button type="button" onclick="changeGalleryImage('https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80')" class="h-20 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 hover:border-primary dark:hover:border-inverse-primary cursor-pointer focus:outline-none transition-colors">
                        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" />
                    </button>
                    <button type="button" onclick="changeGalleryImage('https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=1200&q=80')" class="h-20 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 hover:border-primary dark:hover:border-inverse-primary cursor-pointer focus:outline-none transition-colors">
                        <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" />
                    </button>
                    <button type="button" onclick="changeGalleryImage('https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80')" class="h-20 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 hover:border-primary dark:hover:border-inverse-primary cursor-pointer focus:outline-none transition-colors">
                        <img src="https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" />
                    </button>
                </div>
            </div>

            <!-- Vehicle Specs Bento -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 space-y-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-primary dark:text-inverse-primary">Spesifikasi Lengkap</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-on-surface dark:text-on-surface-dark mt-1">
                        Fitur & Performa Kendaraan
                    </h2>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-1">
                        <span class="material-symbols-outlined text-primary dark:text-inverse-primary text-2xl">airline_seat_recline_normal</span>
                        <span class="text-xs text-text-muted dark:text-text-muted-dark block">Kapasitas</span>
                        <span class="text-sm font-bold text-on-surface dark:text-on-surface-dark">7 Penumpang</span>
                    </div>
                    <div class="p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-1">
                        <span class="material-symbols-outlined text-primary dark:text-inverse-primary text-2xl">settings</span>
                        <span class="text-xs text-text-muted dark:text-text-muted-dark block">Transmisi</span>
                        <span class="text-sm font-bold text-on-surface dark:text-on-surface-dark">Matic (CVT)</span>
                    </div>
                    <div class="p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-1">
                        <span class="material-symbols-outlined text-primary dark:text-inverse-primary text-2xl">local_gas_station</span>
                        <span class="text-xs text-text-muted dark:text-text-muted-dark block">Bahan Bakar</span>
                        <span class="text-sm font-bold text-on-surface dark:text-on-surface-dark">Hybrid Bensin</span>
                    </div>
                    <div class="p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-1">
                        <span class="material-symbols-outlined text-primary dark:text-inverse-primary text-2xl">pin</span>
                        <span class="text-xs text-text-muted dark:text-text-muted-dark block">Nomor Plat</span>
                        <span class="text-sm font-bold font-mono text-on-surface dark:text-on-surface-dark">B 2419 IND</span>
                    </div>
                </div>

                <!-- Description Prose -->
                <div class="space-y-3 text-sm text-text-muted dark:text-text-muted-dark leading-relaxed border-t border-outline-variant/50 dark:border-outline-dark/50 pt-5">
                    <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark">Deskripsi Unit</h3>
                    <p>
                        Toyota Innova Zenix Hybrid tipe Q adalah pilihan prima untuk perjalanan dinas maupun liburan keluarga. Mengusung platform TNGA yang sangat stabil dan senyap, dilengkapi fitur kenyamanan seperti Captain Seat dengan Ottoman elektrik, Panoramic Sunroof, serta teknologi keselamatan aktif Toyota Safety Sense (TSS).
                    </p>
                    <p>
                        Unit selalu disterilisasi, memiliki riwayat servis berkala resmi di Auto2000, serta dilengkapi fasilitas darurat seperti ban serep, dongkrak, dan segitiga pengaman.
                    </p>
                </div>
            </div>

            <!-- Rental Terms & Requirements -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 space-y-4">
                <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">verified</span>
                    <span>Persyaratan & Ketentuan Sewa</span>
                </h3>
                <ul class="space-y-2 text-xs sm:text-sm text-text-muted dark:text-text-muted-dark list-disc list-inside leading-relaxed">
                    <li>Wajib memiliki <strong>SIM A aktif</strong> yang masih berlaku sesuai identitas peminjam.</li>
                    <li>Menunjukkan identitas resmi asli (KTP / Paspor) saat serah terima kendaraan.</li>
                    <li>Mobil diserahkan dalam kondisi tangki bahan bakar penuh dan wajib dikembalikan dalam kondisi yang sama.</li>
                    <li>Termasuk asuransi perlindungan standar (All-Risk Coverage).</li>
                </ul>
            </div>

        </div>

        <!-- Right 5 Cols: Interactive Sticky Booking & Price Calculator -->
        <div class="lg:col-span-5">
            <div class="sticky top-24 bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-lg space-y-6">
                
                <!-- Pricing Header -->
                <div class="flex items-baseline justify-between border-b border-outline-variant/50 dark:border-outline-dark/50 pb-5">
                    <div>
                        <span class="text-xs text-text-muted dark:text-text-muted-dark block">Tarif Harian</span>
                        <div class="flex items-baseline gap-1.5 mt-0.5">
                            <span class="text-3xl font-bold text-on-surface dark:text-on-surface-dark">Rp 650.000</span>
                            <span class="text-xs text-text-muted dark:text-text-muted-dark font-medium">/ 24 Jam</span>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-800 dark:bg-blue-950/70 dark:text-blue-300">
                        Lepas Kunci
                    </span>
                </div>

                <!-- Booking Schedule Form -->
                <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Pemesanan unit Innova Zenix berhasil diajukan!');" class="space-y-4">
                    
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Tanggal Mulai Sewa <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">calendar_today</span>
                            <input type="date" id="bookStartDate" value="{{ date('Y-m-d') }}" onchange="calculateRentalPrice()" class="w-full pl-10 pr-3 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" required />
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Tanggal Pengembalian (Selesai) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">event</span>
                            <input type="date" id="bookEndDate" value="{{ date('Y-m-d', strtotime('+3 days')) }}" onchange="calculateRentalPrice()" class="w-full pl-10 pr-3 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" required />
                        </div>
                    </div>

                    <!-- Live Calculation Breakdown -->
                    <div class="p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-2.5 text-xs text-text-muted dark:text-text-muted-dark">
                        <div class="flex items-center justify-between">
                            <span>Durasi Sewa:</span>
                            <strong id="displayDuration" class="text-on-surface dark:text-on-surface-dark font-semibold">3 Hari</strong>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Tarif (3 x Rp 650.000):</span>
                            <span id="displaySubtotal" class="text-on-surface dark:text-on-surface-dark">Rp 1.950.000</span>
                        </div>
                        <div class="flex items-center justify-between text-emerald-600 dark:text-emerald-400">
                            <span>Asuransi All-Risk:</span>
                            <span class="font-semibold">Termasuk (Gratis)</span>
                        </div>
                        <div class="pt-2 border-t border-outline-variant/60 dark:border-outline-dark/60 flex items-baseline justify-between text-sm">
                            <span class="font-bold text-on-surface dark:text-on-surface-dark">Total Biaya:</span>
                            <strong id="displayTotal" class="text-lg font-bold text-primary dark:text-inverse-primary">Rp 1.950.000</strong>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 px-6 rounded-lg bg-primary hover:bg-primary-hover text-white text-sm font-semibold shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">task_alt</span>
                        <span>Pesan Mobil Ini Sekarang</span>
                    </button>

                    <p class="text-center text-[11px] text-text-muted dark:text-text-muted-dark">
                        Tidak ada biaya pembatalan hingga 24 jam sebelum waktu sewa dimulai.
                    </p>
                </form>

            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    const DAILY_RATE = 650000;

    function changeGalleryImage(url) {
        document.getElementById('mainVehicleImage').src = url;
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
            document.getElementById('displaySubtotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('displayTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
    }

    document.addEventListener('DOMContentLoaded', calculateRentalPrice);
</script>
@endpush
