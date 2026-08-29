@extends('layouts.app')

@section('title', 'Profil Saya - Indrasari Rental Car')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 space-y-8">

    <!-- Profile Header Card -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-primary text-white text-2xl font-bold flex items-center justify-center shadow-md shadow-primary/20 shrink-0">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div class="space-y-1.5">
                <div class="flex flex-wrap items-center gap-2">
                    <h1 class="text-xl sm:text-2xl font-bold text-on-surface dark:text-on-surface-dark">
                        {{ $user->name }}
                    </h1>

                    @if($user->role === 'admin')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200 dark:bg-purple-950/70 dark:text-purple-300 dark:border-purple-800">
                            <span class="material-symbols-outlined text-[14px]">shield_person</span>
                            Administrator
                        </span>
                    @endif

                    @if($user->verification_status === 'verified')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                            <span class="material-symbols-outlined text-[14px]">verified</span>
                            SIM A Terverifikasi
                        </span>
                    @elseif($user->verification_status === 'rejected')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-800 border border-rose-200 dark:bg-rose-950/70 dark:text-rose-300 dark:border-rose-800">
                            <span class="material-symbols-outlined text-[14px]">cancel</span>
                            SIM A Ditolak
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/70 dark:text-amber-300 dark:border-amber-800">
                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                            Menunggu Verifikasi SIM
                        </span>
                    @endif
                </div>
                <p class="text-xs text-text-muted dark:text-text-muted-dark">
                    Member sejak: <strong>{{ $user->created_at ? $user->created_at->format('F Y') : 'Baru' }}</strong> • Total Riwayat Sewa: <strong>{{ $user->rentals_count ?? $user->rentals()->count() }} Kali</strong>
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            @if($user->role === 'admin')
                <a href="{{ url('/admin/dashboard') }}" class="px-4 py-2 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm shadow-primary/20 transition-all flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span>
                    <span>Panel Admin</span>
                </a>
            @else
                <a href="{{ url('/rentals') }}" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark hover:text-primary dark:hover:text-inverse-primary transition-colors">
                    Lihat Sewa Saya
                </a>
            @endif
        </div>
    </div>

    <!-- Main Profile Edit Form Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Left: Legal SIM Card Status & Document Preview -->
        <div class="md:col-span-1 space-y-6">
            <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-xs font-bold text-primary dark:text-inverse-primary uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[18px]">credit_card</span>
                        <span>Legalitas Mengemudi</span>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-2 border border-outline-variant/60 dark:border-outline-dark/60">
                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block font-medium">Nomor SIM A</span>
                    <span class="font-mono text-base font-bold text-on-surface dark:text-on-surface-dark block">{{ $user->driving_license_number ?? 'Belum diisi' }}</span>
                    
                    @if($user->driving_license_expiry_date)
                        @php
                            $isExpired = \Carbon\Carbon::parse($user->driving_license_expiry_date)->isPast();
                        @endphp
                        <div class="flex items-center gap-1.5 text-xs font-semibold pt-1 {{ $isExpired ? 'text-rose-600 dark:text-rose-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                            <span class="material-symbols-outlined text-[16px]">{{ $isExpired ? 'warning' : 'check_circle' }}</span>
                            <span>{{ $isExpired ? 'Kedaluwarsa sejak ' : 'Aktif s/d ' }}{{ $user->driving_license_expiry_date->format('d M Y') }}</span>
                        </div>
                    @endif
                </div>

                <!-- SIM Photo Document View -->
                <div class="space-y-2 pt-2">
                    <span class="text-[11px] font-semibold text-on-surface-variant dark:text-on-surface-variant-dark block">
                        Foto Dokumen SIM A
                    </span>
                    @if($user->driving_license_photo)
                        @php
                            $photoUrl = str_starts_with($user->driving_license_photo, 'http')
                                ? $user->driving_license_photo
                                : (str_starts_with($user->driving_license_photo, 'public/') ? asset($user->driving_license_photo) : asset('storage/' . $user->driving_license_photo));
                        @endphp
                        <div class="relative rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 aspect-video flex items-center justify-center group">
                            <img src="{{ $photoUrl }}" alt="Foto SIM A {{ $user->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1584438784894-089d6a62b8fa?auto=format&fit=crop&w=600&q=80';" />
                            <a href="{{ $photoUrl }}" target="_blank" class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1.5 text-white text-xs font-semibold backdrop-blur-[2px]">
                                <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                                <span>Buka Dokumen</span>
                            </a>
                        </div>
                    @else
                        <div class="p-4 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 text-center text-xs text-text-muted dark:text-text-muted-dark">
                            <span class="material-symbols-outlined text-2xl text-slate-400 block mb-1">image_not_supported</span>
                            <span>Belum ada foto SIM A yang diunggah.</span>
                        </div>
                    @endif
                </div>

                <p class="text-[11px] text-text-muted dark:text-text-muted-dark leading-relaxed pt-1">
                    Pastikan data dan dokumen SIM A selalu valid dan asli agar proses persetujuan reservasi sewa kendaraan berjalan lancar tanpa kendala.
                </p>
            </div>
        </div>

        <!-- Right: Profile Information & Security Forms (Separated) -->
        <div class="md:col-span-2 space-y-8">

            <!-- Card 1: Personal Data & Driver License Form -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[22px]">badge</span>
                        <span>Informasi Data Diri & SIM A</span>
                    </h2>
                    <p class="text-xs text-text-muted dark:text-text-muted-dark mt-0.5">
                        Perbarui data diri, nomor kontak, dan dokumen legalitas mengemudi Anda.
                    </p>
                </div>

                @if($errors->hasAny(['name', 'phone_number', 'email', 'address', 'driving_license_number', 'driving_license_expiry_date', 'driving_license_photo']))
                    <div class="p-4 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-xs space-y-1.5">
                        <div class="font-semibold flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-red-500">error</span>
                            <span>Harap periksa kembali data profil Anda:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-0.5 pl-6">
                            @foreach($errors->getMessages() as $key => $messages)
                                @if(in_array($key, ['name', 'phone_number', 'email', 'address', 'driving_license_number', 'driving_license_expiry_date', 'driving_license_photo']))
                                    @foreach($messages as $msg)
                                        <li>{{ $msg }}</li>
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Nama Lengkap (Sesuai KTP / SIM)
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border @error('name') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Nomor WhatsApp / HP
                            </label>
                            <input type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border @error('phone_number') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Alamat Email
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border @error('email') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Nomor SIM A
                            </label>
                            <input type="text" name="driving_license_number" value="{{ old('driving_license_number', $user->driving_license_number) }}" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border @error('driving_license_number') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark font-mono focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Masa Berlaku SIM A
                            </label>
                            <input type="date" name="driving_license_expiry_date" value="{{ old('driving_license_expiry_date', $user->driving_license_expiry_date ? $user->driving_license_expiry_date->format('Y-m-d') : '') }}" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border @error('driving_license_expiry_date') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Perbarui Foto SIM A (Opsional)
                        </label>
                        <input type="file" name="driving_license_photo" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full px-3.5 py-2 bg-background dark:bg-background-dark border @error('driving_license_photo') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-xs text-on-surface dark:text-on-surface-dark file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary dark:file:text-inverse-primary hover:file:bg-primary/20 cursor-pointer" />
                        <p class="text-[11px] text-text-muted dark:text-text-muted-dark">
                            Biarkan kosong jika tidak ingin mengubah foto dokumen SIM A. (Format JPG, PNG, WEBP, Maks. 2MB).
                        </p>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Alamat Domisili Lengkap
                        </label>
                        <textarea name="address" rows="3" required class="w-full px-3.5 py-2.5 bg-background dark:bg-background-dark border @error('address') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-none transition-all">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <div class="pt-4 border-t border-outline-variant/50 dark:border-outline-dark/50 flex items-center justify-end gap-3">
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            <span>Simpan Data Diri</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Card 2: Security & Password Update Form -->
            <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-on-surface dark:text-on-surface-dark flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[22px]">lock_reset</span>
                        <span>Keamanan & Ganti Kata Sandi</span>
                    </h2>
                    <p class="text-xs text-text-muted dark:text-text-muted-dark mt-0.5">
                        Pastikan akun Anda menggunakan kata sandi yang kuat dan unik untuk keamanan transaksi.
                    </p>
                </div>

                @if(session('success_password'))
                    <div class="p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs flex items-center gap-2.5 shadow-xs">
                        <span class="material-symbols-outlined text-[20px] text-emerald-600 dark:text-emerald-400 shrink-0">check_circle</span>
                        <span>{{ session('success_password') }}</span>
                    </div>
                @endif

                @if($errors->hasAny(['current_password', 'password']))
                    <div class="p-4 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 text-xs space-y-1.5">
                        <div class="font-semibold flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-red-500">error</span>
                            <span>Gagal memperbarui kata sandi:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-0.5 pl-6">
                            @foreach($errors->getMessages() as $key => $messages)
                                @if(in_array($key, ['current_password', 'password']))
                                    @foreach($messages as $msg)
                                        <li>{{ $msg }}</li>
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                            Kata Sandi Saat Ini
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">key</span>
                            <input type="password" name="current_password" required placeholder="Masukkan sandi lama Anda" class="w-full pl-10 pr-4 py-2.5 bg-background dark:bg-background-dark border @error('current_password') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Kata Sandi Baru
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">lock</span>
                                <input type="password" name="password" required placeholder="Min. 8 karakter" class="w-full pl-10 pr-4 py-2.5 bg-background dark:bg-background-dark border @error('password') border-red-500 @else border-slate-300 dark:border-slate-700 @enderror rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                                Konfirmasi Kata Sandi Baru
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">lock_clock</span>
                                <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi baru" class="w-full pl-10 pr-4 py-2.5 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-sm text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-outline-variant/50 dark:border-outline-dark/50 flex items-center justify-end gap-3">
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-slate-900 hover:bg-slate-800 dark:bg-slate-100 dark:hover:bg-white text-white dark:text-slate-900 text-xs font-semibold shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                            <span>Perbarui Kata Sandi</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>
@endsection

