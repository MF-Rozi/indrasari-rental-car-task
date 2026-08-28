@extends('layouts.admin')

@section('title', 'Kelola Armada Mobil - Admin Indrasari')
@section('header_title', 'Manajemen Armada Mobil')

@section('content')
<div class="space-y-6">

    <!-- Top Stats Overview Bento -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Stat 1: Total -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-text-muted dark:text-text-muted-dark block">Total Mobil</span>
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark mt-1 block">8 Unit</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">directions_car</span>
            </div>
        </div>

        <!-- Stat 2: Tersedia -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-emerald-700 dark:text-emerald-400 block font-medium">Tersedia (Ready)</span>
                <span class="text-2xl font-bold text-emerald-800 dark:text-emerald-300 mt-1 block">6 Unit</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">check_circle</span>
            </div>
        </div>

        <!-- Stat 3: Sedang Disewa -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-blue-700 dark:text-blue-400 block font-medium">Sedang Disewa</span>
                <span class="text-2xl font-bold text-blue-800 dark:text-blue-300 mt-1 block">2 Unit</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">key</span>
            </div>
        </div>

        <!-- Stat 4: Perawatan -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-amber-700 dark:text-amber-400 block font-medium">Dalam Perawatan</span>
                <span class="text-2xl font-bold text-amber-800 dark:text-amber-300 mt-1 block">0 Unit</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">build</span>
            </div>
        </div>
    </div>

    <!-- Table Container Section -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden space-y-4 p-5 sm:p-6">
        
        <!-- Table Toolbar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3 flex-1 max-w-md">
                <div class="relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">search</span>
                    <input type="text" placeholder="Cari nomor plat, merek, atau model..." class="w-full pl-9 pr-3 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ url('/admin/cars/create') }}" class="py-2 px-4 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>Tambah Mobil Baru</span>
                </a>
            </div>
        </div>

        <!-- Table Data -->
        <div class="overflow-x-auto border border-outline-variant/60 dark:border-outline-dark/60 rounded-xl">
            <table class="w-full text-left text-xs text-on-surface dark:text-on-surface-dark divide-y divide-outline-variant/60 dark:divide-outline-dark/60">
                <thead class="bg-surface-container dark:bg-surface-container-dark font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                    <tr>
                        <th class="py-3.5 px-4">Mobil & Merek</th>
                        <th class="py-3.5 px-4">Nomor Plat</th>
                        <th class="py-3.5 px-4">Kategori & Transmisi</th>
                        <th class="py-3.5 px-4">Tarif Sewa (IDR)</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/40 dark:divide-outline-dark/40 bg-white dark:bg-surface-dark">
                    
                    <!-- Row 1 -->
                    <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                        <td class="py-3 px-4 flex items-center gap-3">
                            <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=120&q=80" class="w-12 h-10 object-cover rounded-lg border border-slate-200 dark:border-slate-800" />
                            <div>
                                <span class="font-bold text-on-surface dark:text-on-surface-dark block">Toyota Innova Zenix 2.0 Q</span>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark">Tahun 2024 • 7 Kursi</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 font-mono font-semibold text-primary dark:text-inverse-primary">
                            B 2419 IND
                        </td>
                        <td class="py-3 px-4">
                            <span class="block">MPV Premium</span>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark">Matic (CVT)</span>
                        </td>
                        <td class="py-3 px-4 font-bold">
                            Rp 650.000 <span class="text-[10px] text-text-muted dark:text-text-muted-dark font-normal">/ hari</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Tersedia
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ url('/fleet/1') }}" class="p-1.5 rounded-lg text-text-muted dark:text-text-muted-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors" title="Lihat">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>
                                <a href="{{ url('/admin/cars/create') }}" class="p-1.5 rounded-lg text-text-muted dark:text-text-muted-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                        <td class="py-3 px-4 flex items-center gap-3">
                            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=120&q=80" class="w-12 h-10 object-cover rounded-lg border border-slate-200 dark:border-slate-800" />
                            <div>
                                <span class="font-bold text-on-surface dark:text-on-surface-dark block">Toyota Alphard 2.5 Transformer</span>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark">Tahun 2023 • 6 Kursi VIP</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 font-mono font-semibold text-primary dark:text-inverse-primary">
                            B 1008 SRI
                        </td>
                        <td class="py-3 px-4">
                            <span class="block">Luxury VIP</span>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark">Matic (AT)</span>
                        </td>
                        <td class="py-3 px-4 font-bold">
                            Rp 1.850.000 <span class="text-[10px] text-text-muted dark:text-text-muted-dark font-normal">/ hari</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Tersedia
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ url('/fleet/2') }}" class="p-1.5 rounded-lg text-text-muted dark:text-text-muted-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors" title="Lihat">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>
                                <a href="{{ url('/admin/cars/create') }}" class="p-1.5 rounded-lg text-text-muted dark:text-text-muted-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                        <td class="py-3 px-4 flex items-center gap-3">
                            <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=120&q=80" class="w-12 h-10 object-cover rounded-lg border border-slate-200 dark:border-slate-800" />
                            <div>
                                <span class="font-bold text-on-surface dark:text-on-surface-dark block">Toyota All New Avanza 1.5 G</span>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark">Tahun 2023 • 7 Kursi</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 font-mono font-semibold text-primary dark:text-inverse-primary">
                            B 1872 IND
                        </td>
                        <td class="py-3 px-4">
                            <span class="block">MPV Keluarga</span>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark">Matic (CVT)</span>
                        </td>
                        <td class="py-3 px-4 font-bold">
                            Rp 375.000 <span class="text-[10px] text-text-muted dark:text-text-muted-dark font-normal">/ hari</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Tersedia
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ url('/fleet/3') }}" class="p-1.5 rounded-lg text-text-muted dark:text-text-muted-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors" title="Lihat">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>
                                <a href="{{ url('/admin/cars/create') }}" class="p-1.5 rounded-lg text-text-muted dark:text-text-muted-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
