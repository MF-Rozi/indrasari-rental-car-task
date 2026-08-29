@extends('layouts.app')

@section('title', 'Pengembalian Mobil - Indrasari Rental Car')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-8">

    <!-- Header Section -->
    <div class="text-center max-w-2xl mx-auto space-y-2">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container dark:bg-surface-container-dark border border-outline-variant/60 dark:border-outline-dark/60 text-xs font-bold text-primary dark:text-inverse-primary uppercase tracking-wider">
            <span class="material-symbols-outlined text-[16px]">assignment_return</span>
            <span>Layanan Pengembalian Kendaraan</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface dark:text-on-surface-dark">
            Formulir Pengembalian Unit Mobil
        </h1>
        <p class="text-xs sm:text-sm text-text-muted dark:text-text-muted-dark">
            Masukkan nomor plat mobil yang Anda sewa untuk memverifikasi data jadwal, denda keterlambatan, dan menyelesaikan serah terima unit.
        </p>
    </div>

    @if($activeRentals->isEmpty())
        <!-- Empty State if Customer Has No Active Rentals -->
        <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-10 text-center space-y-4 shadow-sm">
            <div class="w-16 h-16 rounded-full bg-primary/10 text-primary dark:text-inverse-primary mx-auto flex items-center justify-center">
                <span class="material-symbols-outlined text-[32px]">no_crash</span>
            </div>
            <div class="space-y-1 max-w-md mx-auto">
                <h3 class="text-lg font-bold text-on-surface dark:text-on-surface-dark">
                    Tidak Ada Sewa Mobil Aktif
                </h3>
                <p class="text-xs text-text-muted dark:text-text-muted-dark">
                    Akun Anda saat ini tidak memiliki transaksi sewa mobil yang sedang aktif untuk dikembalikan.
                </p>
            </div>
            <div class="pt-2 flex items-center justify-center gap-3">
                <a href="{{ route('fleet.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold shadow-md shadow-primary/20 transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">directions_car</span>
                    <span>Sewa Mobil Sekarang</span>
                </a>
                <a href="{{ route('rentals.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">history</span>
                    <span>Lihat Riwayat Sewa</span>
                </a>
            </div>
        </div>
    @else

        <!-- Step 1: Input & Verification Form -->
        <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-5">
            <div>
                <h2 class="text-base font-bold text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-primary text-white text-xs flex items-center justify-center font-bold">1</span>
                    <span>Verifikasi Nomor Plat Kendaraan</span>
                </h2>
                <p class="text-xs text-text-muted dark:text-text-muted-dark mt-1">
                    Sistem akan mencocokkan plat nomor dengan transaksi sewa aktif Anda untuk menghitung durasi dan denda otomatis.
                </p>
            </div>

            <form id="verifyReturnForm" onsubmit="event.preventDefault(); handlePlateSubmit();" class="space-y-4">
                <div class="space-y-2">
                    <label for="plateInput" class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Nomor Plat Kendaraan Polisi <span class="text-red-500">*</span>
                    </label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">pin</span>
                            <input 
                                type="text" 
                                id="plateInput" 
                                required 
                                placeholder="Contoh: B 1888 MFS" 
                                value="{{ old('plate_number', request('plate', $selectedRental ? $selectedRental->fleet->plate_number : '')) }}" 
                                class="w-full pl-11 pr-4 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-base font-mono font-bold uppercase text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" 
                            />
                        </div>
                        <button type="submit" id="verifyPlateBtn" class="py-2.5 px-6 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                            <span>Verifikasi Plat</span>
                        </button>
                    </div>
                </div>

                <!-- Quick Auto-Fill Chips -->
                <div class="flex flex-wrap items-center gap-2 pt-1">
                    <span class="text-xs text-text-muted dark:text-text-muted-dark font-medium">Unit Aktif Anda:</span>
                    @foreach($activeRentals as $activeItem)
                        <button 
                            type="button" 
                            onclick="selectActivePlate('{{ $activeItem->fleet->plate_number }}')" 
                            class="px-2.5 py-1 rounded-lg bg-surface-container dark:bg-surface-container-dark hover:bg-primary/10 text-xs font-mono font-semibold text-primary dark:text-inverse-primary border border-outline-variant/60 dark:border-outline-dark/60 cursor-pointer transition-colors flex items-center gap-1.5"
                        >
                            <span class="w-1.5 h-1.5 rounded-full {{ $activeItem->isOverdue() ? 'bg-red-500' : 'bg-emerald-500' }}"></span>
                            <span>{{ $activeItem->fleet->plate_number }} ({{ $activeItem->fleet->brand }} {{ $activeItem->fleet->model }})</span>
                        </button>
                    @endforeach
                </div>
            </form>

            <!-- Verification Error Message Banner -->
            <div id="verifyErrorBanner" class="hidden p-4 rounded-xl bg-red-50 dark:bg-red-950/80 border border-red-200 dark:border-red-800 text-xs text-red-700 dark:text-red-300 flex items-start gap-2.5">
                <span class="material-symbols-outlined text-[18px] text-red-600 dark:text-red-400 shrink-0 mt-0.5">error</span>
                <div class="space-y-0.5">
                    <strong class="font-bold block">Verifikasi Plat Gagal</strong>
                    <span id="verifyErrorMessage">Nomor plat tidak ditemukan pada daftar sewa aktif Anda.</span>
                </div>
            </div>
        </div>

        <!-- Step 2: Calculation & Return Dossier Panel (Dynamic) -->
        <div id="calculationPanel" class="{{ $selectedRental ? '' : 'hidden' }} bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-6">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-outline-variant/50 dark:border-outline-dark/50 pb-4">
                <div>
                    <h2 class="text-base font-bold text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-emerald-600 text-white text-xs flex items-center justify-center font-bold">2</span>
                        <span>Hasil Verifikasi & Rincian Rekonsiliasi Tagihan</span>
                    </h2>
                    <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                        <span>Data sewa valid dan terdaftar resmi atas nama akun Anda</span>
                    </span>
                </div>
                <span id="displayPlateBadge" class="font-mono text-xs font-bold px-3 py-1 rounded-lg bg-surface-container dark:bg-surface-container-dark text-primary dark:text-inverse-primary border border-primary/20 self-start sm:self-auto">
                    {{ $selectedRental ? $selectedRental->fleet->plate_number : '' }}
                </span>
            </div>

            <!-- Vehicle Summary Bento Card -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 p-4 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/40 dark:border-outline-dark/40">
                <div class="w-full sm:w-40 h-28 rounded-lg overflow-hidden bg-surface-container dark:bg-surface-container-dark border border-slate-200 dark:border-slate-800 shrink-0" style="width: 160px; min-width: 160px; height: 110px;">
                    <img 
                        id="displayCarImage" 
                        src="{{ $selectedRental ? $selectedRental->fleet->image_url : '' }}" 
                        alt="{{ $selectedRental ? $selectedRental->fleet->full_name : '' }}" 
                        class="w-full h-full object-cover" 
                        style="width: 160px; height: 110px; object-fit: cover;" 
                        onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=400&q=80';" 
                    />
                </div>
                
                <div class="space-y-1.5 flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span id="displayCarBrand" class="text-xs uppercase font-bold text-text-muted dark:text-text-muted-dark">
                            {{ $selectedRental ? $selectedRental->fleet->brand : '' }}
                        </span>
                        <span class="text-text-muted dark:text-text-muted-dark">•</span>
                        <span id="displayRentalCode" class="font-mono text-xs font-bold text-primary dark:text-inverse-primary">
                            {{ $selectedRental ? $selectedRental->rental_code : '' }}
                        </span>
                    </div>

                    <h3 id="displayCarName" class="text-lg font-bold text-on-surface dark:text-on-surface-dark truncate">
                        {{ $selectedRental ? $selectedRental->fleet->full_name : '' }}
                    </h3>
                    
                    <p class="text-xs text-text-muted dark:text-text-muted-dark">
                        Penyewa: <strong class="text-on-surface dark:text-on-surface-dark">{{ auth()->user()->name }}</strong> • 
                        SIM A: <strong class="font-mono text-on-surface dark:text-on-surface-dark">{{ auth()->user()->driving_license_number ?? '-' }}</strong>
                    </p>
                </div>
            </div>

            <!-- Overdue Warning Alert if applicable -->
            <div id="overdueAlertBanner" class="{{ $selectedRental && $selectedRental->isOverdue() ? '' : 'hidden' }} p-4 rounded-xl bg-amber-50 dark:bg-amber-950/80 border border-amber-300 dark:border-amber-700 text-amber-900 dark:text-amber-200 text-xs space-y-1">
                <div class="flex items-center gap-2 font-bold text-amber-800 dark:text-amber-300">
                    <span class="material-symbols-outlined text-[18px]">warning</span>
                    <span>Pengembalian Melewati Batas Waktu Sewa (Overdue)</span>
                </div>
                <p id="overdueAlertText">
                    @if($selectedRental && $selectedRental->isOverdue())
                        Kendaraan ini terlambat <strong>{{ $selectedRental->daysOverdue() }} hari</strong> dari jadwal pengembalian ({{ $selectedRental->end_date->format('d M Y') }}). Denda keterlambatan dihitung otomatis per hari kalender.
                    @endif
                </p>
            </div>

            <!-- Schedule & Duration Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                <div class="p-4 rounded-xl border border-outline-variant/60 dark:border-outline-dark/60 bg-background dark:bg-background-dark space-y-1">
                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Tanggal Mulai Sewa</span>
                    <strong id="displayStartDate" class="text-xs sm:text-sm font-bold text-on-surface dark:text-on-surface-dark block">
                        {{ $selectedRental ? $selectedRental->start_date->format('d M Y') : '-' }}
                    </strong>
                    <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-medium block">Resmi Diambil</span>
                </div>

                <div class="p-4 rounded-xl border border-outline-variant/60 dark:border-outline-dark/60 bg-background dark:bg-background-dark space-y-1">
                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Tenggat Selesai Sewa</span>
                    <strong id="displayEndDate" class="text-xs sm:text-sm font-bold text-on-surface dark:text-on-surface-dark block">
                        {{ $selectedRental ? $selectedRental->end_date->format('d M Y') : '-' }}
                    </strong>
                    <span id="displayEndStatus" class="text-[10px] {{ $selectedRental && $selectedRental->isOverdue() ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }} font-semibold block">
                        {{ $selectedRental && $selectedRental->isOverdue() ? 'Melewati Batas' : 'Jadwal Normal' }}
                    </span>
                </div>

                <div class="p-4 rounded-xl border border-outline-variant/60 dark:border-outline-dark/60 bg-background dark:bg-background-dark space-y-1">
                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Durasi Hari Kalender</span>
                    <strong id="displayDurationDays" class="text-xs sm:text-sm font-bold text-primary dark:text-inverse-primary block">
                        {{ $selectedRental ? $selectedRental->total_days . ' Hari Inklusif' : '-' }}
                    </strong>
                    <span class="text-[10px] text-text-muted dark:text-text-muted-dark block">Per 24 Jam</span>
                </div>
            </div>

            <!-- Cost Calculation Breakdown Card -->
            <div class="p-5 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/50 dark:border-outline-dark/50 space-y-3 text-xs">
                
                <div class="flex items-center justify-between text-text-muted dark:text-text-muted-dark">
                    <span>Tarif Sewa Pokok Harian:</span>
                    <strong id="displayDailyRate" class="font-mono font-semibold text-on-surface dark:text-on-surface-dark">
                        {{ $selectedRental ? 'Rp ' . number_format((float)$selectedRental->daily_rate, 0, ',', '.') . ' / hari' : '-' }}
                    </strong>
                </div>

                <div class="flex items-center justify-between text-text-muted dark:text-text-muted-dark">
                    <span>Subtotal Sewa Pokok (Durasi Inklusif):</span>
                    <strong id="displayBaseTotalPrice" class="font-mono font-semibold text-on-surface dark:text-on-surface-dark">
                        {{ $selectedRental ? 'Rp ' . number_format((float)$selectedRental->total_price, 0, ',', '.') : '-' }}
                    </strong>
                </div>

                <div class="flex items-center justify-between text-text-muted dark:text-text-muted-dark">
                    <span>Proteksi Asuransi Kendaraan All-Risk:</span>
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">Gratis (Termasuk)</span>
                </div>

                <div class="flex items-center justify-between" id="displayPenaltyRow">
                    <span class="{{ $selectedRental && $selectedRental->isOverdue() ? 'text-red-600 dark:text-red-400 font-bold' : 'text-emerald-600 dark:text-emerald-400' }}">
                        Denda Keterlambatan:
                    </span>
                    <strong id="displayPenaltyPrice" class="font-mono font-bold {{ $selectedRental && $selectedRental->isOverdue() ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                        {{ $selectedRental ? ($selectedRental->isOverdue() ? '+ Rp ' . number_format($selectedRental->calculateLateFee(), 0, ',', '.') . ' (' . $selectedRental->daysOverdue() . ' Hari)' : 'Rp 0 (Tepat Waktu)') : 'Rp 0' }}
                    </strong>
                </div>
                
                <div class="pt-3 border-t border-outline-variant/60 dark:border-outline-dark/60 flex items-baseline justify-between">
                    <div>
                        <span class="text-xs font-bold text-on-surface dark:text-on-surface-dark uppercase tracking-wider block">Total Biaya Akhir Pelunasan</span>
                        <span class="text-[11px] text-text-muted dark:text-text-muted-dark">Sewa pokok + denda keterlambatan (jika ada)</span>
                    </div>
                    <strong id="displayGrandTotal" class="text-2xl sm:text-3xl font-extrabold text-primary dark:text-inverse-primary font-mono">
                        {{ $selectedRental ? 'Rp ' . number_format((float)$selectedRental->total_price + $selectedRental->calculateLateFee(), 0, ',', '.') : '-' }}
                    </strong>
                </div>
            </div>

            <!-- Return Submission Form -->
            <form id="submitReturnForm" action="{{ route('returns.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="rental_id" id="formRentalId" value="{{ $selectedRental ? $selectedRental->id : '' }}" />

                <div class="space-y-1.5">
                    <label for="returnNotes" class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Catatan Kondisi Unit Saat Serah Terima (Opsional):
                    </label>
                    <textarea 
                        name="return_notes" 
                        id="returnNotes" 
                        rows="2" 
                        placeholder="Contoh: Unit mobil telah dikembalikan di kantor operasional RSUD Indrasari, tangki bensin penuh, STNK & kunci diserahkan." 
                        class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none"
                    ></textarea>
                </div>

                <!-- Action Button -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('rentals.index') }}" class="w-full sm:w-auto px-5 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 transition-colors text-center cursor-pointer">
                        Kembali ke Sewa Saya
                    </a>
                    <button 
                        type="button" 
                        onclick="openConfirmReturnModal()" 
                        class="w-full sm:w-auto py-3 px-8 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs sm:text-sm font-bold shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center justify-center gap-2"
                    >
                        <span class="material-symbols-outlined text-[20px]">assignment_turned_in</span>
                        <span>Ajukan Serah Terima Pengembalian</span>
                    </button>
                </div>
            </form>

        </div>

    @endif

