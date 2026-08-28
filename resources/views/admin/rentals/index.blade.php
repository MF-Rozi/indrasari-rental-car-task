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
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">24 Transaksi</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">receipt_long</span>
            </div>
        </div>

        <!-- Active Rentals -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Sedang Digunakan</span>
                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400 block">2 Unit Aktif</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">directions_car</span>
            </div>
        </div>

        <!-- Returned Completed -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Pengembalian Selesai</span>
                <span class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 block">22 Transaksi</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">task_alt</span>
            </div>
        </div>

        <!-- Revenue Collected -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Total Pendapatan</span>
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">Rp 28.450.000</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">payments</span>
            </div>
        </div>

    </div>

    <!-- Data Table Container -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden p-5 sm:p-6 space-y-4">
        
        <!-- Toolbar & Filter -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-80">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">search</span>
                <input type="text" placeholder="Cari penyewa, no plat, kode..." class="w-full pl-10 pr-4 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select class="px-3 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs font-semibold text-on-surface dark:text-on-surface-dark outline-none">
                    <option value="all">Semua Status Peminjaman</option>
                    <option value="active">Sedang Disewa (Aktif)</option>
                    <option value="returned">Pengembalian Selesai</option>
                </select>
            </div>
        </div>

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
                    
                    <!-- Row 1: Active Rental -->
                    <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                        <td class="py-3.5 px-4">
                            <div class="space-y-0.5">
                                <span class="font-mono text-[11px] font-bold text-primary dark:text-inverse-primary block">IND-BK-0091</span>
                                <span class="font-bold text-on-surface dark:text-on-surface-dark block">Budi Santoso</span>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">0812-3456-7890 • SIM: 1234-5678-9012</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="space-y-0.5">
                                <span class="font-bold text-on-surface dark:text-on-surface-dark block">Toyota Innova Zenix 2.0 Q</span>
                                <span class="font-mono text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark block">B 2419 IND</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="space-y-0.5">
                                <span class="text-on-surface dark:text-on-surface-dark font-medium block">28 Ags 2026 - 31 Ags 2026</span>
                                <span class="text-text-muted dark:text-text-muted-dark text-[11px] block">Durasi: 3 Hari</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-sm text-on-surface dark:text-on-surface-dark block">Rp 1.950.000</span>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Rp 650.000 / hari</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/70 dark:text-blue-300 dark:border-blue-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                Sedang Disewa
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <button type="button" onclick="alert('Demo UI: Verifikasi Pengembalian Unit B 2419 IND')" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition-colors cursor-pointer inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                <span>Verifikasi Kembali</span>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 2: Completed Return -->
                    <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                        <td class="py-3.5 px-4">
                            <div class="space-y-0.5">
                                <span class="font-mono text-[11px] font-bold text-primary dark:text-inverse-primary block">IND-BK-0089</span>
                                <span class="font-bold text-on-surface dark:text-on-surface-dark block">Siti Rahmawati</span>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">0813-8877-6655 • SIM: 9876-5432-1098</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="space-y-0.5">
                                <span class="font-bold text-on-surface dark:text-on-surface-dark block">Toyota All New Avanza 1.5 G</span>
                                <span class="font-mono text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark block">B 1872 IND</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="space-y-0.5">
                                <span class="text-on-surface dark:text-on-surface-dark font-medium block">10 Ags 2026 - 12 Ags 2026</span>
                                <span class="text-text-muted dark:text-text-muted-dark text-[11px] block">Durasi: 2 Hari</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-sm text-on-surface dark:text-on-surface-dark block">Rp 750.000</span>
                            <span class="text-[11px] text-emerald-600 dark:text-emerald-400 block">Lunas</span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                                Selesai
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <button type="button" onclick="alert('Demo UI: Menampilkan Faktur IND-BK-0089')" class="p-1.5 rounded-lg text-primary dark:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors cursor-pointer" title="Cetak Faktur">
                                <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
