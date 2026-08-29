@extends('layouts.admin')

@section('title', 'Executive Dashboard - Admin Indrasari')
@section('header_title', 'Dashboard Operasional Pusat')

@section('content')
<div class="space-y-8">

    <!-- Executive Greeting & Quick Action Banner -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="space-y-1.5">
            <div class="flex items-center gap-2 text-xs font-bold text-primary dark:text-inverse-primary uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Sistem Operasional Real-Time • {{ date('d F Y') }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface dark:text-on-surface-dark">
                Pusat Kontrol Rental Indrasari
            </h1>
            <p class="text-xs sm:text-sm text-text-muted dark:text-text-muted-dark">
                Monitoring armada sewa, verifikasi legalitas SIM pelanggan, dan rekapitulasi performa finansial harian.
            </p>
        </div>

        <!-- Quick Shortcut Actions -->
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.cars.create') }}" class="px-4 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-bold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-1.5 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Tambah Mobil</span>
            </a>
            
            <a href="{{ route('admin.rentals.index', ['status' => 'pending_return']) }}" class="px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 hover:text-primary dark:hover:text-inverse-primary transition-colors flex items-center gap-1.5 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">assignment_return</span>
                <span>Proses Kembali</span>
                @if($stats['pending_return_rentals'] > 0)
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 animate-pulse">
                        {{ $stats['pending_return_rentals'] }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.users.index', ['verification_status' => 'pending']) }}" class="px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 hover:text-primary dark:hover:text-inverse-primary transition-colors flex items-center gap-1.5 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">verified_user</span>
                <span>Antrean SIM A</span>
                @if($userStats['pending_users'] > 0)
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 animate-pulse">
                        {{ $userStats['pending_users'] }}
                    </span>
                @endif
            </a>
        </div>
    </div>

    <!-- KPI Metric Bento Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Metric 1: Total Revenue -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Total Pendapatan Selesai</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">payments</span>
                </div>
            </div>
            <div class="space-y-1">
                <span class="text-2xl font-extrabold text-on-surface dark:text-on-surface-dark font-mono block">
                    Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                </span>
                <div class="flex items-center gap-1 text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    <span>Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }} bulan ini</span>
                </div>
            </div>
        </div>

        <!-- Metric 2: Fleet Status -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Kesiapan Armada Mobil</span>
                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">directions_car</span>
                </div>
            </div>
            <div class="space-y-1">
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">
                    {{ $fleetStats['available_fleets'] }} / {{ $fleetStats['total_fleets'] }} Tersedia
                </span>
                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">
                    {{ $fleetStats['rented_fleets'] }} Disewa • {{ $fleetStats['maintenance_fleets'] }} Perawatan
                </span>
            </div>
        </div>

        <!-- Metric 3: Total Bookings -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Transaksi Peminjaman</span>
                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">receipt_long</span>
                </div>
            </div>
            <div class="space-y-1">
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">
                    {{ number_format($stats['total_rentals']) }} Transaksi
                </span>
                <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold block">
                    {{ $stats['completed_rentals'] }} Selesai • {{ $stats['active_rentals'] }} Berjalan
                </span>
            </div>
        </div>

        <!-- Metric 4: Verified Users -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Pengemudi Terverifikasi</span>
                <div class="w-9 h-9 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl">badge</span>
                </div>
            </div>
            <div class="space-y-1">
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">
                    {{ number_format($userStats['verified_users']) }} Pengemudi
                </span>
                <span class="text-[11px] {{ $userStats['pending_users'] > 0 ? 'text-amber-600 dark:text-amber-400 font-bold' : 'text-text-muted dark:text-text-muted-dark' }} block">
                    {{ $userStats['pending_users'] }} Butuh Verifikasi SIM
                </span>
            </div>
        </div>

    </div>

    <!-- Fleet Operational Composition Progress Bar Card -->
    @php
        $totalF = max(1, $fleetStats['total_fleets']);
        $pctAvailable = round(($fleetStats['available_fleets'] / $totalF) * 100);
        $pctRented = round(($fleetStats['rented_fleets'] / $totalF) * 100);
        $pctMaintenance = round(($fleetStats['maintenance_fleets'] / $totalF) * 100);
    @endphp
    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-5 sm:p-6 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-outline-variant/50 dark:border-outline-dark/50 pb-3">
            <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                <span class="material-symbols-outlined text-primary dark:text-inverse-primary text-[20px]">equalizer</span>
                <span>Komposisi Status Operasional Armada Mobil ({{ $fleetStats['total_fleets'] }} Total Unit)</span>
            </h3>
            <a href="{{ route('admin.cars.index') }}" class="text-xs font-semibold text-primary dark:text-inverse-primary hover:underline">
                Kelola Armada &rarr;
            </a>
        </div>

        <div class="space-y-3">
            <!-- Multi-segment progress bar -->
            <div class="w-full h-3 rounded-full bg-slate-100 dark:bg-slate-800 flex overflow-hidden">
                <div class="bg-emerald-500 transition-all duration-500" style="width: {{ $pctAvailable }}%;" title="Tersedia: {{ $pctAvailable }}%"></div>
                <div class="bg-blue-500 transition-all duration-500" style="width: {{ $pctRented }}%;" title="Sedang Disewa: {{ $pctRented }}%"></div>
                <div class="bg-amber-500 transition-all duration-500" style="width: {{ $pctMaintenance }}%;" title="Perawatan: {{ $pctMaintenance }}%"></div>
            </div>

            <!-- Legend items -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/40 dark:border-outline-dark/40">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 shrink-0"></span>
                    <div class="space-y-0.5">
                        <span class="font-bold text-on-surface dark:text-on-surface-dark block">Tersedia (Ready)</span>
                        <span class="text-text-muted dark:text-text-muted-dark text-[11px]">{{ $fleetStats['available_fleets'] }} Unit ({{ $pctAvailable }}%)</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/40 dark:border-outline-dark/40">
                    <span class="w-3 h-3 rounded-full bg-blue-500 shrink-0"></span>
                    <div class="space-y-0.5">
                        <span class="font-bold text-on-surface dark:text-on-surface-dark block">Sedang Disewa (Rented)</span>
                        <span class="text-text-muted dark:text-text-muted-dark text-[11px]">{{ $fleetStats['rented_fleets'] }} Unit ({{ $pctRented }}%)</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 p-2.5 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/40 dark:border-outline-dark/40">
                    <span class="w-3 h-3 rounded-full bg-amber-500 shrink-0"></span>
                    <div class="space-y-0.5">
                        <span class="font-bold text-on-surface dark:text-on-surface-dark block">Dalam Bengkel (Maintenance)</span>
                        <span class="text-text-muted dark:text-text-muted-dark text-[11px]">{{ $fleetStats['maintenance_fleets'] }} Unit ({{ $pctMaintenance }}%)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Required Queues (2 Column Layout) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Queue 1: Pending Return Verification -->
        <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-5 sm:p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-outline-variant/50 dark:border-outline-dark/50 pb-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-500 text-xl">assignment_late</span>
                    <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark">
                        Antrean Pengembalian Fisik Unit
                    </h3>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $pendingReturns->isNotEmpty() ? 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' }}">
                    {{ $pendingReturns->count() }} Menunggu
                </span>
            </div>

            @if($pendingReturns->isEmpty())
                <div class="py-8 text-center text-text-muted dark:text-text-muted-dark space-y-2">
                    <span class="material-symbols-outlined text-3xl text-emerald-500">task_alt</span>
                    <p class="text-xs font-semibold">Tidak ada pengajuan pengembalian unit yang menunggu verifikasi saat ini.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($pendingReturns as $pReturn)
                        <div class="p-3.5 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/40 dark:border-outline-dark/40 flex items-center justify-between gap-4">
                            <div class="space-y-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-xs text-on-surface dark:text-on-surface-dark truncate">
                                        {{ $pReturn->fleet->brand }} {{ $pReturn->fleet->model }}
                                    </h4>
                                    <span class="font-mono text-[10px] font-bold px-1.5 py-0.2 rounded bg-primary text-white">
                                        {{ $pReturn->fleet->plate_number }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-text-muted dark:text-text-muted-dark truncate">
                                    Penyewa: <strong class="text-on-surface dark:text-on-surface-dark">{{ $pReturn->user->name }}</strong> • Kode: <span class="font-mono text-primary dark:text-inverse-primary">{{ $pReturn->rental_code }}</span>
                                </p>
                            </div>
                            <a href="{{ route('admin.rentals.index', ['search' => $pReturn->rental_code]) }}" class="px-3 py-1.5 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition-colors shrink-0 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">assignment_turned_in</span>
                                <span>Verifikasi</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <a href="{{ route('admin.rentals.index', ['status' => 'pending_return']) }}" class="block text-center py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 hover:text-primary dark:hover:text-inverse-primary transition-colors">
                Buka Panel Kelola Transaksi
            </a>
        </div>

        <!-- Queue 2: Pending SIM A Verification -->
        <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-5 sm:p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-outline-variant/50 dark:border-outline-dark/50 pb-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-purple-500 text-xl">badge</span>
                    <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark">
                        Antrean Verifikasi Legalitas SIM A
                    </h3>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $pendingVerifications->isNotEmpty() ? 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' }}">
                    {{ $pendingVerifications->count() }} Pendaftar
                </span>
            </div>

            @if($pendingVerifications->isEmpty())
                <div class="py-8 text-center text-text-muted dark:text-text-muted-dark space-y-2">
                    <span class="material-symbols-outlined text-3xl text-emerald-500">verified</span>
                    <p class="text-xs font-semibold">Semua dokumen SIM A pendaftar telah diverifikasi.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($pendingVerifications as $pUser)
                        <div class="p-3.5 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/40 dark:border-outline-dark/40 flex items-center justify-between gap-4">
                            <div class="space-y-1 min-w-0">
                                <h4 class="font-bold text-xs text-on-surface dark:text-on-surface-dark truncate">
                                    {{ $pUser->name }}
                                </h4>
                                <p class="text-[11px] text-text-muted dark:text-text-muted-dark truncate">
                                    No. SIM: <strong class="font-mono text-on-surface dark:text-on-surface-dark">{{ $pUser->driving_license_number ?? '-' }}</strong> • Tel: {{ $pUser->phone_number ?? '-' }}
                                </p>
                            </div>
                            <a href="{{ route('admin.users.index', ['search' => $pUser->name]) }}" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors shrink-0 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">verified</span>
                                <span>Periksa SIM</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <a href="{{ route('admin.users.index', ['verification_status' => 'pending']) }}" class="block text-center py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-xs font-bold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-slate-800 hover:text-primary dark:hover:text-inverse-primary transition-colors">
                Buka Panel Kelola Pengguna
            </a>
        </div>

    </div>

    <!-- Recent Platform Transactions Table -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5 sm:p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-outline-variant/50 dark:border-outline-dark/50 pb-3">
            <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                <span class="material-symbols-outlined text-primary dark:text-inverse-primary text-[20px]">history</span>
                <span>5 Transaksi Peminjaman Terbaru di Seluruh Platform</span>
            </h3>
            <a href="{{ route('admin.rentals.index') }}" class="text-xs font-semibold text-primary dark:text-inverse-primary hover:underline">
                Lihat Semua Transaksi &rarr;
            </a>
        </div>

        @if($recentRentals->isEmpty())
            <div class="py-10 text-center text-text-muted dark:text-text-muted-dark space-y-2">
                <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 block">inventory_2</span>
                <span class="text-xs font-semibold block">Belum ada data transaksi sewa di platform.</span>
            </div>
        @else
            <div class="overflow-x-auto border border-outline-variant/60 dark:border-outline-dark/60 rounded-xl">
                <table class="w-full text-left text-xs text-on-surface dark:text-on-surface-dark divide-y divide-outline-variant/60 dark:divide-outline-dark/60">
                    <thead class="bg-surface-container dark:bg-surface-container-dark font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        <tr>
                            <th class="py-3 px-4">Kode & Penyewa</th>
                            <th class="py-3 px-4">Unit Mobil & Plat</th>
                            <th class="py-3 px-4">Periode</th>
                            <th class="py-3 px-4">Total Biaya</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/40 dark:divide-outline-dark/40 bg-white dark:bg-surface-dark">
                        @foreach($recentRentals as $rItem)
                            <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                                <td class="py-3 px-4">
                                    <span class="font-mono font-bold text-primary dark:text-inverse-primary block">{{ $rItem->rental_code }}</span>
                                    <span class="font-bold text-on-surface dark:text-on-surface-dark">{{ $rItem->user->name }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-bold text-on-surface dark:text-on-surface-dark block">{{ $rItem->fleet->brand }} {{ $rItem->fleet->model }}</span>
                                    <span class="font-mono text-[11px] text-text-muted dark:text-text-muted-dark">{{ $rItem->fleet->plate_number }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span>{{ $rItem->start_date->format('d M') }} - {{ $rItem->end_date->format('d M Y') }}</span>
                                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">({{ $rItem->total_days }} Hari)</span>
                                </td>
                                <td class="py-3 px-4 font-mono font-bold">
                                    Rp {{ number_format((float)$rItem->total_price + (float)$rItem->penalty_price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4">
                                    @if($rItem->status === 'pending_return')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">
                                            Pengembalian
                                        </span>
                                    @elseif($rItem->status === 'active')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300">
                                            Aktif
                                        </span>
                                    @elseif($rItem->status === 'completed')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                            Selesai
                                        </span>
                                    @elseif($rItem->status === 'cancelled')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                            Batal
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('admin.rentals.index', ['search' => $rItem->rental_code]) }}" class="px-2.5 py-1 rounded-lg bg-surface-container dark:bg-surface-container-dark hover:bg-primary/10 text-primary dark:text-inverse-primary text-[11px] font-bold transition-colors">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
