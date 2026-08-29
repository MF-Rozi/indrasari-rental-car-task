<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Indrasari Rental Car')</title>
    
    <!-- Material Symbols Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- Robust Theme Initialization Script -->
    <script>
        (function() {
            const isDark = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            } else {
                document.documentElement.classList.add('light');
                document.documentElement.classList.remove('dark');
            }
        })();

        function toggleTheme() {
            const isDark = document.documentElement.classList.contains('dark');
            const newTheme = isDark ? 'light' : 'dark';
            if (newTheme === 'dark') {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
            }
            localStorage.theme = newTheme;
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-background dark:bg-background-dark text-on-surface dark:text-on-surface-dark font-sans antialiased min-h-screen flex flex-col md:flex-row md:h-screen md:overflow-hidden transition-colors duration-300">
    
    <!-- Admin Sidebar Navigation -->
    <aside id="adminSidebar" class="w-full md:w-64 lg:w-72 bg-white dark:bg-surface-dark border-r border-outline-variant/60 dark:border-outline-dark/60 flex flex-col shrink-0 md:h-full transition-colors duration-300">
        <!-- Brand Header -->
        <div class="h-18 px-6 flex items-center justify-between border-b border-outline-variant/50 dark:border-outline-dark/50">
            <a href="{{ url('/admin') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-primary flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition-transform duration-200">
                    <span class="material-symbols-outlined text-xl">directions_car</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-base leading-tight tracking-tight text-on-surface dark:text-on-surface-dark">INDRASARI</span>
                    <span class="text-[10px] font-semibold tracking-wider text-primary dark:text-inverse-primary uppercase">ADMIN OPERASIONAL</span>
                </div>
            </a>
            <button type="button" onclick="toggleTheme()" class="md:hidden relative w-9 h-9 rounded-xl flex items-center justify-center bg-surface-container/60 dark:bg-surface-container-dark/60 hover:bg-surface-container dark:hover:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark border border-outline-variant/60 dark:border-outline-dark/60 transition-all duration-200 active:scale-90 cursor-pointer overflow-hidden group shadow-xs" title="Ganti Tema">
                <!-- Sun Icon -->
                <span class="material-symbols-outlined text-[20px] text-amber-500 transition-all duration-300 ease-in-out transform rotate-0 scale-100 opacity-100 dark:-rotate-90 dark:scale-0 dark:opacity-0 absolute">
                    light_mode
                </span>
                <!-- Moon Icon -->
                <span class="material-symbols-outlined text-[20px] text-blue-400 transition-all duration-300 ease-in-out transform rotate-90 scale-0 opacity-0 dark:rotate-0 dark:scale-100 dark:opacity-100 absolute">
                    dark_mode
                </span>
            </button>
        </div>

        <!-- Sidebar Menu Links -->
        <div class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <div class="px-3 pb-2 text-[11px] font-semibold tracking-wider text-text-muted dark:text-text-muted-dark uppercase">
                Ringkasan & Kontrol
            </div>

            <a href="{{ url('/admin') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->is('admin') || request()->is('admin/dashboard') ? 'bg-primary text-white shadow-sm shadow-primary/20 font-semibold' : 'text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary' }}">
                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                <span>Dashboard Utama</span>
            </a>

            <div class="pt-3 px-3 pb-2 text-[11px] font-semibold tracking-wider text-text-muted dark:text-text-muted-dark uppercase">
                Manajemen Sistem
            </div>

            <a href="{{ url('/admin/cars') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->is('admin/cars*') ? 'bg-primary text-white shadow-sm shadow-primary/20 font-semibold' : 'text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary' }}">
                <span class="material-symbols-outlined text-[20px]">directions_car</span>
                <span>Kelola Mobil (Armada)</span>
            </a>

            <a href="{{ url('/admin/rentals') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->is('admin/rentals*') ? 'bg-primary text-white shadow-sm font-semibold' : 'text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary' }}">
                <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                <span>Transaksi & Pengembalian</span>
            </a>

            <a href="{{ url('/admin/users') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->is('admin/users*') ? 'bg-primary text-white shadow-sm font-semibold' : 'text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary' }}">
                <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                <span>Kelola Pengguna (SIM A)</span>
            </a>

            <div class="pt-4 px-3 pb-2 text-[11px] font-semibold tracking-wider text-text-muted dark:text-text-muted-dark uppercase">
                Operasional Rental
            </div>

            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors duration-200">
                <span class="material-symbols-outlined text-[20px]">space_dashboard</span>
                <span>Dashboard Pelanggan</span>
            </a>

            <a href="{{ url('/fleet') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors duration-200">
                <span class="material-symbols-outlined text-[20px]">grid_view</span>
                <span>Lihat Katalog Publik</span>
            </a>

            <a href="{{ url('/') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors duration-200">
                <span class="material-symbols-outlined text-[20px]">home</span>
                <span>Halaman Depan</span>
            </a>
        </div>

        <!-- Admin Profile Footer in Sidebar -->
        <div class="p-4 border-t border-outline-variant/50 dark:border-outline-dark/50 bg-surface dark:bg-surface-dark/50 transition-colors duration-300">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-surface-container-high dark:bg-[#1e2f47] flex items-center justify-center font-bold text-primary dark:text-inverse-primary">
                    {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="font-semibold text-sm truncate text-on-surface dark:text-on-surface-dark">{{ auth()->user()->name ?? 'Admin Indrasari' }}</span>
                    <span class="text-xs text-text-muted dark:text-text-muted-dark truncate">{{ auth()->user()->email ?? 'admin@indrasari.co.id' }}</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area with Top Header -->
    <div class="flex-1 flex flex-col min-w-0 md:h-full">
        <!-- Admin Topbar -->
        <header class="h-18 bg-white dark:bg-surface-dark border-b border-outline-variant/60 dark:border-outline-dark/60 px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 transition-colors duration-300">
            <div class="flex items-center gap-3">
                <h1 class="text-lg font-bold text-on-surface dark:text-on-surface-dark">
                    @yield('header_title', 'Dashboard Operasional Pusat')
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <!-- Animated Smooth Theme Switcher Button -->
                <button type="button" onclick="toggleTheme()" class="relative w-9 h-9 rounded-xl flex items-center justify-center bg-surface-container/60 dark:bg-surface-container-dark/60 hover:bg-surface-container dark:hover:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark border border-outline-variant/60 dark:border-outline-dark/60 transition-all duration-200 active:scale-90 cursor-pointer overflow-hidden group shadow-xs" title="Ganti Tema (Terang / Gelap)" aria-label="Ganti Tema">
                    <!-- Sun Icon -->
                    <span class="material-symbols-outlined text-[20px] text-amber-500 transition-all duration-300 ease-in-out transform rotate-0 scale-100 opacity-100 dark:-rotate-90 dark:scale-0 dark:opacity-0 absolute">
                        light_mode
                    </span>
                    <!-- Moon Icon -->
                    <span class="material-symbols-outlined text-[20px] text-blue-400 transition-all duration-300 ease-in-out transform rotate-90 scale-0 opacity-0 dark:rotate-0 dark:scale-100 dark:opacity-100 absolute">
                        dark_mode
                    </span>
                </button>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 text-xs font-semibold text-text-muted dark:text-text-muted-dark border border-slate-300 dark:border-slate-700 rounded-lg hover:border-red-500 hover:text-red-600 dark:hover:border-red-400 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 transition-colors cursor-pointer flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">logout</span>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Dynamic Admin Content Canvas -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-visible md:overflow-y-auto space-y-6">
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs flex items-center gap-3 shadow-xs">
                    <span class="material-symbols-outlined text-[20px] text-emerald-600 dark:text-emerald-400 shrink-0">check_circle</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-xs flex items-center gap-3 shadow-xs">
                    <span class="material-symbols-outlined text-[20px] text-red-600 dark:text-red-400 shrink-0">error</span>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
