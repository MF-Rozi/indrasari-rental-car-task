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
        <p class="text-sm text-text-muted dark:text-text-muted-dark">
            Masukkan nomor plat mobil yang Anda sewa untuk memverifikasi data dan menghitung total tagihan akhir.
        </p>
    </div>

    <!-- Step 1: Input & Verification Form -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-6">
        <div>
            <h2 class="text-base font-bold text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                <span class="w-6 h-6 rounded-full bg-primary text-white text-xs flex items-center justify-center font-bold">1</span>
                <span>Verifikasi Nomor Plat Kendaraan</span>
            </h2>
            <p class="text-xs text-text-muted dark:text-text-muted-dark mt-1">
                Sistem akan memverifikasi apakah kendaraan sedang dalam status sewa aktif atas nama akun Anda.
            </p>
        </div>

        <form id="verifyReturnForm" onsubmit="event.preventDefault(); verifyPlateNumber();" class="space-y-4">
            <div class="space-y-2">
                <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                    Nomor Plat Mobil Polisi <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[20px]">pin</span>
                        <input type="text" id="plateInput" required placeholder="Contoh: B 2419 IND" value="{{ request('plate', 'B 2419 IND') }}" class="w-full pl-11 pr-4 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-base font-mono font-bold uppercase text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                    </div>
                    <button type="submit" class="py-2.5 px-6 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">verified</span>
                        <span>Verifikasi Plat</span>
                    </button>
                </div>
            </div>

            <!-- Quick Auto-Fill Chips -->
            <div class="flex items-center gap-2 pt-1">
                <span class="text-xs text-text-muted dark:text-text-muted-dark">Unit Aktif Anda:</span>
                <button type="button" onclick="document.getElementById('plateInput').value = 'B 2419 IND'; verifyPlateNumber();" class="px-2.5 py-1 rounded bg-surface-container dark:bg-surface-container-dark hover:bg-primary/10 text-xs font-mono font-semibold text-primary dark:text-inverse-primary border border-outline-variant/60 dark:border-outline-dark/60 cursor-pointer transition-colors">
                    B 2419 IND (Innova Zenix)
                </button>
            </div>
        </form>
    </div>

    <!-- Step 2: Calculation & Return Details Panel (Dynamic) -->
    <div id="calculationPanel" class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex items-center justify-between border-b border-outline-variant/50 dark:border-outline-dark/50 pb-4">
            <div>
                <h2 class="text-base font-bold text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white text-xs flex items-center justify-center font-bold">2</span>
                    <span>Hasil Verifikasi & Perhitungan Tarif Sewa</span>
                </h2>
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    <span>Data sewa valid dan terdaftar atas nama Anda</span>
                </span>
            </div>
            <span class="font-mono text-xs font-bold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                B 2419 IND
            </span>
        </div>

        <!-- Vehicle Summary Card -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark">
            <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=300&q=80" alt="Innova Zenix" class="w-24 h-18 object-cover rounded-lg border border-slate-200 dark:border-slate-800 shrink-0" />
            <div class="space-y-1">
                <span class="text-xs uppercase font-bold text-text-muted dark:text-text-muted-dark">Toyota</span>
                <h3 class="text-base font-bold text-on-surface dark:text-on-surface-dark">
                    Innova Zenix 2.0 Q Hybrid (2024)
                </h3>
                <span class="text-xs text-text-muted dark:text-text-muted-dark block">
                    Penyewa: <strong>Budi Santoso</strong> • No. SIM: <strong>1234-5678-9012</strong>
                </span>
            </div>
        </div>

        <!-- Calculation Grid Breakdown -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-xl border border-outline-variant/60 dark:border-outline-dark/60 bg-background dark:bg-background-dark space-y-1">
                <span class="text-xs text-text-muted dark:text-text-muted-dark block">Tanggal Mulai Sewa</span>
                <span class="text-sm font-bold text-on-surface dark:text-on-surface-dark">28 Agustus 2026</span>
                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">10:00 WIB</span>
            </div>

            <div class="p-4 rounded-xl border border-outline-variant/60 dark:border-outline-dark/60 bg-background dark:bg-background-dark space-y-1">
                <span class="text-xs text-text-muted dark:text-text-muted-dark block">Tanggal Pengembalian</span>
                <span class="text-sm font-bold text-on-surface dark:text-on-surface-dark">31 Agustus 2026</span>
                <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium block">Tepat Waktu</span>
            </div>

            <div class="p-4 rounded-xl border border-outline-variant/60 dark:border-outline-dark/60 bg-background dark:bg-background-dark space-y-1">
                <span class="text-xs text-text-muted dark:text-text-muted-dark block">Total Durasi Sewa</span>
                <span class="text-sm font-bold text-primary dark:text-inverse-primary">3 Hari</span>
                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Per 24 Jam</span>
            </div>
        </div>

        <!-- Cost Calculation Formula Card -->
        <div class="p-5 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-3">
            <div class="flex items-center justify-between text-xs text-text-muted dark:text-text-muted-dark">
                <span>Tarif Sewa Harian:</span>
                <span class="font-semibold text-on-surface dark:text-on-surface-dark">Rp 650.000 / hari</span>
            </div>
            <div class="flex items-center justify-between text-xs text-text-muted dark:text-text-muted-dark">
                <span>Durasi Terhitung:</span>
                <span class="font-semibold text-on-surface dark:text-on-surface-dark">3 Hari</span>
            </div>
            <div class="flex items-center justify-between text-xs text-emerald-600 dark:text-emerald-400">
                <span>Denda Keterlambatan:</span>
                <span class="font-semibold">Rp 0 (Tepat Waktu)</span>
            </div>
            
            <div class="pt-3 border-t border-outline-variant/60 dark:border-outline-dark/60 flex items-baseline justify-between">
                <div>
                    <span class="text-xs font-bold text-on-surface dark:text-on-surface-dark uppercase tracking-wider block">Total Biaya Akhir</span>
                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark">Dihitung otomatis: 3 x Rp 650.000</span>
                </div>
                <strong class="text-2xl sm:text-3xl font-bold text-primary dark:text-inverse-primary">
                    Rp 1.950.000
                </strong>
            </div>
        </div>

        <!-- Confirm Action Button -->
        <div class="pt-2 flex flex-col sm:flex-row items-center justify-end gap-3">
            <a href="{{ url('/rentals') }}" class="w-full sm:w-auto px-5 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors text-center">
                Batal
            </a>
            <button type="button" onclick="openInvoiceModal()" class="w-full sm:w-auto py-3 px-8 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-md shadow-emerald-600/20 transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                <span>Konfirmasi dan Selesaikan Pengembalian</span>
            </button>
        </div>
    </div>

