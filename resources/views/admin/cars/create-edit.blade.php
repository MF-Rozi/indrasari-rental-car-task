@extends('layouts.admin')

@section('title', ($isEdit ? 'Edit Unit ' . $car->plate_number : 'Tambah Unit Mobil') . ' - Admin Indrasari')
@section('header_title', $isEdit ? 'Edit Data Kendaraan' : 'Tambah Unit Kendaraan Baru')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Breadcrumb & Action Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs text-text-muted dark:text-text-muted-dark">
            <a href="{{ route('admin.cars.index') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Kelola Mobil</a>
            <span>/</span>
            <span class="text-on-surface dark:text-on-surface-dark font-semibold">
                {{ $isEdit ? 'Edit: ' . $car->brand . ' ' . $car->model . ' (' . $car->plate_number . ')' : 'Tambah Unit Baru' }}
            </span>
        </div>
        <a href="{{ route('admin.cars.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-all shadow-xs group">
            <span class="material-symbols-outlined text-[20px] transition-transform group-hover:-translate-x-0.5">arrow_back</span>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 sm:p-8 space-y-6">
        
        <div>
            <h2 class="text-xl font-bold text-on-surface dark:text-on-surface-dark">
                {!! $isEdit ? 'Perbarui Spesifikasi & Informasi Kendaraan' : 'Informasi & Spesifikasi Unit Kendaraan' !!}
            </h2>
            <p class="text-xs text-text-muted dark:text-text-muted-dark mt-1">
                Lengkapi seluruh data mobil dan upload dokumentasi foto kendaraan untuk inventaris sewa Indrasari.
            </p>
        </div>

        @if($errors->any())
            <div class="p-4 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-xs space-y-1.5">
                <div class="font-semibold flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-red-500">error</span>
                    <span>Harap perbaiki kesalahan berikut sebelum menyimpan:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 pl-6">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="carForm" action="{{ $isEdit ? route('admin.cars.update', $car) : route('admin.cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif
            
            <!-- Row 1: Merek, Model, Tahun & Warna -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Merek Mobil <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="brand" value="{{ old('brand', $car->brand) }}" required placeholder="Contoh: Toyota, Honda..." class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border @error('brand') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Model & Varian <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="model" value="{{ old('model', $car->model) }}" required placeholder="Contoh: Innova Zenix 2.0 Q" class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border @error('model') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Tahun Pembuatan <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="year" value="{{ old('year', $car->year ?? date('Y')) }}" required min="1990" max="2035" placeholder="2024" class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border @error('year') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Warna Kendaraan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="color" value="{{ old('color', $car->color) }}" required placeholder="Contoh: Hitam Metalik" class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border @error('color') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>
            </div>

            <!-- Row 2: Nomor Plat, Tarif Sewa, Kategori & Bahan Bakar -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Nomor Plat Polisi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="plate_number" value="{{ old('plate_number', $car->plate_number) }}" required placeholder="B 1234 SRI" class="w-full font-mono font-semibold uppercase px-3.5 py-2.5 bg-background dark:bg-background-dark border @error('plate_number') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Tarif Sewa / Hari (IDR) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-text-muted dark:text-text-muted-dark">Rp</span>
                        <input type="number" name="price" value="{{ old('price', $car->price) }}" required min="0" step="5000" placeholder="500000" class="w-full pl-10 pr-3.5 py-2.5 bg-background dark:bg-background-dark border @error('price') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Kategori / Tipe <span class="text-red-500">*</span>
                    </label>
                    <select name="type" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="MPV" {{ old('type', $car->type) === 'MPV' ? 'selected' : '' }}>MPV (Keluarga)</option>
                        <option value="SUV" {{ old('type', $car->type) === 'SUV' ? 'selected' : '' }}>SUV (Tangguh)</option>
                        <option value="Luxury" {{ old('type', $car->type) === 'Luxury' ? 'selected' : '' }}>Luxury VIP</option>
                        <option value="Sedan" {{ old('type', $car->type) === 'Sedan' ? 'selected' : '' }}>Sedan Premium</option>
                        <option value="Electric" {{ old('type', $car->type) === 'Electric' ? 'selected' : '' }}>Mobil Listrik (EV)</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Bahan Bakar <span class="text-red-500">*</span>
                    </label>
                    <select name="fuel_type" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="Bensin" {{ old('fuel_type', $car->fuel_type) === 'Bensin' ? 'selected' : '' }}>Bensin (Gasoline)</option>
                        <option value="Diesel" {{ old('fuel_type', $car->fuel_type) === 'Diesel' ? 'selected' : '' }}>Diesel (Solar)</option>
                        <option value="Hybrid" {{ old('fuel_type', $car->fuel_type) === 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        <option value="Listrik" {{ old('fuel_type', $car->fuel_type) === 'Listrik' ? 'selected' : '' }}>Listrik (EV Battery)</option>
                    </select>
                </div>
            </div>

            <!-- Row 3: Transmisi, Kapasitas & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Transmisi <span class="text-red-500">*</span>
                    </label>
                    <select name="transmission" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="Automatic" {{ old('transmission', $car->transmission) === 'Automatic' ? 'selected' : '' }}>Automatic (AT / CVT)</option>
                        <option value="Manual" {{ old('transmission', $car->transmission) === 'Manual' ? 'selected' : '' }}>Manual (MT)</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Kapasitas Penumpang <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="seat_capacity" value="{{ old('seat_capacity', $car->seat_capacity ?? 7) }}" required min="1" max="30" placeholder="7" class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border @error('seat_capacity') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Status Ketersediaan <span class="text-red-500">*</span>
                    </label>
                    <select name="availability" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="available" {{ old('availability', $car->availability) === 'available' ? 'selected' : '' }}>Tersedia (Ready to Rent)</option>
                        <option value="rented" {{ old('availability', $car->availability) === 'rented' ? 'selected' : '' }}>Sedang Disewa (Rented)</option>
                        <option value="maintenance" {{ old('availability', $car->availability) === 'maintenance' ? 'selected' : '' }}>Dalam Perawatan / Servis</option>
                    </select>
                </div>
            </div>

            <!-- Row 4: Primary Cover Image Upload & Fallback URL -->
            <div class="p-5 rounded-2xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/60 dark:border-outline-dark/60 space-y-4">
                <div>
                    <h3 class="text-sm font-bold text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">photo_camera</span>
                        <span>Foto Utama (Cover Mobil)</span>
                    </h3>
                    <p class="text-xs text-text-muted dark:text-text-muted-dark mt-0.5">
                        Unggah foto berkualitas tinggi dari sisi depan-samping mobil (Format JPG/PNG/WEBP, Maks. 3MB).
                    </p>
                </div>

                @if($isEdit && $car->image)
                    <div class="flex items-center gap-4 p-3 bg-white dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-slate-800">
                        <img src="{{ $car->image_url }}" alt="{{ $car->full_name }}" class="w-24 h-16 object-cover rounded-lg border border-slate-200 dark:border-slate-800 shrink-0" />
                        <div class="text-xs space-y-1">
                            <span class="font-bold text-on-surface dark:text-on-surface-dark block">Foto Cover Saat Ini</span>
                            <span class="text-text-muted dark:text-text-muted-dark block truncate max-w-md">{{ $car->image }}</span>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Unggah Berkas Gambar Cover
                        </label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full px-3.5 py-2 bg-background dark:bg-background-dark border @error('image') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-xs text-on-surface dark:text-on-surface-dark file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary dark:file:text-inverse-primary hover:file:bg-primary/20 cursor-pointer" />
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Atau Gunakan Link URL Gambar Eksternal
                        </label>
                        <input type="url" name="image_url" value="{{ old('image_url', (str_starts_with($car->image ?? '', 'http') ? $car->image : '')) }}" placeholder="https://images.unsplash.com/..." class="w-full px-3.5 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                    </div>
                </div>
            </div>

            <!-- Row 5: Multi-Photo Gallery Upload -->
            <div class="p-5 rounded-2xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/60 dark:border-outline-dark/60 space-y-4">
                <div>
                    <h3 class="text-sm font-bold text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">collections</span>
                        <span>Galeri Foto Tambahan (Multi-Photo)</span>
                    </h3>
                    <p class="text-xs text-text-muted dark:text-text-muted-dark mt-0.5">
                        Tambahkan foto interior, bagasi, atau sudut lainnya (dapat memilih banyak foto sekaligus).
                    </p>
                </div>

                @if($isEdit && !empty($car->images) && count($car->images) > 0)
                    <div class="space-y-2">
                        <span class="text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark block">
                            Foto Galeri Saat Ini (Centang untuk menghapus foto):
                        </span>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach($car->images as $index => $galleryImg)
                                @php
                                    $gUrl = str_starts_with($galleryImg, 'http') ? $galleryImg : asset('storage/' . $galleryImg);
                                @endphp
                                <div class="relative rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 group bg-white dark:bg-surface-dark">
                                    <img src="{{ $gUrl }}" alt="Galeri {{ $car->plate_number }}" class="w-full h-24 object-cover" />
                                    <label class="flex items-center gap-1.5 p-2 text-[11px] font-semibold text-red-600 dark:text-red-400 bg-white/95 dark:bg-surface-dark/95 border-t border-slate-100 dark:border-slate-800 cursor-pointer hover:bg-red-50 dark:hover:bg-red-950/40">
                                        <input type="checkbox" name="deleted_gallery_images[]" value="{{ $galleryImg }}" class="rounded text-red-600 focus:ring-red-500" />
                                        <span>Hapus Foto</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Pilih Berkas Foto Galeri Baru (Maks. 8 Foto)
                    </label>
                    <input type="file" name="gallery_images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full px-3.5 py-2 bg-background dark:bg-background-dark border @error('gallery_images') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-xs text-on-surface dark:text-on-surface-dark file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary dark:file:text-inverse-primary hover:file:bg-primary/20 cursor-pointer" />
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-outline-variant/50 dark:border-outline-dark/50 flex items-center justify-end gap-3">
                <a href="{{ route('admin.cars.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors">
                    Batal
                </a>
                <button id="btnSubmitCar" type="submit" class="px-6 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>{{ $isEdit ? 'Simpan Perubahan Unit' : 'Simpan Unit Mobil Baru' }}</span>
                </button>
            </div>

        </form>

    </div>

</div>
@endsection

