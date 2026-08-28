# Spesifikasi Fitur Aplikasi Persewaan Mobil

---

## 1. Admin

### Dashboard Page

- Menampilkan ringkasan pendapatan total transaksi yang telah selesai (*Completed*).
- Menampilkan metrik armada: jumlah mobil tersedia (*Available*), sedang disewa (*Rented*), dan dalam perawatan (*Maintenance*).
- Menampilkan jumlah transaksi yang sedang berlangsung (*Active*) dan menunggu verifikasi pengembalian (*Pending Return*).
- Menampilkan statistik pengguna: total terdaftar, terverifikasi (*Verified*), dan menunggu verifikasi SIM (*Pending Verification*).

### Manage User Page

- Menampilkan daftar seluruh pengguna (Customer & Admin) beserta detail kontak dan nomor SIM.
- Mengelola status verifikasi pengguna: tombol aksi **Verifikasi SIM** atau **Tolak Verifikasi**.
- Hanya pengguna berstatus **Terverifikasi** yang memiliki izin untuk melakukan pemesanan (*booking*) mobil.

### Manage Car Page

- Menampilkan daftar armada mobil beserta status operasionalnya:
  - `AVAILABLE`: Siap disewa.
  - `RENTED`: Sedang digunakan dalam transaksi aktif.
  - `MAINTENANCE`: Sedang diservis di bengkel (tidak dapat dibooking).
- Mengelola data mobil (Tambah, Edit, Hapus, Detail): merek, model, tahun, transmisi, kapasitas penumpang, bahan bakar, dan upload foto unit ke storage.
- Nomor plat kendaraan (`plate_number`) bersifat unik di dalam sistem.
- Mengatur tarif sewa harian (`daily_rate`) serta tarif denda keterlambatan per hari (`denda_per_hari`).

### Manage Booking Page

- Menampilkan daftar seluruh transaksi sewa pelanggan dengan filter status:
  - `PENDING`: Menunggu persetujuan / pengambilan unit.
  - `ACTIVE`: Unit mobil sedang digunakan oleh customer.
  - `PENDING_RETURN`: Customer telah mengajukan pengembalian, menunggu pemeriksaan admin.
  - `COMPLETED`: Mobil telah diperiksa admin, transaksi selesai, dan pembayaran lunas.
  - `CANCELLED`: Pesanan dibatalkan.
- Tombol aksi **Konfirmasi Pengembalian**: Admin memverifikasi unit fisik, memastikan pembayaran total (sewa + denda jika ada), menyelesaikan transaksi (`COMPLETED`), dan mengembalikan status mobil menjadi `AVAILABLE`.

---

## 2. Customer

### Dashboard Page

- Menampilkan kartu sewa aktif saat ini (informasi unit, plat nomor, tanggal sewa, status) dengan tombol aksi cepat menuju halaman pengembalian unit.
- Menampilkan status verifikasi akun pengguna (Terverifikasi / Menunggu Verifikasi Admin).
- Menyediakan tombol akses cepat menuju katalog armada (*Fleet / Armada*).

### Profile Page

- Menampilkan data profil akun: Nama Lengkap, Alamat, Nomor Telepon, Email, dan Nomor SIM.
- Mengunggah / memperbarui foto fisik SIM A dan e-KTP ke storage untuk keperluan verifikasi admin.
- Formulir edit data profil dan kata sandi (*password*).

### Booking / Rental History Page

- Menampilkan daftar riwayat seluruh transaksi sewa customer beserta status (`PENDING`, `ACTIVE`, `PENDING_RETURN`, `COMPLETED`, `CANCELLED`).
- Menampilkan rincian invoice transaksi, durasi sewa, tarif sewa, dan rincian denda jika ada.

### Rental / Booking Form Page

- Satu transaksi pemesanan berlaku untuk **1 unit mobil**.
- Pelanggan memasukkan tanggal mulai dan tanggal selesai sewa serta memilih unit mobil yang diinginkan.
- Hanya pelanggan dengan akun **Terverifikasi** yang dapat menyelesaikan formulir booking.
- Pengecekan ketersediaan sistem: unit tidak dapat dipilih jika mobil berstatus `MAINTENANCE` atau terdapat transaksi `PENDING`/`ACTIVE`/`PENDING_RETURN` pada rentang tanggal yang saling bertabrakan (*overlap*).
- Data peminjaman tersimpan ke dalam database dan status awal diset menjadi `ACTIVE` (atau `PENDING`).

### Return Page

- Pengguna mengajukan pengembalian mobil sewaan dengan memasukkan nomor plat kendaraan atau memilih dari daftar sewa aktif di dashboard/booking page.
- Sistem memverifikasi bahwa nomor plat tersebut benar-benar sedang aktif disewa oleh pengguna yang bersangkutan.
- Sistem menghitung durasi sewa hari kalender inklusif:
  `Durasi Hari = (Tanggal Selesai - Tanggal Mulai) + 1 Hari`
- Sistem menghitung denda keterlambatan secara otomatis jika tanggal pengembalian melebihi tanggal selesai sewa:
  `Denda = Hari Keterlambatan * Tarif Denda per Hari`
- Sistem menghitung total biaya yang wajib dibayar saat serah terima pengembalian:
  `Total Biaya = (Tarif Harian * Durasi Hari) + Denda`
- Setelah pengguna mengonfirmasi pengajuan pengembalian, status transaksi berubah menjadi `PENDING_RETURN` hingga diverifikasi oleh Admin.

### Logout

- Mengakhiri sesi pengguna dari aplikasi dan dapat masuk kembali di kemudian waktu.

---

## 3. Public

### Home / Landing Page

- Menampilkan banner promosi utama dengan widget pencarian ketersediaan mobil berdasarkan tanggal mulai, tanggal selesai, dan jenis kendaraan.
- Menampilkan katalog mobil unggulan (*featured fleet*) dengan tarif harian dan tautan cepat ke detail mobil.
- Menampilkan keunggulan layanan rental (*Trust Bento*: armada bersih & terawat, transparansi harga tanpa biaya tersembunyi, layanan bantuan 24/7).
- Menampilkan kontak resmi, alamat kantor operasional, dan tautan navigasi pendaftaran.

### Login Page

- Pengguna dapat masuk ke dalam sistem menggunakan Email dan Password terdaftar.

### Register Page

- Pengguna baru mendaftar dengan mengisi data pribadi (Nama Lengkap, Alamat, Nomor Telepon, Nomor SIM, Email, dan Password).
- Nomor SIM (`driver_license_number`) dan Email wajib unik di dalam sistem.
- Status awal akun pengguna yang baru mendaftar adalah **Menunggu Verifikasi SIM** (*Pending Verification*).

### Fleet / Armada Page

- Menampilkan katalog seluruh armada mobil yang terdaftar di sistem.
- Menyediakan filter pencarian berdasarkan merek, model, tipe transmisi (Manual/Matic), dan status ketersediaan unit.

### Car Detail Page

- Menampilkan galeri foto kendaraan dan badge status ketersediaan unit.
- Menampilkan spesifikasi teknis lengkap (transmisi, jenis bahan bakar, kapasitas penumpang, bagasi, dan fitur keselamatan).
- Menyediakan kalkulator estimasi tarif sewa interaktif berdasarkan tanggal sewa yang dipilih.
- Menampilkan syarat & ketentuan sewa (Wajib SIM A terverifikasi, e-KTP, dan deposit).
- Tombol pemesanan langsung (*Booking CTA*) yang mengarahkan ke form pemesanan jika sudah login & terverifikasi.
