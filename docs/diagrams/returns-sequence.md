# Sequence Diagram: Car Returns & Late Fee Processing - Indrasari Rental Car

Dokumen ini memuat diagram urutan (*Sequence Diagram*) visual berbasis Mermaid untuk alur **Pengembalian Mobil Pelanggan (Customer Car Returns), Verifikasi Nomor Plat Instan, Mesin Perhitungan Denda Keterlambatan (Late Fee Engine), Portal Manajemen Peminjaman Admin, Inspeksi Fisik Serah Terima Unit, dan Faktur Pelunasan Akhir**.

---

## 1. 🔍 Alur Verifikasi Nomor Plat & Rekonsiliasi Tagihan Pelanggan (Plate Verification Flow)

Diagram alur saat pelanggan memasukkan nomor plat polisi pada halaman `/returns` atau memilih dari *quick-chips* armada aktif untuk memverifikasi kepemilikan sewa, memeriksa tanggal tenggat, dan melihat estimasi denda keterlambatan secara transparan.

```mermaid
sequenceDiagram
    autonumber
    actor User as Pelanggan Terverifikasi
    participant Browser as Web Browser (/returns)
    participant DOM as JavaScript verifyPlateAjax()
    participant Route as routes/web.php
    participant Middleware as Auth Middleware
    participant ReturnCtrl as ReturnController
    participant Model as Rental & Fleet Model
    participant DB as MySQL Database

    User->>Browser: Akses Halaman Pengembalian (/returns)
    Browser->>Route: GET /returns
    Route->>Middleware: Verifikasi autentikasi user
    Middleware->>ReturnCtrl: index(Request $request)
    ReturnCtrl->>Model: Ambil sewa aktif pelanggan: status IN ('active', 'pending_return')
    Model->>DB: Query sewa aktif
    DB-->>Model: Return $activeRentals
    ReturnCtrl-->>Browser: Render view returns.index.blade.php ($activeRentals, $selectedRental)
    Browser-->>User: Tampilkan form plat nomor & chip armada aktif

    User->>Browser: Masukkan / Klik Plat Nomor Mobil (e.g. B 2419 IND)
    Browser->>DOM: Panggil verifyPlateAjax(plateNumber)
    DOM->>DOM: Set tombol "Memeriksa..." & animasi spinner
    DOM->>Route: POST /returns/verify (JSON: plate_number)
    Route->>Middleware: Verifikasi autentikasi user
    Middleware->>ReturnCtrl: verify(Request $request)

    ReturnCtrl->>ReturnCtrl: Normalisasi plat nomor (uppercase, hapus spasi)
    ReturnCtrl->>Model: Cari sewa aktif user yang cocok dengan plat nomor

    alt Plat Nomor Tidak Ditemukan / Bukan Milik Akun
        ReturnCtrl-->>DOM: JSON 404 (success: false, message: 'Kendaraan tidak ditemukan...')
        DOM->>DOM: Tampilkan #verifyErrorBanner
        DOM-->>User: Muncul notifikasi error plat tidak valid
    else Plat Nomor Valid & Sewa Aktif Terdaftar
        ReturnCtrl->>Model: $rental->calculateSettlementSummary()
        Model->>Model: Hitung hari overdue & denda: max(0, ReturnDate - EndDate) x Tarif Harian
        ReturnCtrl-->>DOM: JSON 200 (success: true, rental, settlement)
        DOM->>DOM: Render Dossier Kendaraan (#displayCarName, #displayCarImage, #displayPlateBadge)
        DOM->>DOM: Render Grid Jadwal (Mulai, Selesai, Total Hari Inklusif)
        DOM->>DOM: Render Alert Keterlambatan jika overdue
        DOM->>DOM: Render Rincian Finansial (Sewa Pokok + Denda = Total Akhir)
        DOM->>DOM: Munculkan #calculationPanel dengan animasi fade-in
        DOM-->>User: Tampilkan rincian rekonsiliasi dan tombol ajukan serah terima
    end
```

---

## 2. 📝 Alur Pengajuan Serah Terima Pengembalian Mobil (Customer Return Submission Flow)

Diagram alur saat pelanggan menyetujui ringkasan biaya akhir dan mengajukan serah terima unit mobil kepada petugas operasional RSUD Indrasari.

```mermaid
sequenceDiagram
    autonumber
    actor User as Pelanggan
    participant Browser as Web Browser (/returns)
    participant Modal as Modal #confirmReturnModal
    participant Route as routes/web.php
    participant Middleware as Auth Middleware
    participant ReturnCtrl as ReturnController
    participant Model as Rental Model
    participant DB as MySQL Database

    User->>Browser: Klik "Ajukan Serah Terima Pengembalian"
    Browser->>Modal: openConfirmReturnModal()
    Modal->>Modal: Injeksi ringkasan mobil, plat, status denda, & total tagihan
    Modal-->>User: Tampilkan dialog konfirmasi serah terima

    User->>Modal: Centang pernyataan kesiapan unit & Klik "Kirim Pengajuan"
    Modal->>Route: POST /returns (rental_id, return_notes)
    Route->>Middleware: Verifikasi sesi autentikasi pelanggan
    Middleware->>ReturnCtrl: store(Request $request)

    ReturnCtrl->>ReturnCtrl: Validasi rental_id exists dan milik auth()->user()
    ReturnCtrl->>Model: Rental::where('id', $id)->where('user_id', auth()->id())->firstOrFail()

    ReturnCtrl->>ReturnCtrl: Hitung denda keterlambatan per hari ini: $rental->calculateLateFee()
    ReturnCtrl->>DB: Update $rental (status = 'pending_return', return_date = now(), penalty_price, notes)
    DB-->>ReturnCtrl: Update berhasil dikomit

    ReturnCtrl-->>Browser: Redirect to route('rentals.index') with success alert
    Browser-->>User: Halaman "Sewa Saya" terbuka menampilkan status "Menunggu Verifikasi Pengembalian"
```

