# Sequence Diagram: Customer Rental Booking & "Sewa Saya" Portal - Indrasari Rental Car

Dokumen ini memuat diagram urutan (*Sequence Diagram*) visual berbasis Mermaid untuk alur **Pemesanan Mobil (Rental Booking), Validasi Rentang Tanggal Bertabrakan (Date Overlap Validation), Gating SIM A Terverifikasi, Portal "Sewa Saya", Modal Kuitansi & Faktur Digital, serta Pembatalan Pesanan**.

---

## 1. 🚗 Alur Pemesanan Mobil & Kalkulasi Biaya Inklusif (Rental Booking Flow)

Diagram alur saat pelanggan terverifikasi memilih tanggal sewa pada halaman detail kendaraan, memeriksa rincian biaya pada modal konfirmasi, dan menyelesaikan booking ke dalam sistem.

```mermaid
sequenceDiagram
    autonumber
    actor User as Pelanggan Terverifikasi
    participant Browser as Web Browser (/fleet/{id})
    participant DOM as JavaScript Booking Modal
    participant Route as routes/web.php
    participant Middleware as Auth Middleware
    participant RentalCtrl as RentalController
    participant Model as Rental & Fleet Model
    participant DB as MySQL Database

    User->>Browser: Pilih Tanggal Mulai & Selesai Sewa
    Browser->>DOM: Hitung Durasi Hari Inklusif: (End - Start) + 1 Hari
    DOM->>DOM: Hitung Estimasi Total: Durasi x Tarif Harian
    Browser-->>User: Tampilkan durasi hari & total kalkulasi real-time

    User->>Browser: Klik "Lanjutkan Pemesanan Unit"
    Browser->>DOM: Cek status verifikasi akun pengguna (SIM A)
    alt Pengguna Belum Terverifikasi (Pending / Rejected / Guest)
        DOM-->>Browser: Tampilkan Banner / Modal Peringatan Verifikasi SIM A
    else Pengguna Terverifikasi (Verified)
        DOM->>DOM: Injeksi data kendaraan, identitas penyewa, & rincian biaya
        DOM->>DOM: Tampilkan #bookingModal dengan animasi
        Browser-->>User: Modal Konfirmasi Pemesanan Terbuka
    end

    User->>Browser: Centang Syarat & Ketentuan, Klik "Konfirmasi & Selesaikan Booking"
    Browser->>Route: POST /rentals (fleet_id, start_date, end_date, notes)
    Route->>Middleware: Verifikasi sesi autentikasi pelanggan
    Middleware->>RentalCtrl: store(Request $request)

    RentalCtrl->>RentalCtrl: Validasi input (fleet_id exists, date >= today, end >= start)
    RentalCtrl->>RentalCtrl: Validasi status verifikasi SIM (auth()->user()->isVerified())

    RentalCtrl->>Model: Cek Overlap Tanggal pada Fleet ID yang sama
    Model->>DB: SELECT * FROM rentals WHERE fleet_id = ? AND status IN ('pending', 'active', 'pending_return') AND (start_date <= ? AND end_date >= ?)
    DB-->>Model: Return status overlap

    alt Terdapat Jadwal Sewa Bertabrakan (Overlap)
        RentalCtrl-->>Browser: Redirect back with error ('Mobil ini sudah memiliki jadwal sewa aktif pada rentang tanggal tersebut')
        Browser-->>User: Tampilkan notifikasi error jadwal bertabrakan
    else Jadwal Tersedia (No Overlap)
        RentalCtrl->>RentalCtrl: Hitung Durasi Inklusif: Rental::calculateInclusiveDays(start, end)
        RentalCtrl->>RentalCtrl: Hitung Total Harga: Rental::calculateTotalPrice(rate, days)
        RentalCtrl->>RentalCtrl: Generate Kode Unik: Rental::generateRentalCode() -> IND-BK-YYYYMM-XXXX

        RentalCtrl->>DB: DB::transaction() - Insert data ke tabel `rentals` (status: 'active')
        RentalCtrl->>DB: Update status ketersediaan armada `fleets.availability` = 'rented'
        DB-->>RentalCtrl: Transaksi Sukses & Commit

        RentalCtrl-->>Browser: Redirect to route('rentals.index') with success flash alert
        Browser-->>User: Halaman "Sewa Saya" terbuka dengan kartu sewa aktif baru
    end
```

---

## 2. 📋 Alur Portal "Sewa Saya" & Pergantian Tab (My Rentals & Tab Switching Flow)

Diagram alur saat pelanggan membuka portal sewa saya untuk memantau kendaraan yang sedang aktif disewa, melihat alert keterlambatan jika melewati batas waktu, dan melihat riwayat sewa yang telah selesai.

