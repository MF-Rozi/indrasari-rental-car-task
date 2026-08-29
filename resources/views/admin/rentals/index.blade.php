@extends('layouts.admin')

@section('title', 'Kelola Transaksi Sewa dan Pengembalian - Admin Indrasari')
@section('header_title', 'Kelola Transaksi Sewa dan Pengembalian')

@section('content')
<div class="space-y-6">

    <!-- KPI Metric Bento Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Bookings -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Total Peminjaman</span>
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">
                    {{ number_format($stats['total_rentals']) }} Transaksi
                </span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">receipt_long</span>
            </div>
        </div>

        <!-- Active Rentals -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Sedang Digunakan</span>
                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400 block">
                    {{ number_format($stats['active_rentals']) }} Unit Aktif
                </span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">directions_car</span>
            </div>
        </div>

        <!-- Pending Return Verification -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Menunggu Verifikasi</span>
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-bold {{ $stats['pending_return_rentals'] > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-on-surface dark:text-on-surface-dark' }} block">
                        {{ number_format($stats['pending_return_rentals']) }} Unit
                    </span>
                    @if($stats['pending_return_rentals'] > 0)
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 animate-pulse">
                            Perlu Aksi
                        </span>
                    @endif
                </div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">assignment_late</span>
            </div>
        </div>

        <!-- Revenue Collected -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Total Pendapatan Selesai</span>
                <span class="text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 font-mono block">
                    Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                </span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">payments</span>
            </div>
        </div>

    </div>

    <!-- Data Table Container -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden p-5 sm:p-6 space-y-4">
        
        <!-- Toolbar & Filter Form -->
        <form method="GET" action="{{ route('admin.rentals.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="relative w-full sm:w-80">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">search</span>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $filters['search'] ?? '' }}" 
                    placeholder="Cari kode booking, nama penyewa, plat..." 
                    class="w-full pl-10 pr-4 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" 
                />
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select 
                    name="status" 
                    onchange="this.form.submit()" 
                    class="px-3 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs font-semibold text-on-surface dark:text-on-surface-dark outline-none cursor-pointer"
                >
                    <option value="all" {{ ($filters['status'] ?? 'all') === 'all' ? 'selected' : '' }}>Semua Status Peminjaman</option>
                    <option value="pending_return" {{ ($filters['status'] ?? '') === 'pending_return' ? 'selected' : '' }}>Menunggu Verifikasi Pengembalian</option>
                    <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Sedang Disewa (Aktif)</option>
                    <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Pengembalian Selesai (Completed)</option>
                    <option value="cancelled" {{ ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                </select>

                @if(!empty($filters['search']) || ($filters['status'] ?? 'all') !== 'all')
                    <a href="{{ route('admin.rentals.index') }}" class="px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-text-muted hover:text-on-surface dark:hover:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 transition-colors flex items-center gap-1" title="Reset Filter">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                        <span class="hidden sm:inline">Reset</span>
                    </a>
                @endif
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto border border-outline-variant/60 dark:border-outline-dark/60 rounded-xl">
            <table class="w-full text-left text-xs text-on-surface dark:text-on-surface-dark divide-y divide-outline-variant/60 dark:divide-outline-dark/60">
                <thead class="bg-surface-container dark:bg-surface-container-dark font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                    <tr>
                        <th class="py-3.5 px-4">Kode & Penyewa</th>
                        <th class="py-3.5 px-4">Unit Mobil & Plat</th>
                        <th class="py-3.5 px-4">Periode & Durasi</th>
                        <th class="py-3.5 px-4">Total Biaya</th>
                        <th class="py-3.5 px-4">Status Sewa</th>
                        <th class="py-3.5 px-4 text-right">Aksi & Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/40 dark:divide-outline-dark/40 bg-white dark:bg-surface-dark">
                    @forelse($rentals as $rental)
                        @php
                            $settlement = $rental->calculateSettlementSummary();
                            $isPendingReturn = $rental->status === 'pending_return';
                            $isActive = $rental->status === 'active';
                            $isCompleted = $rental->status === 'completed';
                            $isCancelled = $rental->status === 'cancelled';
                        @endphp
                        <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="space-y-0.5">
                                    <span class="font-mono text-[11px] font-bold text-primary dark:text-inverse-primary block">
                                        {{ $rental->rental_code }}
                                    </span>
                                    <span class="font-bold text-on-surface dark:text-on-surface-dark block">
                                        {{ $rental->user->name }}
                                    </span>
                                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">
                                        {{ $rental->user->phone_number ?? '-' }} • SIM: {{ $rental->user->driving_license_number ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="space-y-0.5">
                                    <span class="font-bold text-on-surface dark:text-on-surface-dark block">
                                        {{ $rental->fleet->brand }} {{ $rental->fleet->model }}
                                    </span>
                                    <span class="font-mono text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark block">
                                        {{ $rental->fleet->plate_number }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="space-y-0.5">
                                    <span class="text-on-surface dark:text-on-surface-dark font-medium block">
                                        {{ $rental->start_date->format('d M Y') }} - {{ $rental->end_date->format('d M Y') }}
                                    </span>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-text-muted dark:text-text-muted-dark text-[11px]">
                                            Durasi: {{ $rental->total_days }} Hari
                                        </span>
                                        @if(($isActive || $isPendingReturn) && $rental->isOverdue())
                                            <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-bold bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300">
                                                Telat {{ $rental->daysOverdue() }} Hari
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-sm text-on-surface dark:text-on-surface-dark font-mono block">
                                    Rp {{ number_format((float)$rental->total_price + (float)$rental->penalty_price, 0, ',', '.') }}
                                </span>
                                @if((float)$rental->penalty_price > 0)
                                    <span class="text-[10px] text-red-600 dark:text-red-400 font-medium block">
                                        + Denda Rp {{ number_format((float)$rental->penalty_price, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">
                                        Rp {{ number_format((float)$rental->daily_rate, 0, ',', '.') }} / hari
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($isPendingReturn)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/70 dark:text-amber-300 dark:border-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>Menunggu Verifikasi</span>
                                    </span>
                                @elseif($isActive)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/70 dark:text-blue-300 dark:border-blue-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                        <span>Sedang Disewa</span>
                                    </span>
                                @elseif($isCompleted)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                                        <span class="material-symbols-outlined text-[14px]">check</span>
                                        <span>Selesai</span>
                                    </span>
                                @elseif($isCancelled)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700">
                                        <span class="material-symbols-outlined text-[14px]">close</span>
                                        <span>Dibatalkan</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                @if($isPendingReturn || $isActive)
                                    <button 
                                        type="button" 
                                        onclick="openAdminReturnModal({{ $rental->id }})" 
                                        class="px-3 py-1.5 rounded-lg {{ $isPendingReturn ? 'bg-amber-600 hover:bg-amber-700 shadow-md shadow-amber-600/20' : 'bg-emerald-600 hover:bg-emerald-700' }} text-white font-semibold transition-all cursor-pointer inline-flex items-center gap-1 hover:-translate-y-0.5"
                                    >
                                        <span class="material-symbols-outlined text-[16px]">assignment_turned_in</span>
                                        <span>Verifikasi Kembali</span>
                                    </button>
                                @elseif($isCompleted)
                                    <button 
                                        type="button" 
                                        onclick="openAdminInvoiceModal({{ $rental->id }})" 
                                        class="p-1.5 rounded-lg text-primary dark:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors cursor-pointer" 
                                        title="Lihat Kuitansi Resmi"
                                    >
                                        <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-text-muted dark:text-text-muted-dark space-y-2">
                                <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 block">inventory_2</span>
                                <span class="text-xs font-semibold block">Tidak ada transaksi sewa yang cocok dengan kriteria pencarian.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($rentals->hasPages())
            <div class="pt-3">
                {{ $rentals->links() }}
            </div>
        @endif

    </div>

</div>

<!-- Admin Return Verification Modal Dialog -->
<div id="returnVerifyModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4 transition-all duration-200" onclick="if(event.target === this) closeAdminReturnModal()">
    <div class="bg-white dark:bg-surface-dark border border-outline-variant/70 dark:border-outline-dark/70 rounded-2xl max-w-xl w-full p-6 sm:p-8 shadow-2xl space-y-6 animate-in fade-in zoom-in-95 duration-150">
        
        <!-- Header -->
        <div class="flex items-start justify-between border-b border-outline-variant/60 dark:border-outline-dark/60 pb-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-primary dark:text-inverse-primary">
                    <span class="material-symbols-outlined text-[24px]">assignment_turned_in</span>
                    <h3 class="text-lg font-bold text-on-surface dark:text-on-surface-dark">
                        Verifikasi Pengembalian Fisik Unit
                    </h3>
                </div>
                <p class="text-xs text-text-muted dark:text-text-muted-dark">
                    Periksa kondisi kendaraan, kunci, STNK, dan lakukan konfirmasi pelunasan sewa.
                </p>
            </div>
            <button type="button" onclick="closeAdminReturnModal()" class="p-1 rounded-lg text-text-muted hover:text-on-surface dark:hover:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 transition-colors cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Vehicle & Customer Bento Summary -->
        <div class="p-4 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/40 dark:border-outline-dark/40 space-y-3 text-xs">
            <div class="flex items-center justify-between">
                <span class="font-mono text-primary dark:text-inverse-primary font-bold" id="adminModalRentalCode">-</span>
                <span class="font-mono text-xs font-bold px-2.5 py-0.5 rounded-lg bg-surface-container dark:bg-surface-container-dark text-on-surface dark:text-on-surface-dark border border-outline-variant/60 dark:border-outline-dark/60" id="adminModalPlate">-</span>
            </div>

            <div class="grid grid-cols-2 gap-2 text-xs">
                <div>
                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Kendaraan:</span>
                    <strong class="text-on-surface dark:text-on-surface-dark" id="adminModalCarName">-</strong>
                </div>
                <div>
                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Penyewa:</span>
                    <strong class="text-on-surface dark:text-on-surface-dark" id="adminModalUserName">-</strong>
                </div>
                <div>
                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Periode Sewa:</span>
                    <span class="text-on-surface dark:text-on-surface-dark font-medium" id="adminModalPeriod">-</span>
                </div>
                <div>
                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Status Tenggat:</span>
                    <strong id="adminModalOverdueText">-</strong>
                </div>
            </div>
        </div>

        <!-- Return Verification Form -->
        <form id="adminConfirmReturnForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PATCH')

            <!-- Penalty Price Override / Adjustment -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label for="adminPenaltyPriceInput" class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Denda Keterlambatan / Biaya Tambahan (IDR):
                    </label>
                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark" id="adminAutoPenaltyHint">
                        Kalkulasi Otomatis: Rp 0
                    </span>
                </div>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-text-muted">Rp</span>
                    <input 
                        type="number" 
                        name="penalty_price" 
                        id="adminPenaltyPriceInput" 
                        min="0" 
                        step="1000" 
                        class="w-full pl-10 pr-4 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-xl text-xs font-mono font-bold text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" 
                    />
                </div>
            </div>

            <!-- Notes -->
            <div class="space-y-1.5">
                <label for="adminNotesInput" class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                    Catatan Pemeriksaan Fisik & Serah Terima Unit:
                </label>
                <textarea 
                    name="admin_notes" 
                    id="adminNotesInput" 
                    rows="2" 
                    placeholder="Contoh: Unit telah diperiksa, bodi mulus tanpa lecet, tangki bensin terisi penuh, kunci & STNK asli lengkap diterima." 
                    class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-none"
                ></textarea>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 border-t border-outline-variant/60 dark:border-outline-dark/60 pt-4">
                <button type="button" onclick="closeAdminReturnModal()" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition-all cursor-pointer flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                    <span>Konfirmasi Pengembalian Selesai</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Admin Digital Invoice Receipt Modal -->
<div id="adminInvoiceModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4 transition-all duration-200" onclick="if(event.target === this) closeAdminInvoiceModal()">
    <div class="bg-white dark:bg-surface-dark border border-outline-variant/70 dark:border-outline-dark/70 rounded-2xl max-w-lg w-full p-6 sm:p-8 shadow-2xl space-y-6 animate-in fade-in zoom-in-95 duration-150">
        
        <!-- Header with RSUD Letterhead -->
        <div class="flex items-start justify-between border-b border-outline-variant/60 dark:border-outline-dark/60 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary dark:text-inverse-primary flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-2xl">local_hospital</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-on-surface dark:text-on-surface-dark">
                        RSUD Indrasari Rengat
                    </h3>
                    <p class="text-[11px] text-text-muted dark:text-text-muted-dark">
                        Kuitansi Pelunasan Sewa Kendaraan Resmi
                    </p>
                </div>
            </div>
            <button type="button" onclick="closeAdminInvoiceModal()" class="p-1 rounded-lg text-text-muted hover:text-on-surface dark:hover:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 transition-colors cursor-pointer">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Receipt Line Items -->
        <div class="p-4 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/40 dark:border-outline-dark/40 space-y-2.5 text-xs text-text-muted dark:text-text-muted-dark">
            <div class="flex justify-between">
                <span>Kode Transaksi:</span>
                <strong class="font-mono text-primary dark:text-inverse-primary" id="invModalCode">-</strong>
            </div>
            <div class="flex justify-between">
                <span>Penyewa:</span>
                <strong class="text-on-surface dark:text-on-surface-dark" id="invModalUser">-</strong>
            </div>
            <div class="flex justify-between">
                <span>Kendaraan:</span>
                <strong class="text-on-surface dark:text-on-surface-dark" id="invModalCar">-</strong>
            </div>
            <div class="flex justify-between">
                <span>Nomor Plat Polisi:</span>
                <strong class="font-mono text-on-surface dark:text-on-surface-dark" id="invModalPlate">-</strong>
            </div>
            <div class="flex justify-between">
                <span>Durasi Sewa:</span>
                <span class="text-on-surface dark:text-on-surface-dark" id="invModalDuration">-</span>
            </div>
            <div class="flex justify-between border-t border-outline-variant/60 dark:border-outline-dark/60 pt-2 text-sm font-bold">
                <span class="text-on-surface dark:text-on-surface-dark">Total Pembayaran:</span>
                <span class="text-emerald-600 dark:text-emerald-400 font-mono font-extrabold" id="invModalTotal">-</span>
            </div>
            <div class="flex justify-between text-[11px] text-emerald-700 dark:text-emerald-400 font-semibold">
                <span>Status Pelunasan:</span>
                <span class="uppercase tracking-wider">LUNAS & SELESAI</span>
            </div>
        </div>

        <!-- Modal Actions -->
        <div class="flex items-center justify-end gap-3 border-t border-outline-variant/60 dark:border-outline-dark/60 pt-4">
            <button type="button" onclick="window.print()" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5 cursor-pointer">
                <span class="material-symbols-outlined text-[16px]">print</span>
                <span>Cetak Faktur</span>
            </button>
            <button type="button" onclick="closeAdminInvoiceModal()" class="px-6 py-2 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold shadow-sm transition-all cursor-pointer">
                Tutup
            </button>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const rentalsData = @json($rentals->items());

    function openAdminReturnModal(rentalId) {
        const rental = rentalsData.find(r => r.id === rentalId);
        if (!rental) return;

        document.getElementById('adminModalRentalCode').innerText = rental.rental_code;
        document.getElementById('adminModalPlate').innerText = rental.fleet ? rental.fleet.plate_number : '-';
        document.getElementById('adminModalCarName').innerText = rental.fleet ? (rental.fleet.brand + ' ' + rental.fleet.model) : '-';
        document.getElementById('adminModalUserName').innerText = rental.user ? rental.user.name : '-';
        
        const startFormatted = new Date(rental.start_date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        const endFormatted = new Date(rental.end_date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        document.getElementById('adminModalPeriod').innerText = `${startFormatted} - ${endFormatted} (${rental.total_days} Hari)`;

        // Calculate overdue status dynamically
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const endDate = new Date(rental.end_date);
        endDate.setHours(0, 0, 0, 0);

        const isOverdue = today > endDate;
        let daysOverdue = 0;
        let autoPenalty = 0;

        if (isOverdue) {
            const diffTime = Math.abs(today - endDate);
            daysOverdue = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            autoPenalty = daysOverdue * Number(rental.daily_rate);
        }

        const overdueEl = document.getElementById('adminModalOverdueText');
        if (isOverdue) {
            overdueEl.className = 'text-red-600 dark:text-red-400 font-bold';
            overdueEl.innerText = `Terlambat ${daysOverdue} Hari`;
        } else {
            overdueEl.className = 'text-emerald-600 dark:text-emerald-400 font-semibold';
            overdueEl.innerText = 'Tepat Waktu (Tanpa Keterlambatan)';
        }

        document.getElementById('adminPenaltyPriceInput').value = autoPenalty;
        document.getElementById('adminAutoPenaltyHint').innerText = 'Kalkulasi Otomatis: Rp ' + Number(autoPenalty).toLocaleString('id-ID');

        const form = document.getElementById('adminConfirmReturnForm');
        form.action = `/admin/rentals/${rental.id}/confirm-return`;

        const modal = document.getElementById('returnVerifyModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeAdminReturnModal() {
        const modal = document.getElementById('returnVerifyModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function openAdminInvoiceModal(rentalId) {
        const rental = rentalsData.find(r => r.id === rentalId);
        if (!rental) return;

        document.getElementById('invModalCode').innerText = rental.rental_code;
        document.getElementById('invModalUser').innerText = rental.user ? rental.user.name : '-';
        document.getElementById('invModalCar').innerText = rental.fleet ? (rental.fleet.brand + ' ' + rental.fleet.model) : '-';
        document.getElementById('invModalPlate').innerText = rental.fleet ? rental.fleet.plate_number : '-';
        
        const startFormatted = new Date(rental.start_date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        const endFormatted = new Date(rental.end_date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        document.getElementById('invModalDuration').innerText = `${startFormatted} - ${endFormatted} (${rental.total_days} Hari)`;

        const grandTotal = Number(rental.total_price) + Number(rental.penalty_price || 0);
        document.getElementById('invModalTotal').innerText = 'Rp ' + Number(grandTotal).toLocaleString('id-ID');

        const modal = document.getElementById('adminInvoiceModal');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeAdminInvoiceModal() {
        const modal = document.getElementById('adminInvoiceModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Keyboard ESC listener
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAdminReturnModal();
            closeAdminInvoiceModal();
        }
    });
</script>
@endpush
