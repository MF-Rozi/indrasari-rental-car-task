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
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark mt-1 block">{{ $totalCount }} Unit</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">directions_car</span>
            </div>
        </div>

        <!-- Stat 2: Tersedia -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-emerald-700 dark:text-emerald-400 block font-medium">Tersedia (Ready)</span>
                <span class="text-2xl font-bold text-emerald-800 dark:text-emerald-300 mt-1 block">{{ $availableCount }} Unit</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">check_circle</span>
            </div>
        </div>

        <!-- Stat 3: Sedang Disewa -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-blue-700 dark:text-blue-400 block font-medium">Sedang Disewa</span>
                <span class="text-2xl font-bold text-blue-800 dark:text-blue-300 mt-1 block">{{ $rentedCount }} Unit</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">key</span>
            </div>
        </div>

        <!-- Stat 4: Perawatan -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-amber-700 dark:text-amber-400 block font-medium">Dalam Perawatan</span>
                <span class="text-2xl font-bold text-amber-800 dark:text-amber-300 mt-1 block">{{ $maintenanceCount }} Unit</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-[22px]">build</span>
            </div>
        </div>
    </div>

    <!-- Table Container Section -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden space-y-4 p-5 sm:p-6">
        
        <!-- Table Toolbar & Filters -->
        <form method="GET" action="{{ route('admin.cars.index') }}" class="space-y-3">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                <div class="flex-1 flex flex-wrap sm:flex-nowrap items-center gap-2.5">
                    <div class="relative flex-1 min-w-[200px]">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor plat, merek, atau model..." class="w-full pl-9 pr-3 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
                    </div>

                    <select name="type" onchange="this.form.submit()" class="py-2 px-3 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="">Semua Kategori</option>
                        <option value="MPV" {{ request('type') === 'MPV' ? 'selected' : '' }}>MPV</option>
                        <option value="SUV" {{ request('type') === 'SUV' ? 'selected' : '' }}>SUV</option>
                        <option value="Luxury" {{ request('type') === 'Luxury' ? 'selected' : '' }}>Luxury VIP</option>
                        <option value="Sedan" {{ request('type') === 'Sedan' ? 'selected' : '' }}>Sedan</option>
                        <option value="Electric" {{ request('type') === 'Electric' ? 'selected' : '' }}>Listrik (EV)</option>
                    </select>

                    <select name="availability" onchange="this.form.submit()" class="py-2 px-3 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="">Semua Status</option>
                        <option value="available" {{ request('availability') === 'available' ? 'selected' : '' }}>Tersedia (Ready)</option>
                        <option value="rented" {{ request('availability') === 'rented' ? 'selected' : '' }}>Sedang Disewa</option>
                        <option value="maintenance" {{ request('availability') === 'maintenance' ? 'selected' : '' }}>Dalam Perawatan</option>
                    </select>

                    @if(request()->hasAny(['search', 'type', 'availability', 'transmission']))
                        <a href="{{ route('admin.cars.index') }}" class="py-2 px-3 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-text-muted hover:text-red-500 transition-colors flex items-center gap-1" title="Reset Filter">
                            <span class="material-symbols-outlined text-[16px]">close</span>
                            <span>Reset</span>
                        </a>
                    @endif
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.cars.create') }}" class="py-2 px-4 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        <span>Tambah Mobil Baru</span>
                    </a>
                </div>
            </div>
        </form>

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
                    @forelse($fleets as $car)
                        <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                            <td class="py-3 px-4 flex items-center gap-3">
                                <div class="relative w-12 h-10 shrink-0">
                                    <img src="{{ $car->image_url }}" alt="{{ $car->full_name }}" class="w-12 h-10 object-cover rounded-lg border border-slate-200 dark:border-slate-800" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=120&q=80';" />
                                    @if(!empty($car->images) && count($car->images) > 0)
                                        <span class="absolute -bottom-1 -right-1 px-1 bg-primary text-white text-[9px] font-bold rounded-full border border-white dark:border-surface-dark" title="{{ count($car->images) }} Foto Galeri">
                                            +{{ count($car->images) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <span class="font-bold text-on-surface dark:text-on-surface-dark block truncate">{{ $car->brand }} {{ $car->model }}</span>
                                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark">Tahun {{ $car->year }} • {{ $car->seat_capacity }} Kursi • {{ $car->fuel_type }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 font-mono font-semibold text-primary dark:text-inverse-primary">
                                {{ $car->plate_number }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="block font-medium">{{ $car->type }}</span>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark">{{ $car->transmission }}</span>
                            </td>
                            <td class="py-3 px-4 font-bold">
                                Rp {{ number_format((int)$car->price, 0, ',', '.') }} <span class="text-[10px] text-text-muted dark:text-text-muted-dark font-normal">/ hari</span>
                            </td>
                            <td class="py-3 px-4">
                                <form action="{{ route('admin.cars.status', $car) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="availability" onchange="this.form.submit()" class="text-[11px] font-bold py-1 px-2.5 rounded-full border cursor-pointer outline-none transition-colors
                                        @if($car->availability === 'available') bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800
                                        @elseif($car->availability === 'rented') bg-blue-50 text-blue-800 border-blue-200 dark:bg-blue-950/70 dark:text-blue-300 dark:border-blue-800
                                        @else bg-amber-50 text-amber-800 border-amber-200 dark:bg-amber-950/70 dark:text-amber-300 dark:border-amber-800 @endif">
                                        <option value="available" {{ $car->availability === 'available' ? 'selected' : '' }}>● Tersedia</option>
                                        <option value="rented" {{ $car->availability === 'rented' ? 'selected' : '' }}>● Disewa</option>
                                        <option value="maintenance" {{ $car->availability === 'maintenance' ? 'selected' : '' }}>● Servis / Perawatan</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button" onclick="openCarDetailModal({{ json_encode([
                                        'id' => $car->id,
                                        'brand' => $car->brand,
                                        'model' => $car->model,
                                        'full_name' => $car->full_name,
                                        'plate_number' => $car->plate_number,
                                        'type' => $car->type,
                                        'year' => $car->year,
                                        'color' => $car->color,
                                        'transmission' => $car->transmission,
                                        'fuel_type' => $car->fuel_type,
                                        'seat_capacity' => $car->seat_capacity,
                                        'price' => (int)$car->price,
                                        'price_formatted' => number_format((int)$car->price, 0, ',', '.'),
                                        'availability' => $car->availability,
                                        'image_url' => $car->image_url,
                                        'gallery_urls' => $car->gallery_urls,
                                        'total_rentals' => $car->total_rentals_count ?? 0,
                                        'active_rentals' => $car->active_rentals_count ?? 0,
                                        'edit_url' => route('admin.cars.edit', $car),
                                        'public_url' => route('fleet.show', $car),
                                        'status_url' => route('admin.cars.status', $car),
                                    ]) }})" class="p-1.5 rounded-lg text-text-muted dark:text-text-muted-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors cursor-pointer" title="Lihat Detail Mobil (Dossier)">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </button>
                                    <a href="{{ route('admin.cars.edit', $car) }}" class="p-1.5 rounded-lg text-text-muted dark:text-text-muted-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors" title="Edit Unit Mobil">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                    <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan/menghapus unit mobil {{ $car->plate_number }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-text-muted dark:text-text-muted-dark hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 transition-colors cursor-pointer" title="Hapus / Nonaktifkan">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-text-muted dark:text-text-muted-dark">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-4xl text-slate-400">directions_car</span>
                                    <p class="font-medium text-xs">Tidak ada unit mobil yang sesuai dengan pencarian atau filter.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($fleets->hasPages())
            <div class="pt-2">
                {{ $fleets->links() }}
            </div>
        @endif

    </div>

</div>

<!-- High-Craft Car Detail Modal Dossier -->
<div id="carDetailModal" class="fixed inset-0 z-50 bg-slate-900/60 dark:bg-black/80 backdrop-blur-xs hidden items-center justify-center p-4 sm:p-6 overflow-y-auto transition-opacity duration-200" aria-modal="true" role="dialog">
    <div id="modalContainer" class="relative w-full max-w-4xl bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden my-auto max-h-[92vh] flex flex-col transform scale-95 opacity-0 transition-all duration-200">
        
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-outline-variant/60 dark:border-outline-dark/60 flex items-center justify-between bg-surface-container/40 dark:bg-surface-container-dark/40 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary dark:text-inverse-primary flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-[22px]">directions_car</span>
                </div>
                <div>
                    <h3 id="modalTitle" class="text-base font-bold text-on-surface dark:text-on-surface-dark">
                        Detail Kendaraan
                    </h3>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span id="modalPlateBadge" class="px-2 py-0.5 rounded font-mono font-bold text-xs bg-slate-100 dark:bg-slate-800 text-primary dark:text-inverse-primary border border-slate-200 dark:border-slate-700">
                            B 0000 XXX
                        </span>
                        <span id="modalCategoryBadge" class="text-xs text-text-muted dark:text-text-muted-dark">
                            MPV • Automatic
                        </span>
                    </div>
                </div>
            </div>

            <button type="button" onclick="closeCarDetailModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-text-muted dark:text-text-muted-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-on-surface dark:hover:text-on-surface-dark transition-colors cursor-pointer" aria-label="Tutup Modal">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Modal Body (Scrollable) -->
        <div class="p-6 overflow-y-auto space-y-6 flex-1">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                
                <!-- Left 5 Cols: Visual Stage & Gallery -->
                <div class="md:col-span-5 space-y-4">
                    <div class="relative h-52 sm:h-56 bg-surface-container dark:bg-surface-container-dark rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm group">
                        <img id="modalMainImg" src="" alt="Preview Mobil" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                        <div id="modalStatusBadgeOverlay" class="absolute top-3 left-3">
                            <!-- Injected via JS -->
                        </div>
                    </div>

                    <!-- Gallery Thumbnails -->
                    <div id="modalGalleryWrapper" class="space-y-2">
                        <span class="text-[11px] font-semibold text-text-muted dark:text-text-muted-dark block">
                            Foto Dokumentasi & Galeri:
                        </span>
                        <div id="modalGalleryList" class="flex items-center gap-2 overflow-x-auto pb-1.5 scrollbar-thin">
                            <!-- Injected via JS -->
                        </div>
                    </div>

                    <!-- Rental Metrics Quick Bento -->
                    <div class="p-4 rounded-xl bg-surface-container/60 dark:bg-surface-container-dark/60 border border-outline-variant/60 dark:border-outline-dark/60 space-y-2.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-text-muted dark:text-text-muted-dark">Total Transaksi Sewa:</span>
                            <span id="modalTotalRentals" class="font-bold text-on-surface dark:text-on-surface-dark">0 Kali</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-text-muted dark:text-text-muted-dark">Status Operasional Saat Ini:</span>
                            <span id="modalActiveRentalStatus" class="font-semibold text-emerald-600 dark:text-emerald-400">Tersedia</span>
                        </div>
                    </div>
                </div>

                <!-- Right 7 Cols: Full Specifications & Status Controls -->
                <div class="md:col-span-7 space-y-5">
                    
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-primary dark:text-inverse-primary">Spesifikasi Detail</span>
                        <h4 class="text-lg font-bold text-on-surface dark:text-on-surface-dark mt-0.5">
                            Identitas & Kapasitas Unit
                        </h4>
                    </div>

                    <!-- Specs 2x3 Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <div class="p-3 rounded-xl bg-surface-container/50 dark:bg-surface-container-dark/50 border border-outline-variant/40 dark:border-outline-dark/40 space-y-0.5">
                            <span class="text-[10px] text-text-muted dark:text-text-muted-dark block">Merek & Model</span>
                            <span id="modalSpecBrand" class="text-xs font-bold text-on-surface dark:text-on-surface-dark block truncate">-</span>
                        </div>
                        <div class="p-3 rounded-xl bg-surface-container/50 dark:bg-surface-container-dark/50 border border-outline-variant/40 dark:border-outline-dark/40 space-y-0.5">
                            <span class="text-[10px] text-text-muted dark:text-text-muted-dark block">Tahun Pembuatan</span>
                            <span id="modalSpecYear" class="text-xs font-bold text-on-surface dark:text-on-surface-dark block">-</span>
                        </div>
                        <div class="p-3 rounded-xl bg-surface-container/50 dark:bg-surface-container-dark/50 border border-outline-variant/40 dark:border-outline-dark/40 space-y-0.5">
                            <span class="text-[10px] text-text-muted dark:text-text-muted-dark block">Warna Kendaraan</span>
                            <span id="modalSpecColor" class="text-xs font-bold text-on-surface dark:text-on-surface-dark block truncate">-</span>
                        </div>
                        <div class="p-3 rounded-xl bg-surface-container/50 dark:bg-surface-container-dark/50 border border-outline-variant/40 dark:border-outline-dark/40 space-y-0.5">
                            <span class="text-[10px] text-text-muted dark:text-text-muted-dark block">Transmisi</span>
                            <span id="modalSpecTransmission" class="text-xs font-bold text-on-surface dark:text-on-surface-dark block">-</span>
                        </div>
                        <div class="p-3 rounded-xl bg-surface-container/50 dark:bg-surface-container-dark/50 border border-outline-variant/40 dark:border-outline-dark/40 space-y-0.5">
                            <span class="text-[10px] text-text-muted dark:text-text-muted-dark block">Bahan Bakar</span>
                            <span id="modalSpecFuel" class="text-xs font-bold text-on-surface dark:text-on-surface-dark block">-</span>
                        </div>
                        <div class="p-3 rounded-xl bg-surface-container/50 dark:bg-surface-container-dark/50 border border-outline-variant/40 dark:border-outline-dark/40 space-y-0.5">
                            <span class="text-[10px] text-text-muted dark:text-text-muted-dark block">Kapasitas Kursi</span>
                            <span id="modalSpecSeats" class="text-xs font-bold text-on-surface dark:text-on-surface-dark block">- Orang</span>
                        </div>
                    </div>

                    <!-- Pricing & Status Quick Update Banner -->
                    <div class="p-4 rounded-xl bg-blue-50/70 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block font-medium">Tarif Sewa Harian</span>
                            <div class="flex items-baseline gap-1 mt-0.5">
                                <span id="modalSpecPrice" class="text-xl font-extrabold text-primary dark:text-inverse-primary">Rp 0</span>
                                <span class="text-xs text-text-muted dark:text-text-muted-dark">/ 24 Jam</span>
                            </div>
                        </div>

                        <!-- Modal Quick Status Form -->
                        <form id="modalStatusForm" method="POST" action="" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <label class="text-xs font-semibold text-on-surface dark:text-on-surface-dark whitespace-nowrap">Status:</label>
                            <select id="modalAvailabilitySelect" name="availability" onchange="this.form.submit()" class="text-xs font-bold py-1.5 px-3 rounded-lg border bg-white dark:bg-surface-dark border-slate-300 dark:border-slate-700 outline-none cursor-pointer">
                                <option value="available">● Tersedia</option>
                                <option value="rented">● Sedang Disewa</option>
                                <option value="maintenance">● Servis / Perawatan</option>
                            </select>
                        </form>
                    </div>

                </div>

            </div>
        </div>

        <!-- Modal Footer Actions -->
        <div class="px-6 py-4 border-t border-outline-variant/60 dark:border-outline-dark/60 flex items-center justify-between bg-surface-container/30 dark:bg-surface-container-dark/30 shrink-0">
            <a id="modalPublicLink" href="#" target="_blank" class="text-xs font-semibold text-primary dark:text-inverse-primary hover:underline flex items-center gap-1.5">
                <span>Lihat Tampilan Publik</span>
                <span class="material-symbols-outlined text-[16px]">open_in_new</span>
            </a>

            <div class="flex items-center gap-2.5">
                <button type="button" onclick="closeCarDetailModal()" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors cursor-pointer">
                    Tutup
                </button>
                <a id="modalEditLink" href="#" class="px-4 py-2 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">edit</span>
                    <span>Edit Unit Ini</span>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    function openCarDetailModal(car) {
        document.getElementById('modalTitle').innerText = car.brand + ' ' + car.model;
        document.getElementById('modalPlateBadge').innerText = car.plate_number;
        document.getElementById('modalCategoryBadge').innerText = car.type + ' • ' + car.transmission;
        
        // Main Image
        const mainImg = document.getElementById('modalMainImg');
        mainImg.src = car.image_url;
        mainImg.alt = car.full_name;

        // Status Badge Overlay
        let badgeHtml = '';
        if (car.availability === 'available') {
            badgeHtml = '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500 text-white shadow-sm"><span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>Tersedia</span>';
        } else if (car.availability === 'rented') {
            badgeHtml = '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-600 text-white shadow-sm"><span class="w-1.5 h-1.5 rounded-full bg-white"></span>Sedang Disewa</span>';
        } else {
            badgeHtml = '<span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500 text-white shadow-sm"><span class="w-1.5 h-1.5 rounded-full bg-white"></span>Perawatan</span>';
        }
        document.getElementById('modalStatusBadgeOverlay').innerHTML = badgeHtml;

        // Gallery Thumbnails
        const galleryList = document.getElementById('modalGalleryList');
        galleryList.innerHTML = '';
        
        // Add cover as first thumb
        const allPhotos = [car.image_url];
        if (car.gallery_urls && car.gallery_urls.length > 0) {
            car.gallery_urls.forEach(url => {
                if (!allPhotos.includes(url)) allPhotos.push(url);
            });
        }

        if (allPhotos.length > 1) {
            document.getElementById('modalGalleryWrapper').classList.remove('hidden');
            allPhotos.forEach((photoUrl, idx) => {
                const thumbBtn = document.createElement('button');
                thumbBtn.type = 'button';
                thumbBtn.className = 'w-14 h-11 rounded-lg overflow-hidden border border-slate-200 dark:border-slate-700 shrink-0 cursor-pointer hover:opacity-80 transition-opacity focus:ring-2 focus:ring-primary';
                thumbBtn.onclick = () => { mainImg.src = photoUrl; };
                thumbBtn.innerHTML = `<img src="${photoUrl}" class="w-full h-full object-cover" />`;
                galleryList.appendChild(thumbBtn);
            });
        } else {
            document.getElementById('modalGalleryWrapper').classList.add('hidden');
        }

        // Rental Stats
        document.getElementById('modalTotalRentals').innerText = car.total_rentals + ' Kali Transaksi';
        document.getElementById('modalActiveRentalStatus').innerText = car.active_rentals > 0 ? car.active_rentals + ' Transaksi Aktif' : (car.availability === 'available' ? 'Siap Disewa' : 'Tidak Ada Sewa Aktif');

        // Specs
        document.getElementById('modalSpecBrand').innerText = car.brand + ' ' + car.model;
        document.getElementById('modalSpecYear').innerText = car.year;
        document.getElementById('modalSpecColor').innerText = car.color;
        document.getElementById('modalSpecTransmission').innerText = car.transmission;
        document.getElementById('modalSpecFuel').innerText = car.fuel_type;
        document.getElementById('modalSpecSeats').innerText = car.seat_capacity + ' Orang';
        document.getElementById('modalSpecPrice').innerText = 'Rp ' + car.price_formatted;

        // Status form action & select
        document.getElementById('modalStatusForm').action = car.status_url;
        document.getElementById('modalAvailabilitySelect').value = car.availability;

        // Links
        document.getElementById('modalPublicLink').href = car.public_url;
        document.getElementById('modalEditLink').href = car.edit_url;

        // Show Modal
        const modal = document.getElementById('carDetailModal');
        const container = document.getElementById('modalContainer');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeCarDetailModal() {
        const modal = document.getElementById('carDetailModal');
        const container = document.getElementById('modalContainer');
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 150);
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCarDetailModal();
        }
    });

    // Close on clicking backdrop
    document.getElementById('carDetailModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCarDetailModal();
        }
    });
</script>
@endpush


