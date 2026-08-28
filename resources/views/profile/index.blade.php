@extends('layouts.app')

@section('title', 'Profil Saya - Indrasari Rental Car')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-8">

    <!-- Profile Header Card -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-primary text-white text-2xl font-bold flex items-center justify-center shadow-md shadow-primary/20 shrink-0">
                BS
            </div>
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <h1 class="text-xl sm:text-2xl font-bold text-on-surface dark:text-on-surface-dark">
                        Budi Santoso
                    </h1>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                        <span class="material-symbols-outlined text-[14px]">verified</span>
                        SIM A Terverifikasi
                    </span>
                </div>
                <p class="text-xs text-text-muted dark:text-text-muted-dark">
                    Member sejak: <strong>Januari 2026</strong> • Total Sewa: <strong>3 Kali</strong>
                </p>
            </div>
        </div>

        <a href="{{ url('/rentals') }}" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors">
            Lihat Sewa Saya
        </a>
    </div>

    <!-- Main Profile Edit Form Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Left: Legal SIM Card Status -->
        <div class="md:col-span-1 space-y-6">
            <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm space-y-4">
                <div class="flex items-center gap-2 text-xs font-bold text-primary dark:text-inverse-primary uppercase tracking-wider">
                    <span class="material-symbols-outlined text-[18px]">credit_card</span>
                    <span>Legalitas Mengemudi</span>
                </div>

                <div class="p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-2 border border-outline-variant/60 dark:border-outline-dark/60">
                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Nomor SIM A</span>
                    <span class="font-mono text-base font-bold text-on-surface dark:text-on-surface-dark block">1234-5678-9012</span>
                    <div class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-semibold pt-1">
                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                        <span>Aktif s/d 2028</span>
                    </div>
                </div>

                <p class="text-[11px] text-text-muted dark:text-text-muted-dark leading-relaxed">
                    Data SIM A Anda telah diverifikasi oleh tim Indrasari. Pastikan nomor SIM selalu sesuai dengan dokumen asli saat serah terima kendaraan.
                </p>
            </div>
        </div>

        <!-- Right: Profile Information Form -->
        <div class="md:col-span-2 bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-6">
            <div>
                <h2 class="text-lg font-bold text-on-surface dark:text-on-surface-dark">
                    Informasi Data Pribadi
                </h2>
                <p class="text-xs text-text-muted dark:text-text-muted-dark mt-0.5">
                    Perbarui data domisili dan kontak untuk kelancaran transaksi persewaan mobil.
                </p>
            </div>

            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Demo UI: Data profil berhasil diperbarui!');" class="space-y-4">
                
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Nama Lengkap (Sesuai KTP / SIM)
                    </label>
                    <input type="text" value="Budi Santoso" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Nomor WhatsApp / HP
                        </label>
                        <input type="tel" value="0812-3456-7890" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Alamat Email
                        </label>
                        <input type="email" value="budi.santoso@gmail.com" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Alamat Domisili Lengkap
                    </label>
                    <textarea rows="3" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-none">Jl. Kemang Raya No. 45, RT 04 / RW 02, Bangka, Mampang Prapatan, Jakarta Selatan 12730</textarea>
                </div>

                <div class="pt-4 border-t border-outline-variant/50 dark:border-outline-dark/50 flex items-center justify-end gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
