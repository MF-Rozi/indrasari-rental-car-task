@extends('layouts.admin')

@section('title', 'Kelola Pengguna & Verifikasi SIM - Admin Indrasari')
@section('header_title', 'Kelola Pengguna & Pelanggan')

@section('content')
<div class="space-y-6">

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Users -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Total Pengguna</span>
                <span class="text-2xl font-bold text-on-surface dark:text-on-surface-dark block">142 Orang</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-primary dark:text-inverse-primary flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">group</span>
            </div>
        </div>

        <!-- Verified SIM A -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">SIM A Terverifikasi</span>
                <span class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 block">128 Pengguna</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">verified_user</span>
            </div>
        </div>

        <!-- Active Renters -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Sedang Menyewa</span>
                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400 block">2 Pengguna</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">key</span>
            </div>
        </div>

        <!-- Pending SIM Verification -->
        <div class="bg-white dark:bg-surface-dark p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-text-muted dark:text-text-muted-dark">Menunggu Verifikasi</span>
                <span class="text-2xl font-bold text-amber-600 dark:text-amber-400 block">14 Pengguna</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">pending_actions</span>
            </div>
        </div>

    </div>

    <!-- Main Table Container -->
    <div class="bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden p-5 sm:p-6 space-y-4">
        
        <!-- Toolbar & Filter -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-80">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-text-muted dark:text-text-muted-dark text-[18px]">search</span>
                <input type="text" placeholder="Cari nama, email, no SIM, HP..." class="w-full pl-10 pr-4 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs text-on-surface dark:text-on-surface-dark focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none" />
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select class="px-3 py-2 bg-background dark:bg-background-dark border border-slate-300 dark:border-slate-700 rounded-lg text-xs font-semibold text-on-surface dark:text-on-surface-dark outline-none">
                    <option value="all">Semua Status SIM A</option>
                    <option value="verified">SIM A Terverifikasi</option>
                    <option value="pending">Menunggu Verifikasi</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto border border-outline-variant/60 dark:border-outline-dark/60 rounded-xl">
            <table class="w-full text-left text-xs text-on-surface dark:text-on-surface-dark divide-y divide-outline-variant/60 dark:divide-outline-dark/60">
                <thead class="bg-surface-container dark:bg-surface-container-dark font-semibold text-on-surface-variant dark:text-on-surface-variant-dark">
                    <tr>
                        <th class="py-3.5 px-4">Nama & Email</th>
                        <th class="py-3.5 px-4">Nomor HP / WhatsApp</th>
                        <th class="py-3.5 px-4">Nomor SIM A & Status</th>
                        <th class="py-3.5 px-4">Alamat Domisili</th>
                        <th class="py-3.5 px-4">Aktivitas Sewa</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/40 dark:divide-outline-dark/40 bg-white dark:bg-surface-dark">
                    
                    <!-- Row 1: Budi Santoso -->
                    <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-primary/20 text-primary dark:text-inverse-primary font-bold flex items-center justify-center text-xs shrink-0">
                                    BS
                                </div>
                                <div class="space-y-0.5 min-w-0">
                                    <span class="font-bold text-on-surface dark:text-on-surface-dark block truncate">Budi Santoso</span>
                                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block truncate">budi.santoso@gmail.com</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 font-mono font-medium">
                            0812-3456-7890
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="space-y-1">
                                <span class="font-mono font-bold text-on-surface dark:text-on-surface-dark block">1234-5678-9012</span>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                                    <span class="material-symbols-outlined text-[12px]">verified</span>
                                    Terverifikasi
                                </span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 max-w-xs truncate text-text-muted dark:text-text-muted-dark">
                            Jl. Kemang Raya No. 45, Jakarta Selatan
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-800 border border-blue-200 dark:bg-blue-950/70 dark:text-blue-300 dark:border-blue-800">
                                1 Sewa Aktif
                            </span>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block mt-0.5">Total 3 Transaksi</span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <button type="button" onclick="openUserModal('Budi Santoso', 'budi.santoso@gmail.com', '0812-3456-7890', '1234-5678-9012', 'Jl. Kemang Raya No. 45, Jakarta Selatan', 'Terverifikasi')" class="px-2.5 py-1 rounded-lg bg-surface-container dark:bg-surface-container-dark hover:bg-primary/10 hover:text-primary dark:hover:text-inverse-primary font-semibold text-on-surface dark:text-on-surface-dark transition-colors cursor-pointer inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">visibility</span>
                                <span>Detail</span>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 2: Siti Rahmawati -->
                    <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 font-bold flex items-center justify-center text-xs shrink-0">
                                    SR
                                </div>
                                <div class="space-y-0.5 min-w-0">
                                    <span class="font-bold text-on-surface dark:text-on-surface-dark block truncate">Siti Rahmawati</span>
                                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block truncate">siti.rahma@yahoo.com</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 font-mono font-medium">
                            0813-8877-6655
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="space-y-1">
                                <span class="font-mono font-bold text-on-surface dark:text-on-surface-dark block">9876-5432-1098</span>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                                    <span class="material-symbols-outlined text-[12px]">verified</span>
                                    Terverifikasi
                                </span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 max-w-xs truncate text-text-muted dark:text-text-muted-dark">
                            Jl. Margonda Raya No. 12, Depok
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="text-text-muted dark:text-text-muted-dark text-[11px] block">Tidak Ada Sewa Aktif</span>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">Total 2 Transaksi</span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <button type="button" onclick="openUserModal('Siti Rahmawati', 'siti.rahma@yahoo.com', '0813-8877-6655', '9876-5432-1098', 'Jl. Margonda Raya No. 12, Depok', 'Terverifikasi')" class="px-2.5 py-1 rounded-lg bg-surface-container dark:bg-surface-container-dark hover:bg-primary/10 hover:text-primary dark:hover:text-inverse-primary font-semibold text-on-surface dark:text-on-surface-dark transition-colors cursor-pointer inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">visibility</span>
                                <span>Detail</span>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 3: Hendra Pratama (Pending Verification) -->
                    <tr class="hover:bg-surface-container/60 dark:hover:bg-surface-container-dark/60 transition-colors">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 font-bold flex items-center justify-center text-xs shrink-0">
                                    HP
                                </div>
                                <div class="space-y-0.5 min-w-0">
                                    <span class="font-bold text-on-surface dark:text-on-surface-dark block truncate">Hendra Pratama</span>
                                    <span class="text-[11px] text-text-muted dark:text-text-muted-dark block truncate">hendra.p@gmail.com</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 font-mono font-medium">
                            0819-2233-4455
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="space-y-1">
                                <span class="font-mono font-bold text-on-surface dark:text-on-surface-dark block">5566-7788-9900</span>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/70 dark:text-amber-300 dark:border-amber-800">
                                    <span class="material-symbols-outlined text-[12px]">hourglass_top</span>
                                    Menunggu Verifikasi
                                </span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 max-w-xs truncate text-text-muted dark:text-text-muted-dark">
                            Jl. Sudirman Kav 52, Jakarta Pusat
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="text-text-muted dark:text-text-muted-dark text-[11px] block">Pendaftar Baru</span>
                            <span class="text-[11px] text-text-muted dark:text-text-muted-dark block">0 Transaksi</span>
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            <button type="button" onclick="openUserModal('Hendra Pratama', 'hendra.p@gmail.com', '0819-2233-4455', '5566-7788-9900', 'Jl. Sudirman Kav 52, Jakarta Pusat', 'Menunggu Verifikasi')" class="px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition-colors cursor-pointer inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">verified</span>
                                <span>Verifikasi SIM</span>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- User Detail Modal -->
