@extends('layouts.admin')

@section('title', 'Kelola Pengguna & Verifikasi SIM - Admin Indrasari')
@section('header_title', 'Kelola Pengguna & Pelanggan')

@section('content')
<div class="space-y-6">

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Users -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between transition-colors">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Total Pengguna Terdaftar</span>
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">{{ number_format($stats['total_users']) }} Orang</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">group</span>
            </div>
        </div>

        <!-- Verified SIM A -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between transition-colors">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">SIM A Terverifikasi</span>
                <span class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 block">{{ number_format($stats['verified_users']) }} Akun</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">verified_user</span>
            </div>
        </div>

        <!-- Pending SIM Verification -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between transition-colors {{ $stats['pending_users'] > 0 ? 'ring-2 ring-amber-500/20' : '' }}">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark flex items-center gap-1.5">
                    Menunggu Verifikasi SIM
                    @if($stats['pending_users'] > 0)
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    @endif
                </span>
                <span class="text-2xl font-bold text-amber-600 dark:text-amber-400 block">{{ number_format($stats['pending_users']) }} Pengguna</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">pending_actions</span>
            </div>
        </div>

        <!-- Active Renters -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between transition-colors">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Sedang Menyewa Mobil</span>
                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400 block">{{ number_format($stats['active_renters']) }} Pengguna</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">key</span>
            </div>
        </div>

    </div>

    <!-- Main Table Container -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden p-5 sm:p-6 space-y-4 transition-colors">
        
        <!-- Toolbar & Filter Form -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-4">
            
            <!-- Search Query Input -->
            <div class="relative w-full md:w-80">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">search</span>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $filters['search'] }}" 
                    placeholder="Cari nama, email, no SIM, HP..." 
                    class="w-full pl-10 pr-4 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors" 
                />
            </div>

            <!-- Filter Dropdowns & Submit -->
            <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
                <!-- Verification Status Filter -->
                <select name="verification_status" onchange="this.form.submit()" class="px-3 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs font-semibold text-on-surface dark:text-on-surface-dark outline-none cursor-pointer">
                    <option value="all" {{ $filters['verification_status'] === 'all' ? 'selected' : '' }}>Semua Status SIM A</option>
                    <option value="pending" {{ $filters['verification_status'] === 'pending' ? 'selected' : '' }}>⏳ Menunggu Verifikasi (Pending)</option>
                    <option value="verified" {{ $filters['verification_status'] === 'verified' ? 'selected' : '' }}>✓ SIM A Terverifikasi</option>
                    <option value="rejected" {{ $filters['verification_status'] === 'rejected' ? 'selected' : '' }}>✕ Ditolak (Rejected)</option>
                </select>

                <!-- Role Filter -->
                <select name="role" onchange="this.form.submit()" class="px-3 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs font-semibold text-on-surface dark:text-on-surface-dark outline-none cursor-pointer">
                    <option value="all" {{ $filters['role'] === 'all' ? 'selected' : '' }}>Semua Peran (Role)</option>
                    <option value="user" {{ $filters['role'] === 'user' ? 'selected' : '' }}>Pelanggan (Customer)</option>
                    <option value="admin" {{ $filters['role'] === 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>

                <button type="submit" class="px-3.5 py-2 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold transition-colors cursor-pointer flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">filter_alt</span>
                    <span>Filter</span>
                </button>

                @if($filters['search'] || $filters['verification_status'] !== 'all' || $filters['role'] !== 'all')
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-text-muted hover:text-red-600 hover:border-red-400 dark:hover:text-red-400 transition-colors flex items-center gap-1" title="Reset Filter">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>

        <!-- Dynamic User Table -->
        <div class="overflow-x-auto border border-outline-variant/60 dark:border-outline-dark/60 rounded-xl">
            <table class="w-full text-left text-xs text-on-surface dark:text-on-surface-dark divide-y divide-outline-variant/60 dark:divide-outline-dark/60">
                <thead class="bg-surface-container dark:bg-surface-container-dark font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                    <tr>
                        <th class="py-3.5 px-4">Pengguna & Peran</th>
                        <th class="py-3.5 px-4">Kontak / WhatsApp</th>
                        <th class="py-3.5 px-4">Nomor SIM A & Legalitas</th>
                        <th class="py-3.5 px-4">Alamat Domisili</th>
                        <th class="py-3.5 px-4">Aktivitas Rental</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/40 dark:divide-outline-dark/40 bg-white dark:bg-surface-dark">
                    @forelse($users as $user)
                        <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors group">
                            
                            <!-- User Identity & Role -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300' : 'bg-primary/10 text-primary dark:bg-primary/20 dark:text-inverse-primary' }} font-bold flex items-center justify-center text-xs shrink-0 shadow-xs">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="space-y-0.5 min-w-0">
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-bold text-on-surface dark:text-on-surface-dark block truncate">{{ $user->name }}</span>
                                            @if($user->role === 'admin')
                                                <span class="px-1.5 py-0.2 rounded text-[9px] font-extrabold bg-purple-100 text-purple-800 dark:bg-purple-950/80 dark:text-purple-300 border border-purple-200 dark:border-purple-800 uppercase tracking-wider">
                                                    ADMIN
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-[11px] text-text-muted dark:text-text-muted-dark block truncate">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Phone / WhatsApp -->
                            <td class="py-3.5 px-4 font-mono">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone_number) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-on-surface dark:text-on-surface-dark hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors" title="Buka WhatsApp">
                                    <span class="material-symbols-outlined text-[15px] text-emerald-600 dark:text-emerald-400">chat</span>
                                    <span>{{ $user->phone_number }}</span>
                                </a>
                            </td>

                            <!-- SIM A Number & Status Badge -->
                            <td class="py-3.5 px-4">
                                <div class="space-y-1">
                                    <span class="font-mono font-bold text-on-surface dark:text-on-surface-dark block">
                                        {{ $user->driving_license_number ?? '-' }}
                                    </span>
                                    
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        @if($user->verification_status === 'verified')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                                                <span class="material-symbols-outlined text-[12px]">verified</span>
                                                Terverifikasi
                                            </span>
                                        @elseif($user->verification_status === 'pending')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/70 dark:text-amber-300 dark:border-amber-800 animate-pulse">
                                                <span class="material-symbols-outlined text-[12px]">hourglass_top</span>
                                                Menunggu Verifikasi
                                            </span>
                                        @elseif($user->verification_status === 'rejected')
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-800 border border-red-200 dark:bg-red-950/70 dark:text-red-300 dark:border-red-800">
                                                <span class="material-symbols-outlined text-[12px]">cancel</span>
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                                Belum Ada SIM
                                            </span>
                                        @endif

                                        @if($user->driving_license_expiry_date)
                                            <span class="text-[10px] text-text-muted dark:text-text-muted-dark">
                                                Exp: {{ $user->driving_license_expiry_date->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Address -->
                            <td class="py-3.5 px-4 max-w-xs truncate text-text-muted dark:text-text-muted-dark" title="{{ $user->address }}">
                                {{ $user->address ?? '-' }}
                            </td>

                            <!-- Rental Activity -->
                            <td class="py-3.5 px-4">
                                @if($user->active_rentals_count > 0)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/70 dark:text-blue-300 dark:border-blue-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                        {{ $user->active_rentals_count }} Sewa Aktif
                                    </span>
                                @else
                                    <span class="text-text-muted dark:text-text-muted-dark text-[11px] block">Tidak Ada Sewa Aktif</span>
                                @endif
                                <span class="text-[11px] text-text-muted dark:text-text-muted-dark block mt-0.5">
                                    Total {{ $user->total_rentals_count }} Transaksi
                                </span>
                            </td>

                            <!-- Action -->
                            <td class="py-3.5 px-4 text-right">
                                <button 
                                    type="button" 
                                    onclick='openUserInspectionModal(@json($user))' 
                                    class="px-2.5 py-1 rounded-lg {{ $user->verification_status === 'pending' ? 'bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-xs' : 'bg-surface-container dark:bg-surface-container-dark hover:bg-primary/10 hover:text-primary dark:hover:text-inverse-primary font-semibold text-on-surface dark:text-on-surface-dark' }} transition-colors cursor-pointer inline-flex items-center gap-1"
                                >
                                    <span class="material-symbols-outlined text-[16px]">{{ $user->verification_status === 'pending' ? 'verified' : 'visibility' }}</span>
                                    <span>{{ $user->verification_status === 'pending' ? 'Verifikasi SIM' : 'Detail' }}</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="w-12 h-12 rounded-2xl bg-surface-container dark:bg-[#132238] flex items-center justify-center mx-auto text-text-muted mb-3">
                                    <span class="material-symbols-outlined text-2xl">person_off</span>
                                </div>
                                <h4 class="font-bold text-sm text-on-surface dark:text-on-surface-dark">Tidak Ada Data Pengguna</h4>
                                <p class="text-xs text-text-muted dark:text-text-muted-dark mt-1">Tidak ditemukan pengguna yang cocok dengan kriteria filter saat ini.</p>
                                @if($filters['search'] || $filters['verification_status'] !== 'all' || $filters['role'] !== 'all')
                                    <a href="{{ route('admin.users.index') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-primary hover:underline">
                                        Reset Semua Filter
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-2">
            {{ $users->links() }}
        </div>

    </div>

</div>

<!-- High-Craft SIM A Document Inspection & User Dossier Modal -->
<div id="userInspectionModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white dark:bg-[#0c182a] rounded-2xl max-w-2xl w-full border border-slate-200 dark:border-slate-700/80 shadow-2xl overflow-hidden flex flex-col max-h-[92vh] transition-all transform duration-300">
        
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-outline-variant/60 dark:border-outline-dark/60 bg-slate-50 dark:bg-[#07111e] flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div id="modalUserAvatar" class="w-10 h-10 rounded-xl bg-primary text-white font-bold flex items-center justify-center text-sm shadow-xs">
                    US
                </div>
                <div>
                    <h3 id="modalUserName" class="font-bold text-base text-on-surface dark:text-on-surface-dark">
                        Nama Pengguna
                    </h3>
                    <span id="modalUserEmail" class="text-xs text-text-muted dark:text-text-muted-dark block">
                        email@domain.com
                    </span>
                </div>
            </div>
            <button type="button" onclick="closeUserInspectionModal()" class="p-1.5 rounded-lg text-text-muted dark:text-text-muted-dark hover:text-on-surface dark:hover:text-on-surface-dark hover:bg-surface-container dark:hover:bg-[#152336] transition-colors cursor-pointer" title="Tutup Modal">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <!-- Modal Body (Scrollable Bento) -->
        <div class="p-6 overflow-y-auto space-y-6 flex-1 text-xs">
            
            <!-- Section 1: Physical Driving License (SIM A) Document Card -->
            <div class="p-4 rounded-xl bg-surface-container dark:bg-[#132238] border border-outline-variant/40 dark:border-slate-700/60 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-xs text-on-surface dark:text-on-surface-dark flex items-center gap-1.5 uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[18px] text-primary">badge</span>
                        Dokumen Fisik SIM A (Surat Izin Mengemudi)
                    </span>
                    <span id="modalStatusPill" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold">
                        Status
                    </span>
                </div>

                <!-- SIM Photo Stage -->
                <div class="relative w-full h-52 sm:h-64 rounded-xl overflow-hidden bg-slate-900 border border-slate-300 dark:border-slate-700 flex items-center justify-center group">
                    <img id="modalSimImg" src="" alt="Foto SIM A" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                    
                    <div id="modalNoSimNotice" class="hidden flex-col items-center justify-center text-slate-400 gap-2 p-6 text-center">
                        <span class="material-symbols-outlined text-4xl">no_photography</span>
                        <span class="font-medium text-xs">Pengguna belum mengunggah foto fisik SIM A</span>
                    </div>

                    <a id="modalSimFullLink" href="#" target="_blank" rel="noopener noreferrer" class="absolute bottom-3 right-3 px-3 py-1.5 rounded-lg bg-black/70 hover:bg-black/90 text-white text-[11px] font-semibold backdrop-blur-sm flex items-center gap-1 transition-colors">
                        <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                        <span>Buka Resolusi Penuh</span>
                    </a>
                </div>

                <!-- SIM Attributes Breakdown -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div class="p-2.5 rounded-lg bg-white dark:bg-[#0c182a] border border-slate-200 dark:border-slate-800">
                        <span class="text-text-muted dark:text-text-muted-dark block text-[10px]">Nomor SIM A:</span>
                        <strong id="modalSimNumber" class="font-mono text-sm text-primary dark:text-inverse-primary block mt-0.5">-</strong>
                    </div>
                    <div class="p-2.5 rounded-lg bg-white dark:bg-[#0c182a] border border-slate-200 dark:border-slate-800">
                        <span class="text-text-muted dark:text-text-muted-dark block text-[10px]">Masa Berlaku SIM A:</span>
                        <strong id="modalSimExpiry" class="font-mono text-sm text-on-surface dark:text-on-surface-dark block mt-0.5">-</strong>
                    </div>
                </div>
            </div>

            <!-- Section 2: Contact & Domicile Information -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-surface-container dark:bg-[#132238] border border-outline-variant/40 dark:border-slate-700/60 space-y-1.5">
                    <span class="text-text-muted dark:text-text-muted-dark font-semibold text-[11px] block">Nomor WhatsApp / HP:</span>
                    <strong id="modalUserPhone" class="font-mono text-sm text-on-surface dark:text-on-surface-dark block">-</strong>
                    <a id="modalWaBtn" href="#" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 hover:underline text-[11px] font-semibold mt-1">
                        <span class="material-symbols-outlined text-[14px]">chat</span>
                        <span>Kirim Pesan WhatsApp</span>
                    </a>
                </div>

                <div class="p-4 rounded-xl bg-surface-container dark:bg-[#132238] border border-outline-variant/40 dark:border-slate-700/60 space-y-1.5">
                    <span class="text-text-muted dark:text-text-muted-dark font-semibold text-[11px] block">Peran / Role Akun:</span>
                    <strong id="modalUserRole" class="text-sm font-bold text-on-surface dark:text-on-surface-dark block uppercase">-</strong>
                    <span id="modalUserCreated" class="text-text-muted dark:text-text-muted-dark text-[11px] block">-</span>
                </div>
            </div>

            <!-- Section 3: Full Address -->
            <div class="p-4 rounded-xl bg-surface-container dark:bg-[#132238] border border-outline-variant/40 dark:border-slate-700/60 space-y-1.5">
                <span class="text-text-muted dark:text-text-muted-dark font-semibold text-[11px] block">Alamat Domisili Lengkap:</span>
                <p id="modalUserAddress" class="text-on-surface dark:text-on-surface-dark leading-relaxed font-medium">
                    -
                </p>
            </div>

            <!-- Section 4: Role Assignment Form -->
            <div class="p-4 rounded-xl bg-surface-container dark:bg-[#132238] border border-outline-variant/40 dark:border-slate-700/60">
                <form id="modalRoleForm" method="POST" action="" class="flex items-center justify-between gap-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <span class="font-bold text-xs text-on-surface dark:text-on-surface-dark block">Ubah Peran Pengguna</span>
                        <span class="text-text-muted dark:text-text-muted-dark text-[11px] block">Beri hak akses Administrator atau Pelanggan Biasa</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <select name="role" id="modalRoleSelect" class="px-3 py-1.5 bg-white dark:bg-[#0c182a] border border-slate-300 dark:border-slate-700 rounded-lg text-xs font-semibold text-on-surface dark:text-on-surface-dark outline-none cursor-pointer">
                            <option value="user">Pelanggan (User)</option>
                            <option value="admin">Administrator (Admin)</option>
                        </select>
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white dark:bg-slate-700 dark:hover:bg-slate-600 text-xs font-semibold transition-colors cursor-pointer">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Modal Footer Actions -->
        <div class="px-6 py-4 border-t border-outline-variant/60 dark:border-outline-dark/60 bg-slate-50 dark:bg-[#07111e] flex flex-wrap items-center justify-between gap-3 shrink-0">
            <button type="button" onclick="closeUserInspectionModal()" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-[#152336] transition-colors cursor-pointer">
                Tutup
            </button>

            <div class="flex items-center gap-2.5">
                <!-- Reject Action Form -->
                <form id="modalRejectForm" method="POST" action="" onsubmit="return confirm('Apakah Anda yakin ingin menolak verifikasi SIM A pengguna ini?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 rounded-lg bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 hover:bg-red-600 hover:text-white dark:hover:bg-red-600 dark:hover:text-white text-xs font-semibold transition-all cursor-pointer flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">cancel</span>
                        <span>Tolak Verifikasi</span>
                    </button>
                </form>

                <!-- Verify Action Form -->
                <form id="modalVerifyForm" method="POST" action="" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI dan memverifikasi SIM A pengguna ini?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-5 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition-all cursor-pointer flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        <span>Setujui & Verifikasi SIM A</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function openUserInspectionModal(user) {
        document.getElementById('modalUserName').innerText = user.name || 'Pengguna';
        document.getElementById('modalUserEmail').innerText = user.email || '-';
        document.getElementById('modalUserAvatar').innerText = (user.name || 'US').split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase();
        
        // WhatsApp & Phone
        document.getElementById('modalUserPhone').innerText = user.phone_number || '-';
        const cleanPhone = (user.phone_number || '').replace(/[^0-9]/g, '');
        document.getElementById('modalWaBtn').href = cleanPhone ? `https://wa.me/${cleanPhone}` : '#';
        
        // Address & Account metadata
        document.getElementById('modalUserAddress').innerText = user.address || 'Alamat belum dilengkapi.';
        document.getElementById('modalUserRole').innerText = user.role === 'admin' ? 'Administrator' : 'Pelanggan Biasa';
        
        if (user.created_at) {
            const createdDate = new Date(user.created_at);
            document.getElementById('modalUserCreated').innerText = `Terdaftar sejak ${createdDate.toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' })}`;
        } else {
            document.getElementById('modalUserCreated').innerText = '';
        }

        // SIM A Data
        document.getElementById('modalSimNumber').innerText = user.driving_license_number || 'Belum diisi';
        if (user.driving_license_expiry_date) {
            const expDate = new Date(user.driving_license_expiry_date);
            document.getElementById('modalSimExpiry').innerText = expDate.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
        } else {
            document.getElementById('modalSimExpiry').innerText = '-';
        }

        // Status Badge Pill
        const statusPill = document.getElementById('modalStatusPill');
        if (user.verification_status === 'verified') {
            statusPill.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800';
            statusPill.innerHTML = '<span class="material-symbols-outlined text-[12px]">verified</span> Terverifikasi';
        } else if (user.verification_status === 'pending') {
            statusPill.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/70 dark:text-amber-300 dark:border-amber-800';
            statusPill.innerHTML = '<span class="material-symbols-outlined text-[12px]">hourglass_top</span> Menunggu Verifikasi';
        } else if (user.verification_status === 'rejected') {
            statusPill.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-800 border border-red-200 dark:bg-red-950/70 dark:text-red-300 dark:border-red-800';
            statusPill.innerHTML = '<span class="material-symbols-outlined text-[12px]">cancel</span> Ditolak';
        } else {
            statusPill.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300';
            statusPill.innerHTML = 'Belum Ada SIM';
        }

        // SIM Photo
        const simImg = document.getElementById('modalSimImg');
        const noSimNotice = document.getElementById('modalNoSimNotice');
        const simFullLink = document.getElementById('modalSimFullLink');

        const photoUrl = user.driving_license_photo_url || (user.driving_license_photo && user.driving_license_photo.startsWith('http') ? user.driving_license_photo : null);

        if (photoUrl) {
            simImg.src = photoUrl;
            simImg.classList.remove('hidden');
            noSimNotice.classList.add('hidden');
            simFullLink.href = photoUrl;
            simFullLink.classList.remove('hidden');
        } else {
            simImg.classList.add('hidden');
            noSimNotice.classList.remove('hidden');
            simFullLink.classList.add('hidden');
        }

        // Form Action Endpoints
        document.getElementById('modalVerifyForm').action = `/admin/users/${user.id}/verify`;
        document.getElementById('modalRejectForm').action = `/admin/users/${user.id}/reject`;
        document.getElementById('modalRoleForm').action = `/admin/users/${user.id}/role`;
        document.getElementById('modalRoleSelect').value = user.role || 'user';

        // Display Modal
        document.getElementById('userInspectionModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeUserInspectionModal() {
        document.getElementById('userInspectionModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Keyboard ESC to close modal
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeUserInspectionModal();
        }
    });
</script>
@endpush
