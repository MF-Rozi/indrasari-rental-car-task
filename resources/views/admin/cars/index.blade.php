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
@endsection

