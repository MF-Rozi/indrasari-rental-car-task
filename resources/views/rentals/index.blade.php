@extends('layouts.app')

@section('title', 'Sewa Saya - Indrasari Rental Car')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-8">

    <!-- Page Header Banner -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-2 text-xs font-bold text-primary dark:text-inverse-primary uppercase tracking-wider">
                <span class="material-symbols-outlined text-[16px]">key</span>
                <span>Aktivitas Rental Pelanggan</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface dark:text-on-surface-dark">
                Daftar Sewa Mobil Saya
            </h1>
            <p class="text-xs sm:text-sm text-text-muted dark:text-text-muted-dark">
                Pantau status kendaraan yang sedang Anda gunakan dan lihat kuitansi riwayat peminjaman sebelumnya.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('returns.index') }}" class="px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 hover:text-primary dark:hover:text-inverse-primary transition-colors flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">assignment_return</span>
                <span>Kembalikan Mobil</span>
            </a>
            <a href="{{ route('fleet.index') }}" class="px-4 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span>Sewa Mobil Baru</span>
            </a>
        </div>
    </div>

    <!-- Tab Selector -->
    <div class="flex items-center gap-2 border-b border-outline-variant/60 dark:border-outline-dark/60">
        <button type="button" id="tabActiveBtn" onclick="switchRentalTab('active')" class="pb-3 px-4 text-xs sm:text-sm font-bold border-b-2 border-primary text-primary dark:text-inverse-primary cursor-pointer transition-colors flex items-center gap-2">
            <span>Sedang Disewa (Aktif)</span>
            <span class="px-2 py-0.5 rounded-full text-xs bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 font-bold">
                {{ $activeRentals->count() }} Unit
            </span>
        </button>
        <button type="button" id="tabHistoryBtn" onclick="switchRentalTab('history')" class="pb-3 px-4 text-xs sm:text-sm font-semibold border-b-2 border-transparent text-text-muted dark:text-text-muted-dark hover:text-on-surface dark:hover:text-on-surface-dark cursor-pointer transition-colors flex items-center gap-2">
            <span>Riwayat Selesai</span>
            <span class="px-2 py-0.5 rounded-full text-xs bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                {{ $historyRentals->count() }} Riwayat
            </span>
        </button>
    </div>

    <!-- Active Rentals Panel -->
    <div id="activeRentalsPanel" class="space-y-6">
        @forelse($activeRentals as $rental)
            <div class="bg-white dark:bg-surface-dark rounded-2xl border {{ $rental->isOverdue() ? 'border-red-400 dark:border-red-700 ring-2 ring-red-400/20' : 'border-slate-200 dark:border-slate-800 hover:border-primary/40 dark:hover:border-inverse-primary/40' }} p-6 shadow-sm flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6 transition-all">
                
                <!-- Left: Vehicle Image & Info -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 flex-1 min-w-0">
                    <div class="rounded-xl overflow-hidden bg-surface-container dark:bg-surface-container-dark border border-slate-200 dark:border-slate-800 shrink-0" style="width: 220px; min-width: 220px; max-width: 220px; height: 140px;">
                        <img src="{{ $rental->fleet->image_url }}" alt="{{ $rental->fleet->full_name }}" class="w-full h-full object-cover" style="width: 220px; height: 140px; object-fit: cover;" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=500&q=80';" />
                    </div>
                    
                    <div class="space-y-2.5 flex-1 min-w-0 w-full">
                        <div class="flex flex-wrap items-center gap-2">
                            @if($rental->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/70 dark:text-blue-300 dark:border-blue-800">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span>
                                    Sedang Digunakan
                                </span>
                            @elseif($rental->status === 'pending_return')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/70 dark:text-amber-300 dark:border-amber-800">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu Verifikasi Kembali
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-800 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700">
                                    {{ ucfirst($rental->status) }}
                                </span>
                            @endif

                            <span class="font-mono text-xs font-bold px-2.5 py-0.5 rounded bg-surface-container dark:bg-surface-container-dark text-primary dark:text-inverse-primary border border-primary/20">
                                {{ $rental->fleet->plate_number }}
                            </span>

                            <span class="font-mono text-xs text-text-muted dark:text-text-muted-dark">
                                Ref: {{ $rental->rental_code }}
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-on-surface dark:text-on-surface-dark truncate">
                            {{ $rental->fleet->brand }} {{ $rental->fleet->model }}
                        </h3>

                        <!-- Overdue Warning Badge -->
                        @if($rental->isOverdue())
                            <div class="p-2.5 rounded-lg bg-red-50 dark:bg-red-950/80 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-xs font-semibold flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px] text-red-600 dark:text-red-400 shrink-0">warning</span>
                                <span>Melewati batas pengembalian: <strong>{{ $rental->daysOverdue() }} Hari</strong> (Estimasi Denda: Rp {{ number_format($rental->calculateLateFee(), 0, ',', '.') }})</span>
                            </div>
                        @endif

                        <div class="flex flex-wrap items-center gap-4 text-xs text-text-muted dark:text-text-muted-dark">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">calendar_today</span>
                                <span>Mulai: <strong class="text-on-surface dark:text-on-surface-dark">{{ $rental->start_date->format('d M Y') }}</strong></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">event</span>
                                <span>Selesai: <strong class="text-on-surface dark:text-on-surface-dark">{{ $rental->end_date->format('d M Y') }}</strong></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">schedule</span>
                                <span>Durasi: <strong class="text-primary dark:text-inverse-primary">{{ $rental->total_days }} Hari</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Price & Action Buttons -->
                <div class="w-full xl:w-auto flex flex-row xl:flex-col items-center xl:items-end justify-between gap-4 border-t xl:border-t-0 xl:border-l border-outline-variant/50 dark:border-outline-dark/50 pt-4 xl:pt-0 xl:pl-6 shrink-0">
                    <div class="text-left lg:text-right">
                        <span class="text-xs text-text-muted dark:text-text-muted-dark block">Total Biaya Sewa</span>
                        <span class="text-2xl font-extrabold text-on-surface dark:text-on-surface-dark">
                            Rp {{ number_format((float)$rental->total_price, 0, ',', '.') }}
                        </span>
                        <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium block">
                            Rp {{ number_format((float)$rental->daily_rate, 0, ',', '.') }} / hari
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5">
                        <!-- Invoice Receipt Trigger -->
                        <button type="button" onclick='openInvoiceModal(@json($rental))' class="px-3.5 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 transition-colors cursor-pointer flex items-center gap-1.5" title="Lihat Bukti Sewa">
                            <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                            <span>Kuitansi</span>
                        </button>

                        <!-- Cancel Button (if cancellable) -->
                        @if($rental->isCancellable())
                            <form action="{{ route('rentals.cancel', $rental) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan sewa mobil ini? Unit akan kembali tersedia untuk umum.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3.5 py-2 rounded-lg border border-red-200 dark:border-red-800 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950 transition-colors cursor-pointer flex items-center gap-1" title="Batalkan Sewa">
                                    <span class="material-symbols-outlined text-[16px]">cancel</span>
                                    <span>Batalkan</span>
                                </button>
                            </form>
                        @endif

                        <!-- Return Car CTA -->
                        <a href="{{ route('returns.index', ['plate' => $rental->fleet->plate_number]) }}" class="py-2 px-4 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold shadow-sm transition-all flex items-center gap-1.5 cursor-pointer">
                            <span class="material-symbols-outlined text-[16px]">assignment_return</span>
                            <span>Kembalikan Unit</span>
                        </a>
                    </div>
                </div>

            </div>
        @empty
            <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-12 text-center space-y-4 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-primary/10 text-primary dark:text-inverse-primary mx-auto flex items-center justify-center">
                    <span class="material-symbols-outlined text-[32px]">no_crash</span>
                </div>
                <div class="space-y-1 max-w-md mx-auto">
                    <h3 class="text-lg font-bold text-on-surface dark:text-on-surface-dark">
                        Belum Ada Sewa Mobil Aktif
                    </h3>
                    <p class="text-xs text-text-muted dark:text-text-muted-dark">
                        Anda sedang tidak memiliki unit mobil yang disewa saat ini. Jelajahi katalog kami untuk memesan armada favorit Anda.
                    </p>
                </div>
                <a href="{{ route('fleet.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold shadow-md shadow-primary/20 transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">directions_car</span>
                    <span>Cari Armada Mobil</span>
                </a>
            </div>
        @endforelse
    </div>

    <!-- History Rentals Panel -->
    <div id="historyRentalsPanel" class="hidden space-y-4">
        <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden p-5 sm:p-6 space-y-4">
            
            <div class="overflow-x-auto border border-outline-variant/60 dark:border-outline-dark/60 rounded-xl">
                <table class="w-full text-left text-xs text-on-surface dark:text-on-surface-dark divide-y divide-outline-variant/60 dark:divide-outline-dark/60">
                    <thead class="bg-surface-container dark:bg-surface-container-dark font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        <tr>
                            <th class="py-3.5 px-4">Kendaraan & Kode Booking</th>
                            <th class="py-3.5 px-4">Nomor Plat</th>
                            <th class="py-3.5 px-4">Periode Sewa</th>
                            <th class="py-3.5 px-4">Tanggal Pengembalian</th>
                            <th class="py-3.5 px-4">Durasi</th>
                            <th class="py-3.5 px-4">Total Biaya</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Kuitansi / Faktur</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/40 dark:divide-outline-dark/40 bg-white dark:bg-surface-dark">
                        @forelse($historyRentals as $history)
                            <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                                <td class="py-3 px-4">
                                    <div class="space-y-0.5">
                                        <span class="font-bold text-on-surface dark:text-on-surface-dark block">
                                            {{ $history->fleet->brand }} {{ $history->fleet->model }}
                                        </span>
                                        <span class="font-mono text-[11px] text-text-muted dark:text-text-muted-dark block">
                                            {{ $history->rental_code }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 font-mono font-semibold text-primary dark:text-inverse-primary">
                                    {{ $history->fleet->plate_number }}
                                </td>
                                <td class="py-3 px-4 text-text-muted dark:text-text-muted-dark">
                                    {{ $history->start_date->format('d/m/Y') }} - {{ $history->end_date->format('d/m/Y') }}
                                </td>
                                <td class="py-3 px-4 text-text-muted dark:text-text-muted-dark">
                                    {{ $history->return_date ? $history->return_date->format('d/m/Y') : '-' }}
                                </td>
                                <td class="py-3 px-4">
                                    {{ $history->total_days }} Hari
                                </td>
                                <td class="py-3 px-4 font-bold text-on-surface dark:text-on-surface-dark">
                                    @php
                                        $finalTotal = (float)$history->total_price + (float)($history->penalty_price ?? 0);
                                    @endphp
                                    Rp {{ number_format($finalTotal, 0, ',', '.') }}
                                    @if($history->penalty_price > 0)
                                        <span class="block text-[10px] text-red-600 dark:text-red-400 font-semibold mt-0.5">
                                            + Denda Rp {{ number_format((float)$history->penalty_price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($history->status === 'completed')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                                            <span class="material-symbols-outlined text-[12px]">check_circle</span>
                                            Selesai Dikembalikan
                                        </span>
                                    @elseif($history->status === 'cancelled')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700">
                                            <span class="material-symbols-outlined text-[12px]">cancel</span>
                                            Dibatalkan
                                        </span>
                                    @else
                                        <span class="text-xs">{{ ucfirst($history->status) }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <button type="button" onclick='openInvoiceModal(@json($history))' class="p-1.5 rounded-lg text-primary dark:text-inverse-primary hover:bg-surface-container dark:hover:bg-slate-800 transition-colors cursor-pointer" title="Lihat Kuitansi">
                                        <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-xs text-text-muted dark:text-text-muted-dark">
                                    Belum ada riwayat transaksi sewa yang telah selesai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<!-- Digital Invoice Receipt Modal Dialog -->
<div id="rentalInvoiceModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6 transition-all duration-200" onclick="if(event.target === this) closeInvoiceModal()">
    <div class="bg-white dark:bg-surface-dark border border-outline-variant/70 dark:border-outline-dark/70 rounded-2xl w-full max-w-2xl max-h-[90vh] shadow-2xl overflow-hidden flex flex-col animate-in fade-in zoom-in-95 duration-150">
        
        <!-- Modal Top Bar -->
        <div class="px-6 py-3 border-b border-outline-variant/60 dark:border-outline-dark/60 flex items-center justify-between bg-surface-container dark:bg-[#0e1b2e] shrink-0 print:hidden">
            <span class="text-xs font-bold text-primary dark:text-inverse-primary uppercase tracking-wider flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">verified</span>
                <span>Faktur & Kuitansi Resmi</span>
            </span>
            <div class="flex items-center gap-2">
                <button type="button" onclick="window.print()" class="px-3 py-1.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold transition-colors flex items-center gap-1 cursor-pointer">
                    <span class="material-symbols-outlined text-[16px]">print</span>
                    <span>Cetak</span>
                </button>
                <button type="button" onclick="closeInvoiceModal()" class="w-8 h-8 rounded-lg text-text-muted hover:text-on-surface dark:hover:text-on-surface-dark hover:bg-surface-container-high dark:hover:bg-slate-800 transition-colors flex items-center justify-center cursor-pointer">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
        </div>

        <!-- Printable Receipt Body -->
        <div class="overflow-y-auto p-6 sm:p-8 space-y-6 flex-1 text-xs text-on-surface dark:text-on-surface-dark">
            
            <!-- Company Letterhead -->
            <div class="flex items-start justify-between border-b border-outline-variant/60 dark:border-outline-dark/60 pb-5">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[24px]">directions_car</span>
                        <strong class="font-extrabold text-base tracking-tight text-primary">INDRASARI RENTAL CAR</strong>
                    </div>
                    <p class="text-[11px] text-text-muted dark:text-text-muted-dark">
                        RSUD Indrasari, Pematang Reba, Rengat Barat, Kab. Indragiri Hulu, Riau<br>
                        WhatsApp: +62 812-9988-7766 • Email: operasional@rsudindrasari.com
                    </p>
                </div>
                <div class="text-right space-y-1">
                    <span class="px-2.5 py-1 rounded text-[10px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 block" id="invoiceStatusBadge">
                        LUNAS (PAID)
                    </span>
                    <span id="invoiceRentalCode" class="font-mono text-xs font-bold text-on-surface dark:text-on-surface-dark block">IND-BK-XXXX</span>
                </div>
            </div>

            <!-- Renter & Vehicle Info Bento -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/40 dark:border-outline-dark/40 space-y-1">
                    <span class="text-text-muted dark:text-text-muted-dark font-semibold text-[10px] uppercase tracking-wider block">Identitas Penyewa</span>
                    <strong id="invoiceRenterName" class="text-sm font-bold block">-</strong>
                    <p id="invoiceRenterContact" class="text-text-muted dark:text-text-muted-dark text-[11px]">-</p>
                    <p id="invoiceRenterSim" class="text-text-muted dark:text-text-muted-dark text-[11px] font-mono">-</p>
                </div>

                <div class="p-4 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/40 dark:border-outline-dark/40 space-y-1">
                    <span class="text-text-muted dark:text-text-muted-dark font-semibold text-[10px] uppercase tracking-wider block">Unit Kendaraan</span>
                    <strong id="invoiceCarName" class="text-sm font-bold block">-</strong>
                    <p id="invoiceCarPlate" class="font-mono font-bold text-primary dark:text-inverse-primary text-[11px]">-</p>
                    <p id="invoiceCarSpecs" class="text-text-muted dark:text-text-muted-dark text-[11px]">-</p>
                </div>
            </div>

            <!-- Schedule Breakdown -->
            <div class="p-4 rounded-xl bg-surface-container/40 dark:bg-surface-container-dark/40 border border-outline-variant/40 dark:border-outline-dark/40 space-y-2">
                <span class="text-text-muted dark:text-text-muted-dark font-semibold text-[10px] uppercase tracking-wider block">Jadwal Penggunaan Unit</span>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    <div>
                        <span class="text-text-muted dark:text-text-muted-dark text-[10px] block">Mulai Sewa:</span>
                        <strong id="invoiceStartDate" class="font-medium text-on-surface dark:text-on-surface-dark">-</strong>
                    </div>
                    <div>
                        <span class="text-text-muted dark:text-text-muted-dark text-[10px] block">Selesai Sewa:</span>
                        <strong id="invoiceEndDate" class="font-medium text-on-surface dark:text-on-surface-dark">-</strong>
                    </div>
                    <div>
                        <span class="text-text-muted dark:text-text-muted-dark text-[10px] block">Durasi Hari Inklusif:</span>
                        <strong id="invoiceTotalDays" class="text-primary dark:text-inverse-primary font-bold">-</strong>
                    </div>
                </div>
            </div>

            <!-- Pricing Breakdown Table -->
            <div class="border border-outline-variant/60 dark:border-outline-dark/60 rounded-xl overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-surface-container dark:bg-surface-container-dark font-semibold text-on-surface-variant dark:text-on-surface-variant-dark text-[11px]">
                        <tr>
                            <th class="py-2.5 px-4">Deskripsi Pembayaran</th>
                            <th class="py-2.5 px-4 text-center">Durasi / Satuan</th>
                            <th class="py-2.5 px-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/40 dark:divide-outline-dark/40 text-xs">
                        <tr>
                            <td class="py-2.5 px-4">
                                <span class="font-semibold block">Sewa Kendaraan Lepas Kunci</span>
                                <span class="text-[10px] text-text-muted dark:text-text-muted-dark">Tarif sewa resmi per 24 jam</span>
                            </td>
                            <td class="py-2.5 px-4 text-center font-mono" id="invoiceTableRate">
                                -
                            </td>
                            <td class="py-2.5 px-4 text-right font-mono font-semibold" id="invoiceTableSubtotal">
                                -
                            </td>
                        </tr>
                        <tr id="invoicePenaltyRow" class="hidden bg-rose-50/70 dark:bg-rose-950/30 text-rose-700 dark:text-rose-300">
                            <td class="py-2.5 px-4">
                                <span class="font-semibold block flex items-center gap-1.5 text-rose-600 dark:text-rose-400">
                                    <span class="material-symbols-outlined text-[15px]">warning</span>
                                    <span>Denda Keterlambatan Pengembalian</span>
                                </span>
                                <span class="text-[10px] text-text-muted dark:text-text-muted-dark" id="invoicePenaltyDesc">
                                    Keterlambatan pengembalian unit
                                </span>
                            </td>
                            <td class="py-2.5 px-4 text-center font-mono font-semibold text-rose-600 dark:text-rose-400" id="invoicePenaltyUnit">
                                -
                            </td>
                            <td class="py-2.5 px-4 text-right font-mono font-bold text-rose-600 dark:text-rose-400" id="invoicePenaltyTotal">
                                Rp 0
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">
                                <span class="font-semibold block text-emerald-600 dark:text-emerald-400">Proteksi Asuransi All-Risk</span>
                            </td>
                            <td class="py-2 px-4 text-center">Standar</td>
                            <td class="py-2 px-4 text-right font-semibold text-emerald-600 dark:text-emerald-400">Termasuk (Rp 0)</td>
                        </tr>
                    </tbody>
                    <tfoot class="border-t border-outline-variant/60 dark:border-outline-dark/60 bg-surface-container/60 dark:bg-surface-container-dark/60 font-bold">
                        <tr>
                            <td colspan="2" class="py-3 px-4 text-right text-xs">Total Pembayaran:</td>
                            <td class="py-3 px-4 text-right text-base text-primary dark:text-inverse-primary font-extrabold font-mono" id="invoiceTableGrandTotal">
                                -
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Customer Booking Purpose / Note -->
            <div id="invoiceCustomerNotesContainer" class="hidden p-3.5 rounded-xl bg-surface-container/40 dark:bg-surface-container-dark/40 border border-outline-variant/40 dark:border-outline-dark/40 space-y-1 text-xs">
                <span class="text-text-muted dark:text-text-muted-dark font-semibold text-[10px] uppercase tracking-wider flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px] text-primary dark:text-inverse-primary">description</span>
                    <span>Keperluan Sewa / Catatan Pelanggan:</span>
                </span>
                <p id="invoiceCustomerNotesText" class="text-on-surface dark:text-on-surface-dark font-medium whitespace-pre-line leading-relaxed">
                    -
                </p>
            </div>

            <!-- Admin Handover & Inspection Notes (if present) -->
            <div id="invoiceAdminNotesContainer" class="hidden p-3.5 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/50 dark:border-outline-dark/50 space-y-1 text-xs">
                <span class="text-text-muted dark:text-text-muted-dark font-semibold text-[10px] uppercase tracking-wider flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px] text-emerald-600 dark:text-emerald-400">verified</span>
                    <span>Berita Acara Pemeriksaan Fisik & Serah Terima:</span>
                </span>
                <p id="invoiceAdminNotesText" class="text-on-surface dark:text-on-surface-dark font-medium whitespace-pre-line leading-relaxed">
                    -
                </p>
            </div>

            <p class="text-center text-[10px] text-text-muted dark:text-text-muted-dark pt-2">
                Terima kasih telah mempercayakan perjalanan Anda kepada Indrasari Rental Car.<br>
                Kuitansi ini adalah bukti transaksi yang sah dan diterbitkan secara digital oleh sistem.
            </p>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchRentalTab(tab) {
        const activeBtn = document.getElementById('tabActiveBtn');
        const historyBtn = document.getElementById('tabHistoryBtn');
        const activePanel = document.getElementById('activeRentalsPanel');
        const historyPanel = document.getElementById('historyRentalsPanel');

        if (tab === 'history') {
            historyBtn.className = "pb-3 px-4 text-xs sm:text-sm font-bold border-b-2 border-primary text-primary dark:text-inverse-primary cursor-pointer transition-colors flex items-center gap-2";
            activeBtn.className = "pb-3 px-4 text-xs sm:text-sm font-semibold border-b-2 border-transparent text-text-muted dark:text-text-muted-dark hover:text-on-surface dark:hover:text-on-surface-dark cursor-pointer transition-colors flex items-center gap-2";
            historyPanel.classList.remove('hidden');
            activePanel.classList.add('hidden');
        } else {
            activeBtn.className = "pb-3 px-4 text-xs sm:text-sm font-bold border-b-2 border-primary text-primary dark:text-inverse-primary cursor-pointer transition-colors flex items-center gap-2";
            historyBtn.className = "pb-3 px-4 text-xs sm:text-sm font-semibold border-b-2 border-transparent text-text-muted dark:text-text-muted-dark hover:text-on-surface dark:hover:text-on-surface-dark cursor-pointer transition-colors flex items-center gap-2";
            activePanel.classList.remove('hidden');
            historyPanel.classList.add('hidden');
        }
    }

    function openInvoiceModal(rental) {
        const modal = document.getElementById('rentalInvoiceModal');
        if (!modal) return;

        document.getElementById('invoiceRentalCode').innerText = rental.rental_code || 'IND-BK-XXXX';
        
        // Status Badge
        const statusBadge = document.getElementById('invoiceStatusBadge');
        if (rental.status === 'completed') {
            statusBadge.className = 'px-2.5 py-1 rounded text-[10px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 block';
            statusBadge.innerText = 'SELESAI (COMPLETED)';
        } else if (rental.status === 'active') {
            statusBadge.className = 'px-2.5 py-1 rounded text-[10px] font-extrabold uppercase tracking-wider bg-blue-50 text-blue-800 dark:bg-blue-950 dark:text-blue-300 border border-blue-200 dark:border-blue-800 block';
            statusBadge.innerText = 'SEWA AKTIF';
        } else if (rental.status === 'cancelled') {
            statusBadge.className = 'px-2.5 py-1 rounded text-[10px] font-extrabold uppercase tracking-wider bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300 border border-slate-200 dark:border-slate-700 block';
            statusBadge.innerText = 'DIBATALKAN';
        } else {
            statusBadge.className = 'px-2.5 py-1 rounded text-[10px] font-extrabold uppercase tracking-wider bg-amber-50 text-amber-800 dark:bg-amber-950 dark:text-amber-300 border border-amber-200 dark:border-amber-800 block';
            statusBadge.innerText = 'MENUNGGU VERIFIKASI';
        }

        // Renter Info
        const user = rental.user || {};
        document.getElementById('invoiceRenterName').innerText = user.name || '{{ auth()->user()->name ?? "Pelanggan" }}';
        document.getElementById('invoiceRenterContact').innerText = (user.email || '{{ auth()->user()->email }}') + ' • ' + (user.phone_number || '{{ auth()->user()->phone_number }}');
        document.getElementById('invoiceRenterSim').innerText = 'SIM A: ' + (user.driving_license_number || '{{ auth()->user()->driving_license_number ?? "-" }}');

        // Car Info
        const fleet = rental.fleet || {};
        document.getElementById('invoiceCarName').innerText = (fleet.brand || '') + ' ' + (fleet.model || 'Unit Mobil');
        document.getElementById('invoiceCarPlate').innerText = fleet.plate_number || '-';
        document.getElementById('invoiceCarSpecs').innerText = (fleet.type || '') + ' • ' + (fleet.transmission || '') + ' • Warna ' + (fleet.color || '-');

        // Schedule
        if (rental.start_date) {
            const sDate = new Date(rental.start_date);
            document.getElementById('invoiceStartDate').innerText = sDate.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' });
        }
        if (rental.end_date) {
            const eDate = new Date(rental.end_date);
            document.getElementById('invoiceEndDate').innerText = eDate.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' });
        }
        document.getElementById('invoiceTotalDays').innerText = (rental.total_days || 1) + ' Hari Kalender';

        // Table & Pricing Breakdown
        const dailyRate = parseFloat(rental.daily_rate || 0);
        const totalPrice = parseFloat(rental.total_price || 0);
        const penaltyPrice = parseFloat(rental.penalty_price || 0);
        const grandTotal = totalPrice + penaltyPrice;

        document.getElementById('invoiceTableRate').innerText = (rental.total_days || 1) + ' Hari x Rp ' + dailyRate.toLocaleString('id-ID');
        document.getElementById('invoiceTableSubtotal').innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');

        const penaltyRow = document.getElementById('invoicePenaltyRow');
        const penaltyDesc = document.getElementById('invoicePenaltyDesc');
        const penaltyUnit = document.getElementById('invoicePenaltyUnit');
        const penaltyTotal = document.getElementById('invoicePenaltyTotal');

        if (penaltyPrice > 0) {
            const daysOverdue = dailyRate > 0 ? Math.round(penaltyPrice / dailyRate) : 1;
            penaltyDesc.innerText = `Keterlambatan ${daysOverdue} hari melampaui jadwal`;
            penaltyUnit.innerText = `${daysOverdue} Hari x Rp ${dailyRate.toLocaleString('id-ID')}`;
            penaltyTotal.innerText = '+ Rp ' + penaltyPrice.toLocaleString('id-ID');
            penaltyRow.classList.remove('hidden');
        } else {
            penaltyRow.classList.add('hidden');
        }

        document.getElementById('invoiceTableGrandTotal').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');

        // Customer Booking Notes
        const custNotesContainer = document.getElementById('invoiceCustomerNotesContainer');
        const custNotesText = document.getElementById('invoiceCustomerNotesText');
        if (rental.notes && rental.notes.trim() !== '') {
            custNotesText.innerText = rental.notes;
            custNotesContainer.classList.remove('hidden');
        } else {
            custNotesContainer.classList.add('hidden');
        }

        // Admin Handover & Physical Inspection Notes
        const adminNotesContainer = document.getElementById('invoiceAdminNotesContainer');
        const adminNotesText = document.getElementById('invoiceAdminNotesText');
        if (rental.admin_notes && rental.admin_notes.trim() !== '') {
            adminNotesText.innerText = rental.admin_notes;
            adminNotesContainer.classList.remove('hidden');
        } else {
            adminNotesContainer.classList.add('hidden');
        }

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeInvoiceModal() {
        const modal = document.getElementById('rentalInvoiceModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Keyboard ESC to close modal
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeInvoiceModal();
        }
    });
</script>
@endpush