---

## 3. 🔍 Alur Verifikasi Fisik & Persetujuan Pengembalian Admin (Admin Return Inspection Flow)

Diagram alur saat staf operasional / admin memeriksa unit kendaraan fisik yang diserahkan, mengonfirmasi pelunasan sewa beserta denda, menyelesaikan transaksi (`completed`), dan merilis mobil kembali berstatus `available`.

```mermaid
sequenceDiagram
    autonumber
    actor Admin as Admin Operasional
    participant Browser as Web Browser (/admin/rentals)
    participant Modal as Modal #returnVerifyModal
    participant Route as routes/web.php
    participant Middleware as Auth & Admin Middleware
    participant RentalCtrl as RentalController
    participant Model as Rental & Fleet Model
    participant DB as MySQL Database

    Admin->>Browser: Akses Panel Kelola Transaksi (/admin/rentals)
    Browser->>Route: GET /admin/rentals
    Route->>Middleware: Verifikasi autentikasi & hak akses admin
    Middleware->>RentalCtrl: adminIndex(Request $request)
    RentalCtrl->>Model: Query transaksi & hitung statistik KPI
    Model->>DB: SELECT rentals & agregat stats
    DB-->>Model: Return $rentals collection & $stats
    RentalCtrl-->>Browser: Render view admin.rentals.index.blade.php
    Browser-->>Admin: Tampilkan metrik KPI & baris sewa "Menunggu Verifikasi" (pulsing amber)

    Admin->>Browser: Klik tombol "Verifikasi Kembali" pada baris transaksi
    Browser->>Modal: openAdminReturnModal(rentalPayload, settlementPayload)
    Modal->>Modal: Injeksi data penyewa, mobil, periode, kalkulasi denda otomatis
    Modal-->>Admin: Modal Dossier Inspeksi Fisik terbuka

    Admin->>Modal: Input catatan fisik unit & sesuaikan denda (opsional)
    Admin->>Modal: Klik "Konfirmasi Pengembalian Selesai"
    Modal->>Route: PATCH /admin/rentals/{rental}/confirm-return (penalty_price, admin_notes)
    Route->>Middleware: Verifikasi autentikasi & admin role
    Middleware->>RentalCtrl: adminConfirmReturn(Request $request, Rental $rental)

    RentalCtrl->>RentalCtrl: Validasi status sewa in ('active', 'pending_return')
    RentalCtrl->>DB: DB::transaction()
    RentalCtrl->>DB: Update $rental (status = 'completed', return_date = now(), penalty_price, admin_notes)
    RentalCtrl->>DB: Update $rental->fleet (availability = 'available')
    DB-->>RentalCtrl: Transaksi Sukses & Commit

    RentalCtrl-->>Browser: Redirect back to route('admin.rentals.index') with success flash alert
    Browser-->>Admin: Notifikasi sukses muncul, status sewa berubah "Selesai", armada kembali berstatus "Tersedia"
```

---

## 4. 🧾 Alur Kuitansi & Faktur Pelunasan Resmi (Settlement Invoice Flow)

Diagram alur saat admin atau pelanggan mencetak kuitansi resmi setelah transaksi dinyatakan selesai (`completed`), lengkap dengan rincian biaya pokok, denda keterlambatan/kerusakan, catatan keperluan sewa pelanggan, dan berita acara serah terima admin.

```mermaid
sequenceDiagram
    autonumber
    actor Actor as Pelanggan / Admin
    participant Browser as Web Browser (Invoice Modal)
    participant DOM as JavaScript openInvoiceModal()
    participant Print as Browser Print Dialog (window.print)

    Actor->>Browser: Klik tombol "Lihat Kuitansi" pada transaksi selesai
    Browser->>DOM: Panggil openInvoiceModal(rentalPayload)
    DOM->>DOM: Injeksi Kop Surat Resmi RSUD Indrasari
    DOM->>DOM: Injeksi Kode Booking, Identitas Penyewa, Spek Kendaraan, & Plat
    DOM->>DOM: Render Rincian: Sewa Pokok + Denda Keterlambatan = Total Akhir
    DOM->>DOM: Render Keperluan Sewa Pelanggan (#invoiceCustomerNotesContainer) jika ada
    DOM->>DOM: Render Berita Acara Serah Terima Admin (#invoiceAdminNotesContainer) jika ada
    DOM-->>Actor: Modal Kuitansi Resmi Terbuka

    opt Cetak Dokumen
        Actor->>Browser: Klik "Cetak Faktur"
        Browser->>Print: Eksekusi window.print()
        Print-->>Actor: Dialog cetak printer / Save as PDF terbuka
    end
```
