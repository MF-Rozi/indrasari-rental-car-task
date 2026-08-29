@extends('layouts.app')

@section('title', 'Dashboard Pelanggan - Indrasari Rental Car')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-8">

    <!-- Customer Welcome Hero Banner -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-primary text-white text-2xl font-bold flex items-center justify-center shadow-md shadow-primary/20 shrink-0">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div class="space-y-1.5">
                <div class="flex flex-wrap items-center gap-2.5">
                    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface dark:text-on-surface-dark">
                        Selamat Datang, {{ $user->name }}
                    </h1>
                    @if($user->isVerified())
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                            <span class="material-symbols-outlined text-[14px]">verified</span>
                            <span>Driver Terverifikasi</span>
                        </span>
                    @elseif($user->isPending())
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/70 dark:text-amber-300 dark:border-amber-800">
                            <span class="material-symbols-outlined text-[14px] animate-spin">progress_activity</span>
                            <span>Menunggu Verifikasi SIM A</span>
                        </span>
                    @elseif($user->isRejected())
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-800 border border-red-200 dark:bg-red-950/70 dark:text-red-300 dark:border-red-800">
                            <span class="material-symbols-outlined text-[14px]">cancel</span>
                            <span>Verifikasi SIM Ditolak</span>
                        </span>
                    @endif
                </div>
                <p class="text-xs text-text-muted dark:text-text-muted-dark">
                    Pantau unit sewaan aktif Anda, cek rekonsiliasi denda, dan nikmati kemudahan sewa armada RSUD Indrasari.
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            @if($activeRental)
                <a href="{{ route('returns.index', ['plate' => $activeRental->fleet->plate_number]) }}" class="px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 hover:text-primary dark:hover:text-inverse-primary transition-colors flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">assignment_return</span>
                    <span>Kembalikan Mobil</span>
                </a>
            @endif
            <a href="{{ route('fleet.index') }}" class="px-4 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Sewa Mobil Baru</span>
            </a>
        </div>
    </div>

    <!-- Active Booking Command Center Card OR Empty State -->
    @if($activeRental)
        <div class="bg-gradient-to-br from-primary/5 via-white to-surface-container/30 dark:from-[#0f233d] dark:via-surface-dark dark:to-surface-dark rounded-2xl border border-primary/20 dark:border-primary/30 p-6 sm:p-8 shadow-sm space-y-6">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-outline-variant/60 dark:border-outline-dark/60 pb-4">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full {{ $activeRental->isOverdue() ? 'bg-red-500 animate-ping' : 'bg-blue-500 animate-pulse' }}"></span>
                    <h2 class="text-base font-bold text-on-surface dark:text-on-surface-dark">
                        Sewa Aktif Saat Ini
                    </h2>
                    <span class="font-mono text-xs font-bold px-2.5 py-0.5 rounded bg-primary text-white">
                        {{ $activeRental->fleet->plate_number }}
                    </span>
                    @if($activeRental->isPendingReturn())
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">
                            Menunggu Verifikasi Pengembalian
                        </span>
                    @endif
                </div>
                <span class="text-xs text-text-muted dark:text-text-muted-dark">
                    Kode Booking: <strong class="text-primary dark:text-inverse-primary font-mono">{{ $activeRental->rental_code }}</strong>
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                
                <!-- Car Image & Specs -->
                <div class="lg:col-span-4 flex items-center gap-4">
                    <div class="w-28 sm:w-36 h-20 sm:h-24 rounded-xl overflow-hidden bg-surface-container dark:bg-surface-container-dark border border-slate-200 dark:border-slate-800 shrink-0">
                        <img 
                            src="{{ $activeRental->fleet->image_url }}" 
                            alt="{{ $activeRental->fleet->full_name }}" 
                            class="w-full h-full object-cover" 
                            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=400&q=80';" 
                        />
                    </div>
                    <div class="space-y-1 min-w-0">
                        <span class="text-[11px] font-bold text-text-muted dark:text-text-muted-dark uppercase tracking-wider block truncate">
                            {{ $activeRental->fleet->brand }} • {{ ucfirst($activeRental->fleet->transmission) }}
                        </span>
                        <h3 class="text-base sm:text-lg font-bold text-on-surface dark:text-on-surface-dark truncate">
                            {{ $activeRental->fleet->full_name }}
                        </h3>
                        <span class="text-xs text-primary dark:text-inverse-primary font-semibold block">
                            {{ $activeRental->formatted_daily_rate }} / hari
                        </span>
                    </div>
                </div>

                <!-- Rental Timeline Bar -->
                <div class="lg:col-span-5 space-y-3">
                    <div class="flex items-center justify-between text-xs font-semibold text-on-surface dark:text-on-surface-dark">
                        <div class="space-y-0.5">
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block font-normal">Mulai Sewa</span>
                            <span>{{ $activeRental->start_date->format('d M Y') }}</span>
                        </div>
                        <div class="text-center space-y-0.5">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300">
                                {{ $activeRental->total_days }} Hari Inklusif
                            </span>
                        </div>
                        <div class="text-right space-y-0.5">
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block font-normal">Selesai Sewa</span>
                            <span>{{ $activeRental->end_date->format('d M Y') }}</span>
                        </div>
                    </div>

                    @if($activeSettlement && $activeSettlement['is_overdue'])
                        <div class="p-2.5 rounded-xl bg-red-50 dark:bg-red-950/70 border border-red-200 dark:border-red-800 text-[11px] text-red-700 dark:text-red-300 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-red-600 dark:text-red-400 shrink-0">warning</span>
                            <span>Terlambat <strong>{{ $activeSettlement['days_overdue'] }} Hari</strong>. Denda: <strong>+Rp {{ number_format($activeSettlement['penalty_price'], 0, ',', '.') }}</strong></span>
                        </div>
                    @else
                        <div class="w-full h-2 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: 75%;"></div>
                        </div>
                        <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium block text-right">
                            Sewa Berjalan Sesuai Jadwal
                        </span>
                    @endif
                </div>

                <!-- Total Cost & Actions -->
                <div class="lg:col-span-3 flex flex-col items-start lg:items-end justify-between gap-3 border-t lg:border-t-0 border-outline-variant/50 dark:border-outline-dark/50 pt-4 lg:pt-0">
                    <div class="text-left lg:text-right">
                        <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Total Biaya Pelunasan</span>
                        <strong class="text-xl sm:text-2xl font-bold text-on-surface dark:text-on-surface-dark font-mono block">
                            Rp {{ number_format($activeSettlement ? $activeSettlement['grand_total'] : (float)$activeRental->total_price, 0, ',', '.') }}
                        </strong>
                    </div>

                    <a href="{{ route('returns.index', ['plate' => $activeRental->fleet->plate_number]) }}" class="w-full lg:w-auto py-2.5 px-5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition-all hover:-translate-y-0.5 text-center flex items-center justify-center gap-1.5 cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">assignment_return</span>
                        <span>Kembalikan Unit Ini</span>
                    </a>
                </div>

            </div>

        </div>
    @else
        <!-- Empty State Hero Card -->
        <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-8 sm:p-10 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary dark:text-inverse-primary flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[32px]">directions_car</span>
                </div>
                <div class="space-y-1">
                    <h3 class="text-base sm:text-lg font-bold text-on-surface dark:text-on-surface-dark">
                        Tidak Ada Sewa Mobil Aktif Saat Ini
                    </h3>
                    <p class="text-xs text-text-muted dark:text-text-muted-dark max-w-xl">
                        Anda sedang tidak memiliki armada mobil yang disewa. Temukan pilihan kendaraan premium kami untuk kebutuhan perjalanan dinas atau keluarga.
                    </p>
                </div>
            </div>
            <a href="{{ route('fleet.index') }}" class="px-6 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold shadow-md shadow-primary/20 transition-all hover:-translate-y-0.5 shrink-0 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">car_rental</span>
                <span>Pilih Armada Mobil</span>
            </a>
        </div>
    @endif

    <!-- Personal Stats & Account Overview Bento Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Bookings -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Total Peminjaman</span>
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">
                    {{ number_format($stats['total_bookings']) }} Transaksi
                </span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">receipt_long</span>
            </div>
        </div>

        <!-- Active Rentals Count -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Sedang Digunakan</span>
                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400 block">
                    {{ number_format($stats['active_count']) }} Unit Aktif
                </span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">directions_car</span>
            </div>
        </div>

        <!-- Completed Rentals -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Selesai & Lunas</span>
                <span class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 block">
                    {{ number_format($stats['completed_count']) }} Transaksi
                </span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">task_alt</span>
            </div>
        </div>

        <!-- Total Spent -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Total Pengeluaran</span>
                <span class="text-xl sm:text-2xl font-bold text-on-surface dark:text-on-surface-dark font-mono block">
                    Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}
                </span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">payments</span>
            </div>
        </div>

    </div>

    <!-- Bottom Section: Quick Links & Recent History -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Recent Activity History -->
        <div class="lg:col-span-2 bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-outline-variant/50 dark:border-outline-dark/50 pb-3">
                <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px] text-primary dark:text-inverse-primary">history</span>
                    <span>Riwayat Transaksi Terakhir</span>
                </h3>
                <a href="{{ route('rentals.index') }}" class="text-xs font-semibold text-primary dark:text-inverse-primary hover:underline flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>

            @if($recentRentals->isEmpty())
                <div class="py-8 text-center text-text-muted dark:text-text-muted-dark space-y-2">
                    <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600">receipt_long</span>
                    <p class="text-xs">Belum ada riwayat transaksi sewa mobil di akun Anda.</p>
                </div>
            @else
                <div class="divide-y divide-outline-variant/40 dark:divide-outline-dark/40">
                    @foreach($recentRentals as $rental)
                        <div class="py-3.5 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-surface-container dark:bg-surface-container-dark flex items-center justify-center text-primary dark:text-inverse-primary shrink-0">
                                    <span class="material-symbols-outlined text-[20px]">directions_car</span>
                                </div>
                                <div class="space-y-0.5 min-w-0">
                                    <h4 class="font-bold text-xs text-on-surface dark:text-on-surface-dark truncate">
                                        {{ $rental->fleet->brand }} {{ $rental->fleet->model }}
                                    </h4>
                                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">
                                        {{ $rental->start_date->format('d M') }} - {{ $rental->end_date->format('d M Y') }} • Plat <strong class="font-mono">{{ $rental->fleet->plate_number }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="text-right space-y-0.5 shrink-0">
                                <span class="font-bold text-xs text-on-surface dark:text-on-surface-dark font-mono block">
                                    Rp {{ number_format((float)$rental->total_price + (float)$rental->penalty_price, 0, ',', '.') }}
                                </span>
                                @if($rental->status === 'completed')
                                    <span class="inline-flex items-center px-2 py-0.2 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 uppercase">
                                        Selesai
                                    </span>
                                @elseif($rental->status === 'active')
                                    <span class="inline-flex items-center px-2 py-0.2 rounded text-[10px] font-bold bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300 uppercase">
                                        Aktif
                                    </span>
                                @elseif($rental->status === 'pending_return')
                                    <span class="inline-flex items-center px-2 py-0.2 rounded text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 uppercase">
                                        Pengembalian
                                    </span>
                                @elseif($rental->status === 'cancelled')
                                    <span class="inline-flex items-center px-2 py-0.2 rounded text-[10px] font-bold bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 uppercase">
                                        Batal
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Col: Account & Fast Links -->
        <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm space-y-4">
            <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark border-b border-outline-variant/50 dark:border-outline-dark/50 pb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px] text-primary dark:text-inverse-primary">badge</span>
                <span>Pusat Layanan Cepat</span>
            </h3>

            <div class="space-y-3">
                <a href="{{ route('profile.index') }}" class="p-3.5 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 hover:bg-surface-container dark:hover:bg-surface-container-dark border border-outline-variant/40 dark:border-outline-dark/40 flex items-center justify-between transition-colors group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-purple-50 dark:bg-purple-950 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">credit_card</span>
                        </div>
                        <div class="space-y-0.5">
                            <h4 class="font-bold text-xs text-on-surface dark:text-on-surface-dark group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors">
                                Dokumen Legalitas SIM A
                            </h4>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">
                                {{ $user->isVerified() ? 'SIM Terverifikasi Aktif' : 'Perbarui Foto SIM A / KTP' }}
                            </span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-text-muted group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors text-[18px]">chevron_right</span>
                </a>

                <a href="{{ route('returns.index') }}" class="p-3.5 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 hover:bg-surface-container dark:hover:bg-surface-container-dark border border-outline-variant/40 dark:border-outline-dark/40 flex items-center justify-between transition-colors group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">assignment_return</span>
                        </div>
                        <div class="space-y-0.5">
                            <h4 class="font-bold text-xs text-on-surface dark:text-on-surface-dark group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors">
                                Pengembalian Mobil
                            </h4>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">
                                Cek plat nomor & kalkulasi denda
                            </span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-text-muted group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors text-[18px]">chevron_right</span>
                </a>

                <a href="{{ route('fleet.index') }}" class="p-3.5 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 hover:bg-surface-container dark:hover:bg-surface-container-dark border border-outline-variant/40 dark:border-outline-dark/40 flex items-center justify-between transition-colors group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-950 text-primary dark:text-inverse-primary flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">directions_car</span>
                        </div>
                        <div class="space-y-0.5">
                            <h4 class="font-bold text-xs text-on-surface dark:text-on-surface-dark group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors">
                                Katalog Armada Lengkap
                            </h4>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">
                                Lihat ketersediaan unit terbaru
                            </span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-text-muted group-hover:text-primary dark:group-hover:text-inverse-primary transition-colors text-[18px]">chevron_right</span>
                </a>
            </div>

            <a href="{{ route('fleet.index') }}" class="block w-full py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold text-center text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 hover:text-primary dark:hover:text-inverse-primary transition-colors cursor-pointer">
                Eksplorasi Semua Mobil
            </a>
        </div>

    </div>

</div>
@endsection
