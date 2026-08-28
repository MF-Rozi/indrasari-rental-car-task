@extends('layouts.admin')

@section('title', 'Tambah / Edit Unit Mobil - Admin Indrasari')
@section('header_title', 'Form Unit Mobil')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Breadcrumb & Action Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs text-text-muted dark:text-text-muted-dark">
            <a href="{{ url('/admin/cars') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Kelola Mobil</a>
            <span>/</span>
            <span class="text-on-surface dark:text-on-surface-dark font-semibold">Tambah Unit Baru</span>
        </div>
        <a href="{{ url('/admin/cars') }}" class="px-3.5 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors">
            &larr; Kembali ke Daftar
        </a>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 sm:p-8 space-y-8">
        
        <div>
            <h2 class="text-xl font-bold text-on-surface dark:text-on-surface-dark">
                Informasi & Spesifikasi Unit Kendaraan
            </h2>
            <p class="text-xs text-text-muted dark:text-text-muted-dark mt-1">
                Lengkapi seluruh data mobil dengan benar untuk dimasukkan ke dalam sistem sewa Indrasari.
            </p>
        </div>

        <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Unit mobil berhasil disimpan ke dalam sistem!');" class="space-y-6">
            
            <!-- Row 1: Merek, Model & Tahun -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Merek Mobil <span class="text-red-500">*</span>
                    </label>
                    <input type="text" required placeholder="Contoh: Toyota, Honda..." class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Model & Varian <span class="text-red-500">*</span>
                    </label>
                    <input type="text" required placeholder="Contoh: Innova Zenix 2.0 Q" class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Tahun Pembuatan <span class="text-red-500">*</span>
                    </label>
                    <input type="number" required placeholder="2024" value="2024" class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>
            </div>

            <!-- Row 2: Nomor Plat, Tarif Sewa & Kategori -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Nomor Plat Polisi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" required placeholder="B 1234 SRI" class="w-full font-mono font-semibold uppercase px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Tarif Sewa / Hari (IDR) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-text-muted dark:text-text-muted-dark">Rp</span>
                        <input type="number" required placeholder="500000" class="w-full pl-10 pr-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Kategori / Tipe <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="MPV">MPV Keluarga</option>
                        <option value="SUV">SUV Tangguh</option>
                        <option value="Luxury">Luxury VIP</option>
                        <option value="Sedan">Sedan Premium</option>
                        <option value="Electric">Mobil Listrik (EV)</option>
                    </select>
                </div>
            </div>

            <!-- Row 3: Transmisi, Kapasitas & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Transmisi <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="Automatic">Automatic (AT / CVT)</option>
                        <option value="Manual">Manual (MT)</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Kapasitas Penumpang <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="4">4 Orang</option>
                        <option value="5">5 Orang</option>
                        <option value="7" selected>7 Orang</option>
                        <option value="8">8 Orang</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Status Ketersediaan <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="available">Tersedia (Ready to Rent)</option>
                        <option value="maintenance">Dalam Perawatan / Servis</option>
                    </select>
                </div>
            </div>

            <!-- Row 4: Image URL -->
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                    URL Foto Utama Mobil
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">image</span>
                    <input type="url" placeholder="https://images.unsplash.com/..." class="w-full pl-10 pr-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>
            </div>

            <!-- Row 5: Description -->
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                    Deskripsi & Kelengkapan Unit
                </label>
                <textarea rows="3" placeholder="Tuliskan detail fitur, kondisi kendaraan, atau instruksi khusus..." class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-none"></textarea>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-outline-variant/50 dark:border-outline-dark/50 flex items-center justify-end gap-3">
                <a href="{{ url('/admin/cars') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Simpan Data Mobil</span>
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