<div id="userModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="bg-white dark:bg-surface-dark rounded-2xl max-w-lg w-full p-6 sm:p-8 border border-slate-200 dark:border-slate-800 shadow-2xl space-y-6 relative max-h-[90vh] overflow-y-auto">
        
        <button type="button" onclick="closeUserModal()" class="absolute top-5 right-5 p-1.5 rounded-lg text-text-muted hover:text-on-surface hover:bg-surface-container transition-colors cursor-pointer">
            <span class="material-symbols-outlined text-xl">close</span>
        </button>

        <div class="flex items-center gap-4 border-b border-outline-variant/60 dark:border-outline-dark/60 pb-5">
            <div id="modalAvatar" class="w-14 h-14 rounded-2xl bg-primary text-white text-xl font-bold flex items-center justify-center shrink-0">
                BS
            </div>
            <div class="space-y-0.5">
                <h3 id="modalName" class="text-lg font-bold text-on-surface dark:text-on-surface-dark">
                    Budi Santoso
                </h3>
                <span id="modalEmail" class="text-xs text-text-muted dark:text-text-muted-dark block">
                    budi.santoso@gmail.com
                </span>
                <span id="modalStatusBadge" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/70 dark:text-emerald-300 dark:border-emerald-800">
                    SIM A Terverifikasi
                </span>
            </div>
        </div>

        <div class="space-y-3 text-xs">
            <div class="p-3.5 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-1">
                <span class="text-text-muted dark:text-text-muted-dark block">Nomor WhatsApp / HP:</span>
                <strong id="modalPhone" class="font-mono text-sm text-on-surface dark:text-on-surface-dark block">0812-3456-7890</strong>
            </div>

            <div class="p-3.5 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-1">
                <span class="text-text-muted dark:text-text-muted-dark block">Nomor SIM A (Legalitas Mengemudi):</span>
                <strong id="modalSIM" class="font-mono text-sm text-primary dark:text-inverse-primary block">1234-5678-9012</strong>
            </div>

            <div class="p-3.5 rounded-xl bg-surface-container dark:bg-surface-container-dark space-y-1">
                <span class="text-text-muted dark:text-text-muted-dark block">Alamat Domisili:</span>
                <p id="modalAddress" class="text-on-surface dark:text-on-surface-dark leading-relaxed">
                    Jl. Kemang Raya No. 45, Jakarta Selatan
                </p>
            </div>
        </div>

        <div class="pt-4 border-t border-outline-variant/50 dark:border-outline-dark/50 flex items-center justify-end gap-3">
            <button type="button" onclick="closeUserModal()" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 text-xs font-semibold text-on-surface dark:text-on-surface-dark hover:bg-surface-container dark:hover:bg-surface-container-dark transition-colors">
                Tutup
            </button>
            <button type="button" onclick="alert('Demo UI: Status verifikasi pengguna berhasil diperbarui!'); closeUserModal();" class="px-5 py-2 rounded-lg bg-primary hover:bg-primary-hover text-white text-xs font-semibold shadow-sm transition-all">
                Simpan Verifikasi
            </button>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function openUserModal(name, email, phone, sim, address, status) {
        document.getElementById('modalName').innerText = name;
        document.getElementById('modalEmail').innerText = email;
        document.getElementById('modalPhone').innerText = phone;
        document.getElementById('modalSIM').innerText = sim;
        document.getElementById('modalAddress').innerText = address;
        document.getElementById('modalAvatar').innerText = name.split(' ').map(n => n[0]).join('');
        document.getElementById('userModal').classList.remove('hidden');
    }

    function closeUserModal() {
        document.getElementById('userModal').classList.add('hidden');
    }
</script>
@endpush
