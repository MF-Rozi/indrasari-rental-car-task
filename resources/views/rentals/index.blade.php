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
            <p class="text-sm text-text-muted dark:text-text-muted-dark">
                Pantau status kendaraan yang sedang Anda gunakan dan lihat riwayat peminjaman sebelumnya.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ url('/returns') }}" class="px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">assignment_return</span>
                <span>Kembalikan Mobil</span>
            </a>
            <a href="{{ url('/fleet') }}" class="px-4 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span>Sewa Mobil Baru</span>
            </a>
        </div>
    </div>

    <!-- Tab Selector -->
    <div class="flex items-center gap-2 border-b border-outline-variant/60 dark:border-outline-dark/60">
        <button type="button" id="tabActiveBtn" onclick="switchRentalTab('active')" class="pb-3 px-4 text-sm font-bold border-b-2 border-primary text-primary dark:text-inverse-primary cursor-pointer transition-colors flex items-center gap-2">
            <span>Sedang Disewa (Aktif)</span>
            <span class="px-2 py-0.5 rounded-full text-xs bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 font-bold">1 Unit</span>
        </button>
        <button type="button" id="tabHistoryBtn" onclick="switchRentalTab('history')" class="pb-3 px-4 text-sm font-semibold border-b-2 border-transparent text-text-muted dark:text-text-muted-dark hover:text-on-surface dark:hover:text-on-surface-dark cursor-pointer transition-colors flex items-center gap-2">
            <span>Riwayat Selesai</span>
            <span class="px-2 py-0.5 rounded-full text-xs bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">2 Riwayat</span>
        </button>
    </div>

    <!-- Active Rentals Panel -->
    <div id="activeRentalsPanel" class="space-y-6">
        
        <!-- Active Rental Card 1 -->
        <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 group hover:border-primary/40 dark:hover:border-inverse-primary/40 transition-all">
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 w-full lg:w-auto">
                <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=400&q=80" alt="Innova Zenix" class="w-full sm:w-44 h-32 object-cover rounded-xl border border-slate-200 dark:border-slate-800 shrink-0" />
                
                <div class="space-y-2.5">
                    <div class="flex items-center gap-2.5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/70 dark:text-blue-300 dark:border-blue-800">
                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span>
                            Sedang Berjalan
                        </span>
                        <span class="font-mono text-xs font-semibold px-2 py-0.5 rounded bg-surface-container dark:bg-surface-container-dark text-primary dark:text-inverse-primary">
                            B 2419 IND
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-on-surface dark:text-on-surface-dark">
                        Toyota Innova Zenix 2.0 Q Hybrid
                    </h3>

                    <div class="flex flex-wrap items-center gap-4 text-xs text-text-muted dark:text-text-muted-dark">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">calendar_today</span>
                            <span>Mulai: <strong>28 Ags 2026</strong></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">event</span>
                            <span>Selesai: <strong>31 Ags 2026</strong></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-primary dark:text-inverse-primary">schedule</span>
                            <span>Durasi: 3 Hari</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price & Action Section -->
            <div class="w-full lg:w-auto flex flex-row lg:flex-col items-center lg:items-end justify-between gap-4 border-t lg:border-t-0 border-outline-variant/50 dark:border-outline-dark/50 pt-4 lg:pt-0 shrink-0">
                <div class="text-left lg:text-right">
                    <span class="text-xs text-text-muted dark:text-text-muted-dark block">Total Biaya Sewa</span>
                    <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark">Rp 1.950.000</span>
                    <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium block">Tarif Rp 650.000 / hari</span>
                </div>

                <div class="flex items-center gap-2.5">
                    <a href="{{ url('/returns?plate=B2419IND') }}" class="py-2.5 px-4 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all flex items-center gap-1.5 cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">assignment_return</span>
                        <span>Kembalikan Unit</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

    <!-- History Rentals Panel -->
    <div id="historyRentalsPanel" class="hidden space-y-4">
        <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden p-5 sm:p-6 space-y-4">
            
            <div class="overflow-x-auto border border-outline-variant/60 dark:border-outline-dark/60 rounded-xl">
                <table class="w-full text-left text-xs text-on-surface dark:text-on-surface-dark divide-y divide-outline-variant/60 dark:divide-outline-dark/60">
                    <thead class="bg-surface-container dark:bg-surface-container-dark font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        <tr>
                            <th class="py-3.5 px-4">Kendaraan</th>
                            <th class="py-3.5 px-4">Nomor Plat</th>
                            <th class="py-3.5 px-4">Periode Sewa</th>
                            <th class="py-3.5 px-4">Durasi</th>
                            <th class="py-3.5 px-4">Total Tarif</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Faktur / Bukti</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/40 dark:divide-outline-dark/40 bg-white dark:bg-surface-dark">
                        <!-- History 1 -->
                        <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                            <td class="py-3 px-4 font-semibold">
                                Toyota All New Avanza 1.5 G
                            </td>
                            <td class="py-3 px-4 font-mono font-semibold text-primary dark:text-inverse-primary">
                                B 1872 IND
                            </td>
                            <td class="py-3 px-4 text-text-muted dark:text-text-muted-dark">
                                10 Ags 2026 - 12 Ags 2026
                            </td>
                            <td class="py-3 px-4">
                                2 Hari
                            </td>
                            <td class="py-3 px-4 font-bold">
                                Rp 750.000
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                                    Selesai Dikembalikan
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <button type="button" onclick="alert('Demo UI: Mengunduh Invoice Peminjaman B 1872 IND')" class="p-1.5 rounded-lg text-primary dark:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors cursor-pointer" title="Unduh Faktur">
                                    <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                                </button>
                            </td>
                        </tr>

                        <!-- History 2 -->
                        <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                            <td class="py-3 px-4 font-semibold">
                                Toyota Alphard 2.5 Transformer
                            </td>
                            <td class="py-3 px-4 font-mono font-semibold text-primary dark:text-inverse-primary">
                                B 1008 SRI
                            </td>
                            <td class="py-3 px-4 text-text-muted dark:text-text-muted-dark">
                                01 Ags 2026 - 03 Ags 2026
                            </td>
                            <td class="py-3 px-4">
                                2 Hari
                            </td>
                            <td class="py-3 px-4 font-bold">
                                Rp 3.700.000
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                                    Selesai Dikembalikan
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <button type="button" onclick="alert('Demo UI: Mengunduh Invoice Peminjaman B 1008 SRI')" class="p-1.5 rounded-lg text-primary dark:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors cursor-pointer" title="Unduh Faktur">
                                    <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

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
            historyBtn.className = "pb-3 px-4 text-sm font-bold border-b-2 border-primary text-primary dark:text-inverse-primary cursor-pointer transition-colors flex items-center gap-2";
            activeBtn.className = "pb-3 px-4 text-sm font-semibold border-b-2 border-transparent text-text-muted dark:text-text-muted-dark hover:text-on-surface dark:hover:text-on-surface-dark cursor-pointer transition-colors flex items-center gap-2";
            historyPanel.classList.remove('hidden');
            activePanel.classList.add('hidden');
        } else {
            activeBtn.className = "pb-3 px-4 text-sm font-bold border-b-2 border-primary text-primary dark:text-inverse-primary cursor-pointer transition-colors flex items-center gap-2";
            historyBtn.className = "pb-3 px-4 text-sm font-semibold border-b-2 border-transparent text-text-muted dark:text-text-muted-dark hover:text-on-surface dark:hover:text-on-surface-dark cursor-pointer transition-colors flex items-center gap-2";
            activePanel.classList.remove('hidden');
            historyPanel.classList.add('hidden');
        }
    }
</script>
@endpush
