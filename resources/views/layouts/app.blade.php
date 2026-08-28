<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Indrasari Rental Car - Sewa Mobil Terpercaya & Modern')</title>
    
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
<body class="bg-background dark:bg-background-dark text-on-surface dark:text-on-surface-dark font-sans antialiased min-h-screen flex flex-col transition-colors duration-300">
    
    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/95 dark:bg-surface-dark/95 backdrop-blur-md border-b border-outline-variant/70 dark:border-outline-dark/70 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-md shadow-primary/20 group-hover:scale-105 transition-transform duration-200">
                    <span class="material-symbols-outlined text-2xl">directions_car</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-lg leading-tight tracking-tight text-on-surface dark:text-on-surface-dark">INDRASARI</span>
                    <span class="text-[11px] font-semibold tracking-widest text-primary dark:text-inverse-primary uppercase">RENTAL CAR</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-1.5 lg:gap-2">
                <a href="{{ url('/') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->is('/') ? 'text-primary dark:text-inverse-primary bg-surface-container dark:bg-surface-container-dark font-semibold' : 'text-on-surface-variant dark:text-on-surface-variant-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60' }}">
                    Beranda
                </a>
                <a href="{{ url('/fleet') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request()->is('fleet*') ? 'text-primary dark:text-inverse-primary bg-surface-container dark:bg-surface-container-dark font-semibold' : 'text-on-surface-variant dark:text-on-surface-variant-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60' }}">
                    Armada Mobil
                </a>
                <a href="{{ url('/admin/cars') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium transition-colors duration-200 text-on-surface-variant dark:text-on-surface-variant-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60">
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span>
                        Panel Admin
                    </span>
                </a>
            </nav>

            <!-- Actions & User Section -->
            <div class="flex items-center gap-2.5 sm:gap-3">
                
                <!-- Animated Smooth Theme Switcher Button -->
                <button type="button" onclick="toggleTheme()" class="relative w-9 h-9 rounded-xl flex items-center justify-center bg-surface-container/60 dark:bg-surface-container-dark/60 hover:bg-surface-container dark:hover:bg-surface-container-dark text-on-surface-variant dark:text-on-surface-variant-dark border border-outline-variant/60 dark:border-outline-dark/60 transition-all duration-200 active:scale-90 cursor-pointer overflow-hidden group" title="Ganti Tema (Terang / Gelap)" aria-label="Ganti Tema">
                    <!-- Sun Icon (Active in Light Mode) -->
                    <span class="material-symbols-outlined text-[20px] text-amber-500 transition-all duration-300 ease-in-out transform rotate-0 scale-100 opacity-100 dark:-rotate-90 dark:scale-0 dark:opacity-0 absolute">
                        light_mode
                    </span>
                    <!-- Moon Icon (Active in Dark Mode) -->
                    <span class="material-symbols-outlined text-[20px] text-blue-400 transition-all duration-300 ease-in-out transform rotate-90 scale-0 opacity-0 dark:rotate-0 dark:scale-100 dark:opacity-100 absolute">
                        dark_mode
                    </span>
                </button>

                <!-- Auth Buttons -->
                <div class="hidden sm:flex items-center gap-2">
                    <a href="{{ url('/auth?tab=signin') }}" class="px-4 py-2 text-sm font-semibold text-on-surface-variant dark:text-on-surface-variant-dark hover:text-primary dark:hover:text-inverse-primary hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 rounded-lg transition-colors duration-200">
                        Masuk
                    </a>
                    <a href="{{ url('/auth?tab=register') }}" class="px-4 py-2 rounded-lg text-sm font-semibold bg-primary hover:bg-primary-hover text-white shadow-sm shadow-primary/20 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                        Daftar Akun
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button type="button" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')" class="md:hidden p-2 rounded-lg text-on-surface-variant dark:text-on-surface-variant-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors" aria-label="Buka Menu">
                    <span class="material-symbols-outlined text-2xl">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-outline-variant/60 dark:border-outline-dark/60 bg-surface dark:bg-surface-dark px-4 pt-3 pb-5 space-y-2">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors">
                Beranda
            </a>
            <a href="{{ url('/fleet') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors">
                Armada Mobil
            </a>
            <a href="{{ url('/admin/cars') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-primary dark:text-inverse-primary hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors">
                Panel Admin Mobil
            </a>
            <div class="pt-3 border-t border-outline-variant/40 dark:border-outline-dark/40 flex flex-col gap-2">
                <a href="{{ url('/auth?tab=signin') }}" class="w-full text-center py-2.5 text-sm font-semibold border border-slate-300 dark:border-slate-700 text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary rounded-lg transition-colors">
                    Masuk
                </a>
                <a href="{{ url('/auth?tab=register') }}" class="w-full text-center py-2.5 text-sm font-semibold bg-primary hover:bg-primary-hover text-white rounded-lg shadow-sm">
                    Daftar Akun Baru
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Canvas -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-[#071322] border-t border-outline-variant/60 dark:border-outline-dark/60 mt-auto transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">
                <!-- Brand Info -->
                <div class="space-y-4 md:col-span-1">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-primary flex items-center justify-center text-white">
                            <span class="material-symbols-outlined text-xl">directions_car</span>
                        </div>
                        <span class="font-bold text-lg text-on-surface dark:text-on-surface-dark">INDRASARI</span>
                    </div>
                    <p class="text-sm text-text-muted dark:text-text-muted-dark leading-relaxed">
                        Layanan persewaan mobil terpercaya di Indonesia. Menghadirkan armada prima, harga transparan, dan proses booking bebas ribet.
                    </p>
                    <div class="flex items-center gap-3 text-text-muted dark:text-text-muted-dark pt-1">
                        <span class="material-symbols-outlined text-[20px] text-emerald-600 dark:text-emerald-400">verified</span>
                        <span class="text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Terverifikasi & Berasuransi</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div>
                    <h3 class="font-semibold text-sm text-on-surface dark:text-on-surface-dark uppercase tracking-wider mb-4">Navigasi Cepat</h3>
                    <ul class="space-y-2.5 text-sm text-text-muted dark:text-text-muted-dark">
                        <li><a href="{{ url('/') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Beranda</a></li>
                        <li><a href="{{ url('/fleet') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Cari Armada Mobil</a></li>
                        <li><a href="{{ url('/auth?tab=register') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Registrasi Pelanggan</a></li>
                        <li><a href="{{ url('/admin/cars') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Kelola Mobil (Admin)</a></li>
                    </ul>
                </div>

                <!-- Car Categories -->
                <div>
                    <h3 class="font-semibold text-sm text-on-surface dark:text-on-surface-dark uppercase tracking-wider mb-4">Kategori Mobil</h3>
                    <ul class="space-y-2.5 text-sm text-text-muted dark:text-text-muted-dark">
                        <li><a href="{{ url('/fleet') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Keluarga (MPV & Minivan)</a></li>
                        <li><a href="{{ url('/fleet') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Tangguh (SUV 7-Seater)</a></li>
                        <li><a href="{{ url('/fleet') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Eksekutif (Luxury VIP)</a></li>
                        <li><a href="{{ url('/fleet') }}" class="hover:text-primary dark:hover:text-inverse-primary transition-colors">Mobil Listrik (EV Eco)</a></li>
                    </ul>
                </div>

                <!-- Contact & Location -->
                <div>
                    <h3 class="font-semibold text-sm text-on-surface dark:text-on-surface-dark uppercase tracking-wider mb-4">Kontak & Layanan</h3>
                    <ul class="space-y-3 text-sm text-text-muted dark:text-text-muted-dark">
                        <li class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-[18px] text-primary dark:text-inverse-primary shrink-0 mt-0.5">location_on</span>
                            <span>Jl. Indrasari No. 88, Jakarta Selatan, DKI Jakarta 12430</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[18px] text-primary dark:text-inverse-primary shrink-0">call</span>
                            <span>+62 (021) 7890-1234 / 0812-9988-7766</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[18px] text-primary dark:text-inverse-primary shrink-0">mail</span>
                            <span>layanan@indrasari-rental.co.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-outline-variant/50 dark:border-outline-dark/50 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-text-muted dark:text-text-muted-dark">
                <p>&copy; {{ date('Y') }} Indrasari Rental Car. Hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-6">
                    <span class="hover:underline hover:text-primary dark:hover:text-inverse-primary cursor-pointer transition-colors">Kebijakan Privasi</span>
                    <span class="hover:underline hover:text-primary dark:hover:text-inverse-primary cursor-pointer transition-colors">Syarat & Ketentuan Sewa</span>
                    <span class="hover:underline hover:text-primary dark:hover:text-inverse-primary cursor-pointer transition-colors">Pusat Bantuan</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