```mermaid
sequenceDiagram
    autonumber
    actor User as Pelanggan
    participant Browser as Web Browser (/rentals)
    participant Route as routes/web.php
    participant Middleware as Auth Middleware
    participant RentalCtrl as RentalController
    participant Model as Rental Model
    participant DB as MySQL Database
    participant TabJS as JavaScript switchRentalTab()

    User->>Browser: Akses Halaman "Sewa Saya" (/rentals)
    Browser->>Route: GET /rentals
    Route->>Middleware: Verifikasi autentikasi user
    Middleware->>RentalCtrl: index(Request $request)

    RentalCtrl->>Model: Rental::where('user_id', auth()->id())->whereIn('status', ['pending', 'active', 'pending_return'])->with('fleet')->latest()
    Model->>DB: Query Sewa Aktif Pelanggan
    DB-->>Model: Return $activeRentals collection

    RentalCtrl->>Model: Rental::where('user_id', auth()->id())->whereIn('status', ['completed', 'cancelled'])->with('fleet')->latest()
    Model->>DB: Query Riwayat Selesai Pelanggan
    DB-->>Model: Return $historyRentals collection

    RentalCtrl-->>Browser: Render view rentals.index.blade.php ($activeRentals, $historyRentals)
    Browser-->>User: Tampilkan kartu sewa aktif, badge plat, dan tombol aksi (Kuitansi / Kembalikan / Batalkan)

    opt Pelanggan Klik Tab "Riwayat Selesai"
        User->>Browser: Klik Tab "Riwayat Selesai"
        Browser->>TabJS: switchRentalTab('history')
        TabJS->>TabJS: Sembunyikan #activeRentalsPanel & Munculkan #historyRentalsPanel
        Browser-->>User: Tampilkan tabel riwayat transaksi selesai & kuitansi
    end
```

---

## 3. 🧾 Alur Modal Kuitansi & Faktur Digital Resmi (Digital Invoice Receipt Flow)

Diagram alur saat pelanggan mengklik tombol "Kuitansi" pada kartu sewa aktif maupun baris riwayat selesai untuk melihat dokumen tagihan resmi ber-kop RSUD Indrasari dan mencetaknya ke format PDF / fisik.

```mermaid
sequenceDiagram
    autonumber
    actor User as Pelanggan
    participant Browser as Web Browser / UI
    participant DOM as JavaScript openInvoiceModal()
    participant Print as Dialog Cetak Browser (window.print)

    User->>Browser: Klik tombol "Kuitansi" pada pesanan sewa
    Browser->>DOM: Panggil openInvoiceModal(rentalPayload)
    DOM->>DOM: Injeksi Nomor Referensi Booking (rental_code)
    DOM->>DOM: Render Badge Status Transaksi (SEWA AKTIF / SELESAI / DIBATALKAN)
    DOM->>DOM: Injeksi Identitas Penyewa (Nama, Email, No HP, No SIM A)
    DOM->>DOM: Injeksi Spesifikasi Mobil (Merek, Model, Plat, Transmisi, Warna)
    DOM->>DOM: Injeksi Rincian Jadwal (Mulai, Selesai, Total Hari Inklusif)
    DOM->>DOM: Render Tabel Biaya (Sewa Pokok, Baris Denda Keterlambatan/Kerusakan, Grand Total)
    DOM->>DOM: Render Catatan Keperluan Sewa Pelanggan (#invoiceCustomerNotesContainer)
    DOM->>DOM: Render Catatan Berita Acara Serah Terima Admin (#invoiceAdminNotesContainer)
    DOM->>DOM: Tampilkan #rentalInvoiceModal dengan latar backdrop blur
    Browser-->>User: Modal Kuitansi & Faktur Digital terbuka di layar

    opt Pelanggan Mencetak Dokumen
        User->>Browser: Klik tombol "Cetak"
        Browser->>Print: Eksekusi window.print()
        Print-->>User: Tampilkan dialog print / Save as PDF resmi
    end
```

---

## 4. ❌ Alur Pembatalan Pesanan Sewa (Rental Cancellation Flow)

Diagram alur saat pelanggan membatalkan pesanan sewa yang belum dimulai, mengembalikan status mobil menjadi tersedia untuk publik secara instan.

```mermaid
sequenceDiagram
    autonumber
    actor User as Pelanggan
    participant Browser as Web Browser (/rentals)
    participant Route as routes/web.php
    participant Middleware as Auth Middleware
    participant RentalCtrl as RentalController
    participant Model as Rental & Fleet Model
    participant DB as MySQL Database

    User->>Browser: Klik tombol "Batalkan" pada pesanan sewa
    Browser->>Browser: Konfirmasi dialog peringatan pembatalan
    User->>Browser: Konfirmasi "Ya, Batalkan"
    
    Browser->>Route: DELETE /rentals/{rental}
    Route->>Middleware: Verifikasi autentikasi user
    Middleware->>RentalCtrl: cancel(Rental $rental)

    RentalCtrl->>RentalCtrl: Validasi hak milik (auth()->id() === $rental->user_id)
    RentalCtrl->>Model: Cek apakah sewa dapat dibatalkan: $rental->isCancellable()

    alt Sewa Tidak Dapat Dibatalkan (Sudah Lewat Tanggal Mulai / Berstatus Completed)
        RentalCtrl-->>Browser: Redirect back with error ('Pesanan sewa ini tidak dapat dibatalkan.')
        Browser-->>User: Tampilkan notifikasi error
    else Sewa Memenuhi Syarat Pembatalan
        RentalCtrl->>DB: DB::transaction() - Update $rental->status = 'cancelled'
        RentalCtrl->>DB: Update ketersediaan $rental->fleet->availability = 'available'
        DB-->>RentalCtrl: Transaksi Sukses & Commit

        RentalCtrl-->>Browser: Redirect back with success alert ('Pesanan sewa mobil berhasil dibatalkan.')
        Browser-->>User: Kartu sewa berpindah ke tab riwayat pembatalan, mobil kembali tersedia di katalog
    end
```