</div>

<!-- Printable Digital Return Invoice Modal -->
<div id="invoiceModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="bg-white dark:bg-surface-dark rounded-2xl max-w-lg w-full p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-2xl space-y-6 relative max-h-[90vh] overflow-y-auto">
        
        <!-- Close Button -->
        <button type="button" onclick="closeInvoiceModal()" class="absolute top-5 right-5 p-1.5 rounded-lg text-text-muted hover:text-on-surface hover:bg-surface-container transition-colors cursor-pointer">
            <span class="material-symbols-outlined text-xl">close</span>
        </button>

        <!-- Receipt Header -->
        <div class="text-center space-y-2 border-b border-outline-variant/60 dark:border-outline-dark/60 pb-5">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 mx-auto flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl">task_alt</span>
            </div>
            <h3 class="text-xl font-bold text-on-surface dark:text-on-surface-dark">
                Pengembalian Berhasil!
            </h3>
            <p class="text-xs text-text-muted dark:text-text-muted-dark">
                Faktur Resmi Pengembalian • No. Faktur: <strong>INV-20260828-0042</strong>
            </p>
        </div>

        <!-- Receipt Line Items -->
        <div class="space-y-3 text-xs text-text-muted dark:text-text-muted-dark">
            <div class="flex justify-between py-1 border-b border-outline-variant/30 dark:border-outline-dark/30">
                <span>Nama Penyewa:</span>
                <strong class="text-on-surface dark:text-on-surface-dark">Budi Santoso</strong>
            </div>
            <div class="flex justify-between py-1 border-b border-outline-variant/30 dark:border-outline-dark/30">
                <span>Unit Mobil:</span>
                <strong class="text-on-surface dark:text-on-surface-dark">Toyota Innova Zenix 2.0 Q</strong>
            </div>
            <div class="flex justify-between py-1 border-b border-outline-variant/30 dark:border-outline-dark/30">
                <span>Nomor Plat:</span>
                <strong class="font-mono text-primary dark:text-inverse-primary">B 2419 IND</strong>
            </div>
            <div class="flex justify-between py-1 border-b border-outline-variant/30 dark:border-outline-dark/30">
                <span>Durasi Sewa:</span>
                <span class="text-on-surface dark:text-on-surface-dark">3 Hari (28 - 31 Ags 2026)</span>
            </div>
            <div class="flex justify-between py-1 border-b border-outline-variant/30 dark:border-outline-dark/30">
                <span>Tarif Harian:</span>
                <span class="text-on-surface dark:text-on-surface-dark">Rp 650.000</span>
            </div>
            <div class="flex justify-between pt-2 text-sm font-bold text-on-surface dark:text-on-surface-dark">
                <span>Total Pembayaran:</span>
                <span class="text-emerald-600 dark:text-emerald-400">Rp 1.950.000</span>
            </div>
            <div class="flex justify-between text-[11px] text-emerald-700 dark:text-emerald-400">
                <span>Status Pembayaran:</span>
                <span class="font-bold uppercase tracking-wider">LUNAS</span>
            </div>
        </div>

        <!-- Modal Actions -->
        <div class="pt-4 border-t border-outline-variant/50 dark:border-outline-dark/50 flex flex-col sm:flex-row items-center gap-3">
            <button type="button" onclick="window.print()" class="w-full sm:flex-1 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors flex items-center justify-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">print</span>
                <span>Cetak Faktur</span>
            </button>
            <a href="{{ url('/rentals') }}" class="w-full sm:flex-1 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all text-center">
                Selesai
            </a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function verifyPlateNumber() {
        const plate = document.getElementById('plateInput').value.trim().toUpperCase();
        if (plate.length > 0) {
            document.getElementById('calculationPanel').classList.remove('hidden');
        }
    }

    function openInvoiceModal() {
        document.getElementById('invoiceModal').classList.remove('hidden');
    }

    function closeInvoiceModal() {
        document.getElementById('invoiceModal').classList.add('hidden');
    }
</script>
@endpush