</div>

<!-- Confirmation Return Modal Dialog -->
<div id="confirmReturnModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4 transition-all duration-200" onclick="if(event.target === this) closeConfirmReturnModal()">
    <div class="bg-white dark:bg-surface-dark border border-outline-variant/70 dark:border-outline-dark/70 rounded-2xl max-w-lg w-full p-6 sm:p-8 shadow-2xl space-y-6 animate-in fade-in zoom-in-95 duration-150">
        
        <!-- Header -->
        <div class="flex items-start justify-between border-b border-outline-variant/60 dark:border-outline-dark/60 pb-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-primary dark:text-inverse-primary">
                    <span class="material-symbols-outlined text-[24px]">assignment_turned_in</span>
                    <h3 class="text-lg font-bold text-on-surface dark:text-on-surface-dark">
                        Konfirmasi Pengembalian Mobil
                    </h3>
                </div>
                <p class="text-xs text-text-muted dark:text-text-muted-dark">
                    Pastikan unit fisik mobil siap diserahkan kepada staf operasional RSUD Indrasari.
                </p>
            </div>
            <button type="button" onclick="closeConfirmReturnModal()" class="p-1 rounded-lg text-text-muted hover:text-on-surface dark:hover:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 transition-colors cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Summary Items -->
        <div class="p-4 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/40 dark:border-outline-dark/40 space-y-2.5 text-xs">
            <div class="flex justify-between">
                <span class="text-text-muted dark:text-text-muted-dark">Kendaraan:</span>
                <strong id="modalCarName" class="text-on-surface dark:text-on-surface-dark font-bold">-</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-text-muted dark:text-text-muted-dark">Nomor Plat Polisi:</span>
                <strong id="modalCarPlate" class="font-mono text-primary dark:text-inverse-primary font-bold">-</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-text-muted dark:text-text-muted-dark">Status Tenggat:</span>
                <strong id="modalOverdueStatus" class="font-semibold">-</strong>
            </div>
            <div class="flex justify-between border-t border-outline-variant/60 dark:border-outline-dark/60 pt-2 text-sm font-bold">
                <span class="text-on-surface dark:text-on-surface-dark">Total Biaya Akhir:</span>
                <span id="modalGrandTotal" class="text-primary dark:text-inverse-primary font-mono font-extrabold">-</span>
            </div>
        </div>

        <!-- Checkbox Declaration -->
        <label class="flex items-start gap-2.5 cursor-pointer">
            <input type="checkbox" id="agreeReturnCheck" class="mt-0.5 rounded border-slate-300 text-primary focus:ring-primary w-4 h-4 cursor-pointer" />
            <span class="text-xs text-text-muted dark:text-text-muted-dark leading-relaxed">
                Saya menyatakan bahwa kendaraan telah siap diserahterimakan dengan kunci & dokumen lengkap untuk diverifikasi oleh staf operasional.
            </span>
        </label>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 border-t border-outline-variant/60 dark:border-outline-dark/60 pt-4">
            <button type="button" onclick="closeConfirmReturnModal()" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 transition-colors cursor-pointer">
                Batal
            </button>
            <button type="button" onclick="executeReturnSubmission()" class="px-6 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold shadow-md shadow-primary/20 transition-all cursor-pointer flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                <span>Kirim Pengajuan</span>
            </button>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentVerifiedRental = @json($selectedRental ?? null);
    let currentSettlement = @json($settlement ?? null);

    function selectActivePlate(plate) {
        document.getElementById('plateInput').value = plate;
        verifyPlateAjax(plate);
    }

    function handlePlateSubmit() {
        const plate = document.getElementById('plateInput').value.trim();
        if (plate.length > 0) {
            verifyPlateAjax(plate);
        }
    }

    async function verifyPlateAjax(plate) {
        const btn = document.getElementById('verifyPlateBtn');
        const errorBanner = document.getElementById('verifyErrorBanner');
        const calcPanel = document.getElementById('calculationPanel');
        
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span><span>Memeriksa...</span>';
        errorBanner.classList.add('hidden');

        try {
            const response = await fetch("{{ route('returns.verify') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ plate_number: plate })
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                document.getElementById('verifyErrorMessage').innerText = data.message || 'Kendaraan tidak ditemukan pada daftar sewa aktif Anda.';
                errorBanner.classList.remove('hidden');
                calcPanel.classList.add('hidden');
                return;
            }

            // Update UI with verified data
            currentVerifiedRental = data.rental;
            currentSettlement = data.settlement;
            renderVerifiedData(data.rental, data.settlement);
            calcPanel.classList.remove('hidden');

            // Smooth scroll to step 2
            calcPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });

        } catch (err) {
            console.error('Error verifying plate:', err);
            document.getElementById('verifyErrorMessage').innerText = 'Terjadi kesalahan sistem saat memverifikasi nomor plat.';
            errorBanner.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">verified</span><span>Verifikasi Plat</span>';
        }
    }

    function renderVerifiedData(rental, settlement) {
        document.getElementById('formRentalId').value = rental.id;
        document.getElementById('displayPlateBadge').innerText = rental.fleet.plate_number;
        document.getElementById('displayCarBrand').innerText = rental.fleet.brand;
        document.getElementById('displayRentalCode').innerText = rental.rental_code;
        document.getElementById('displayCarName').innerText = rental.fleet.full_name;
        
        if (rental.fleet.image_url) {
            document.getElementById('displayCarImage').src = rental.fleet.image_url;
        }

        document.getElementById('displayStartDate').innerText = rental.start_date_formatted;
        document.getElementById('displayEndDate').innerText = rental.end_date_formatted;
        document.getElementById('displayDurationDays').innerText = rental.total_days + ' Hari Inklusif';

        document.getElementById('displayDailyRate').innerText = 'Rp ' + Number(rental.daily_rate).toLocaleString('id-ID') + ' / hari';
        document.getElementById('displayBaseTotalPrice').innerText = 'Rp ' + Number(rental.total_price).toLocaleString('id-ID');

        const overdueAlert = document.getElementById('overdueAlertBanner');
        const endStatus = document.getElementById('displayEndStatus');
        const penaltyPrice = document.getElementById('displayPenaltyPrice');

        if (settlement.is_overdue) {
            overdueAlert.classList.remove('hidden');
            document.getElementById('overdueAlertText').innerHTML = `Kendaraan ini terlambat <strong>${settlement.days_overdue} hari</strong> dari jadwal pengembalian (${rental.end_date_formatted}). Denda keterlambatan dihitung otomatis per hari kalender.`;
            endStatus.className = 'text-[10px] text-red-600 dark:text-red-400 font-semibold block';
            endStatus.innerText = 'Melewati Batas (' + settlement.days_overdue + ' Hari)';
            
            penaltyPrice.className = 'font-mono font-bold text-red-600 dark:text-red-400';
            penaltyPrice.innerText = '+ Rp ' + Number(settlement.penalty_price).toLocaleString('id-ID') + ' (' + settlement.days_overdue + ' Hari)';
        } else {
            overdueAlert.classList.add('hidden');
            endStatus.className = 'text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold block';
            endStatus.innerText = 'Jadwal Normal (Tepat Waktu)';

            penaltyPrice.className = 'font-mono font-bold text-emerald-600 dark:text-emerald-400';
            penaltyPrice.innerText = 'Rp 0 (Tepat Waktu)';
        }

        document.getElementById('displayGrandTotal').innerText = 'Rp ' + Number(settlement.grand_total).toLocaleString('id-ID');
    }

    function openConfirmReturnModal() {
        if (!currentVerifiedRental) return;

        const rental = currentVerifiedRental;
        const settlement = currentSettlement || {};

        document.getElementById('modalCarName').innerText = rental.fleet ? rental.fleet.full_name : (rental.fleet_full_name || 'Unit Mobil');
        document.getElementById('modalCarPlate').innerText = rental.fleet ? rental.fleet.plate_number : (rental.plate_number || '-');
        
        const overdueEl = document.getElementById('modalOverdueStatus');
        if (settlement.is_overdue) {
            overdueEl.className = 'font-bold text-red-600 dark:text-red-400';
            overdueEl.innerText = `Terlambat ${settlement.days_overdue} Hari (Denda Rp ${Number(settlement.penalty_price).toLocaleString('id-ID')})`;
        } else {
            overdueEl.className = 'font-semibold text-emerald-600 dark:text-emerald-400';
            overdueEl.innerText = 'Tepat Waktu (Tanpa Denda)';
        }

        const grandTotal = settlement.grand_total || rental.total_price;
        document.getElementById('modalGrandTotal').innerText = 'Rp ' + Number(grandTotal).toLocaleString('id-ID');
        document.getElementById('agreeReturnCheck').checked = false;

        const modal = document.getElementById('confirmReturnModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeConfirmReturnModal() {
        const modal = document.getElementById('confirmReturnModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function executeReturnSubmission() {
        const agree = document.getElementById('agreeReturnCheck').checked;
        if (!agree) {
            alert('Silakan centang pernyataan kesiapan serah terima sebelum melanjutkan.');
            return;
        }

        document.getElementById('submitReturnForm').submit();
    }

    // Keyboard ESC listener
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeConfirmReturnModal();
        }
    });
</script>
@endpush
