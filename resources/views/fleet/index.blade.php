@extends('layouts.app')

@section('title', 'Daftar Armada Mobil - Indrasari Rental Car')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-8">

    <!-- Page Header & Search Banner -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-2 text-xs font-bold text-primary dark:text-inverse-primary uppercase tracking-wider">
                <span class="material-symbols-outlined text-[16px]">directions_car</span>
                <span>Katalog Unit Tersedia</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface dark:text-on-surface-dark">
                Pilih Armada Mobil Anda
            </h1>
            <p class="text-sm text-text-muted dark:text-text-muted-dark">
                Temukan kendaraan yang tepat untuk kebutuhan perjalanan Anda dengan tarif harian transparan.
            </p>
        </div>

        <!-- Quick Stats Chips -->
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 rounded-xl bg-surface-container dark:bg-surface-container-dark border border-outline-variant/60 dark:border-outline-dark/60 text-center">
                <span class="text-xs text-text-muted dark:text-text-muted-dark block">Total Armada</span>
                <span class="text-lg font-bold text-on-surface dark:text-on-surface-dark">{{ $totalCount }} Unit</span>
            </div>
            <div class="px-4 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-center">
                <span class="text-xs text-emerald-700 dark:text-emerald-400 block font-medium">Siap Disewa</span>
                <span class="text-lg font-bold text-emerald-800 dark:text-emerald-300">{{ $availableCount }} Unit</span>
            </div>
        </div>
    </div>

    <!-- Main Content Layout (Sidebar Filters + Car Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Left Sidebar Filter (Desktop) -->
        <aside class="space-y-6 lg:col-span-1">
            <form method="GET" action="{{ route('fleet.index') }}" class="bg-white dark:bg-surface-dark rounded-2xl p-5 sm:p-6 border border-slate-200 dark:border-slate-800 space-y-6">
                <div class="flex items-center justify-between border-b border-outline-variant/50 dark:border-outline-dark/50 pb-4">
                    <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px] text-primary dark:text-inverse-primary">tune</span>
                        <span>Filter Pencarian</span>
                    </h3>
                    @if(request()->hasAny(['search', 'type', 'transmission', 'fuel_type']))
                        <a href="{{ route('fleet.index') }}" class="text-xs text-red-500 font-semibold hover:underline">
                            Reset
                        </a>
                    @endif
                </div>

                <!-- Search Input -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Cari Merek / Model
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik Avanza, Alphard..." class="w-full pl-9 pr-3 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark placeholder:text-slate-500 dark:placeholder:text-slate-400 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Tipe / Kategori
                    </label>
                    <select name="type" class="w-full py-2 px-3 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="">Semua Kategori</option>
                        <option value="MPV" {{ request('type') === 'MPV' ? 'selected' : '' }}>MPV Keluarga</option>
                        <option value="SUV" {{ request('type') === 'SUV' ? 'selected' : '' }}>SUV Tangguh</option>
                        <option value="Luxury" {{ request('type') === 'Luxury' ? 'selected' : '' }}>Luxury VIP</option>
                        <option value="Sedan" {{ request('type') === 'Sedan' ? 'selected' : '' }}>Sedan Premium</option>
                        <option value="Electric" {{ request('type') === 'Electric' ? 'selected' : '' }}>Listrik (EV)</option>
                    </select>
                </div>

                <!-- Transmission Radio -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Transmisi
                    </label>
                    <div class="space-y-1.5 text-xs text-on-surface dark:text-on-surface-dark">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="transmission" value="" {{ !request('transmission') ? 'checked' : '' }} class="text-primary focus:ring-primary border-slate-300 dark:border-slate-700">
                            <span>Semua Transmisi</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="transmission" value="Automatic" {{ request('transmission') === 'Automatic' ? 'checked' : '' }} class="text-primary focus:ring-primary border-slate-300 dark:border-slate-700">
                            <span>Automatic (AT / CVT)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="transmission" value="Manual" {{ request('transmission') === 'Manual' ? 'checked' : '' }} class="text-primary focus:ring-primary border-slate-300 dark:border-slate-700">
                            <span>Manual (MT)</span>
                        </label>
                    </div>
                </div>

                <!-- Fuel Type -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                        Bahan Bakar
                    </label>
                    <select name="fuel_type" class="w-full py-2 px-3 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <option value="">Semua Bahan Bakar</option>
                        <option value="Bensin" {{ request('fuel_type') === 'Bensin' ? 'selected' : '' }}>Bensin</option>
                        <option value="Diesel" {{ request('fuel_type') === 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Hybrid" {{ request('fuel_type') === 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                        <option value="Listrik" {{ request('fuel_type') === 'Listrik' ? 'selected' : '' }}>Listrik (EV)</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all cursor-pointer flex items-center justify-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">filter_alt</span>
                    <span>Terapkan Filter</span>
                </button>
            </form>
        </aside>

        <!-- Right Vehicle Grid -->
        <main class="lg:col-span-3 space-y-6">
            
            <!-- Filter Toolbar / Active Sort -->
            <div class="flex items-center justify-between text-xs text-text-muted dark:text-text-muted-dark">
                <span>Menampilkan <strong class="text-on-surface dark:text-on-surface-dark font-semibold">{{ $fleets->total() }}</strong> armada mobil</span>
            </div>

            <!-- Cars Cards List -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($fleets as $car)
                    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col group">
                        
                        <!-- Thumbnail Image -->
                        <div class="relative h-48 bg-surface-container dark:bg-surface-container-dark overflow-hidden">
                            <img src="{{ $car->image_url }}" alt="{{ $car->full_name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=600&q=80';" />
                            
                            <div class="absolute top-3 left-3">
                                @if($car->availability === 'available')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/80 dark:text-emerald-300 dark:border-emerald-800 shadow-sm backdrop-blur-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Tersedia
                                    </span>
                                @elseif($car->availability === 'rented')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/80 dark:text-blue-300 dark:border-blue-800 shadow-sm backdrop-blur-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        Disewa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/80 dark:text-amber-300 dark:border-amber-800 shadow-sm backdrop-blur-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Perawatan
                                    </span>
                                @endif
                            </div>

                            @if(!empty($car->images) && count($car->images) > 0)
                                <span class="absolute bottom-2 right-2 px-2 py-0.5 bg-black/60 backdrop-blur-xs text-white text-[10px] font-bold rounded-md flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">photo_camera</span>
                                    <span>+{{ count($car->images) }}</span>
                                </span>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <span class="text-[11px] font-semibold text-primary dark:text-inverse-primary uppercase tracking-wider">{{ $car->type }}</span>
                                <h3 class="font-bold text-base text-on-surface dark:text-on-surface-dark mt-0.5 truncate">{{ $car->brand }} {{ $car->model }}</h3>
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block mt-0.5">Tahun {{ $car->year }} • {{ $car->color }}</span>
                            </div>

                            <!-- Specs Pills -->
                            <div class="grid grid-cols-3 gap-2 py-2 border-y border-outline-variant/40 dark:border-outline-dark/40 text-[11px] text-text-muted dark:text-text-muted-dark">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px] text-primary">airline_seat_recline_normal</span>
                                    <span>{{ $car->seat_capacity }} Kursi</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px] text-primary">settings</span>
                                    <span class="truncate">{{ $car->transmission === 'Automatic' ? 'Matic' : 'Manual' }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px] text-primary">local_gas_station</span>
                                    <span class="truncate">{{ $car->fuel_type }}</span>
                                </div>
                            </div>

                            <!-- Pricing & Action -->
                            <div class="flex items-center justify-between pt-1">
                                <div>
                                    <span class="text-base font-extrabold text-primary dark:text-inverse-primary">Rp {{ number_format((int)$car->price, 0, ',', '.') }}</span>
                                    <span class="text-[10px] text-text-muted dark:text-text-muted-dark">/ hari</span>
                                </div>
                                <a href="{{ route('fleet.show', $car) }}" class="px-3.5 py-1.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all hover:-translate-y-0.5">
                                    Detail & Pesan &rarr;
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-text-muted dark:text-text-muted-dark">
                        <span class="material-symbols-outlined text-5xl text-slate-400">directions_car</span>
                        <p class="font-bold text-sm text-on-surface dark:text-on-surface-dark mt-2">Tidak ada mobil yang sesuai filter</p>
                        <p class="text-xs mt-1">Coba ubah kata kunci pencarian atau reset filter di sisi kiri.</p>
                        <a href="{{ route('fleet.index') }}" class="inline-block mt-4 px-4 py-2 rounded-lg bg-primary text-white text-xs font-semibold">
                            Reset Semua Filter
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pt-6 border-t border-outline-variant/50 dark:border-outline-dark/50 flex items-center justify-between">
                <button class="px-4 py-2 text-xs font-semibold border border-slate-300 dark:border-slate-700 rounded-lg text-text-muted dark:text-text-muted-dark opacity-50 cursor-not-allowed">
                    &larr; Sebelumnya
                </button>
                <div class="flex items-center gap-1">
                    <span class="w-8 h-8 rounded-lg bg-primary text-white text-xs font-bold flex items-center justify-center">1</span>
                    <span class="w-8 h-8 rounded-lg text-xs font-semibold text-text-muted dark:text-text-muted-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark flex items-center justify-center cursor-pointer transition-colors">2</span>
                </div>
                <button class="px-4 py-2 text-xs font-semibold border border-slate-300 dark:border-slate-700 rounded-lg text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors cursor-pointer">
                    Selanjutnya &rarr;
                </button>
            </div>

        </main>
    </div>

</div>
@endsection
