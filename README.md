<p align="center">
  <img src="https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=300&q=80" width="120" style="border-radius: 24px;" alt="Indrasari Rental Car Logo" />
</p>

<h1 align="center">🚗 Indrasari Rental Car Platform</h1>

<p align="center">
  <strong>Aplikasi Manajemen Persewaan Mobil Modern, Responsif & Terintegrasi</strong><br>
  Dibangun dengan <strong>Laravel 13 (PHP 8.5)</strong>, <strong>Tailwind CSS v4</strong>, <strong>Blade Templating</strong>, dan <strong>MySQL</strong>.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 13" />
  <img src="https://img.shields.io/badge/PHP-8.5-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.5" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-v4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS v4" />
  <img src="https://img.shields.io/badge/Pest_PHP-90_Passed_(100%25)-00D26A?style=for-the-badge&logo=pest&logoColor=white" alt="Pest Tests" />
  <img src="https://img.shields.io/badge/Laravel_Pint-Passed-000000?style=for-the-badge" alt="Laravel Pint" />
  <img src="https://img.shields.io/badge/License-MIT-blue?style=for-the-badge" alt="License MIT" />
</p>

---

## 📖 Tentang Aplikasi

**Indrasari Rental Car Platform** adalah sistem persewaan mobil menyeluruh yang dirancang untuk kebutuhan operasional RSUD Indrasari dan masyarakat umum. Sistem ini menyediakan alur bisnis lengkap mulai dari eksplorasi armada publik, verifikasi dua tahap dokumen SIM A pelanggan, pemesanan anti-tabrakan jadwal sewa, sistem pengembalian mandiri dengan verifikasi plat instan, kalkulasi denda keterlambatan dinamis, pencatatan berita acara serah terima unit fisik, hingga pusat kontrol eksekutif real-time bagi administrator.

---

## ✨ Fitur Utama Sistem

### 1. 🌐 Portal Publik & Tamu (*Guest*)
- **Landing Page Interaktif (`/`)**: Banner promosi utama dinamis, widget pencarian ketersediaan mobil berdasarkan tanggal & jenis transmisi, showcase armada unggulan, starting rate termurah otomatis, dan bento keunggulan layanan.
- **Katalog Armada Lengkap (`/fleet`)**: Pencarian multi-kriteria (merek/model), filter transmisi (Manual/Matic), dan filter ketersediaan unit (*Ready / Disewa / Bengkel*).
- **Detail Spesifikasi Mobil (`/fleet/{car}`)**: Galeri foto kendaraan, spesifikasi teknis (bahan bakar, kapasitas penumpang, bagasi, tahun), kalkulator estimasi tarif interaktif inklusif, dan tombol booking langsung.
- **Autentikasi Aman (`/login` & `/register`)**: Validasi nomor SIM A dan email unik, hashing password standar `bcrypt`, dan sesi login terlindungi.

### 2. 👤 Portal Pelanggan (*Customer*)
- **Executive Customer Dashboard (`/dashboard`)**:
  - Kartu Komando Sewa Aktif (*Active Booking Card*): Foto unit, nomor plat, kode booking, jadwal sewa, sisa hari, alert keterlambatan otomatis, dan tombol cepat *Kembalikan Mobil*.
  - Status Legalitas SIM A (*Driver Terverifikasi* / *Menunggu Review* / *Ditolak*).
  - Bento Metrik Personal (*Total Peminjaman, Unit Aktif, Sewa Selesai, Total Pengeluaran*).
  - Tabel 4 riwayat transaksi sewa terakhir.
- **Manajemen Profil & Legalitas (`/profile`)**: Update data kontak, upload foto fisik SIM A dan e-KTP, serta ubah password akun.
- **Pemesanan Mobil Anti-Tabrakan (`POST /rentals`)**: Proteksi wajib SIM A terverifikasi (*Verified Driver*), pencegahan tabrakan tanggal sewa (*date collision guard*), dan penomoran kode booking unik `IND-BK-YYYYMM-XXXX`.
- **Portal "Sewa Saya" (`/rentals`)**: Tab transaksi aktif vs selesai, rincian biaya sewa inklusif, faktur & kuitansi digital resmi ber-kop RSUD Indrasari, rincian denda transparan, catatan keperluan sewa pelanggan, serta berita acara fisik admin.
- **Pengembalian Mobil Mandiri (`/returns`)**: Form pencocokan plat nomor dengan kapitalisasi otomatis & *quick chips*, verifikasi AJAX live lookup kepemilikan sewa, rincian denda otomatis, dan pengajuan serah terima status `pending_return`.

### 3. 🏢 Pusat Kontrol Administrator (*Admin*)
- **Operational Central Dashboard (`/admin/dashboard`)**:
  - Banner status operasional real-time dengan 3 tombol pintasan cepat berindikator badge antrean.
  - Bento KPI Finansial & Operasional (*Total Pendapatan Selesai, Pendapatan Bulan Berjalan, Kesiapan Armada, Pengguna Terverifikasi*).
  - **Fleet Status Composition Bar**: Visual progress bar proporsional (*Tersedia, Sedang Disewa, Perawatan Bengkel*) dengan persentase utilisasi.
  - **Action Required Queues**: Antrean pengembalian fisik unit & antrean validasi dokumen SIM A pendaftar baru.
  - Tabel 5 transaksi peminjaman terbaru di seluruh platform.
- **Manajemen Armada Mobil (`/admin/cars`)**: CRUD lengkap data mobil, upload foto unit, dan quick switch status ketersediaan (`available`, `rented`, `maintenance`).
- **Manajemen Pengguna & Verifikasi Dokumen (`/admin/users`)**: Review dokumen SIM A & e-KTP resolusi tinggi, aksi *Verifikasi SIM* (memberikan izin sewa) atau *Tolak Verifikasi* (dengan catatan perbaikan), serta promosi role admin/user.
- **Manajemen Transaksi & Serah Terima Fisik (`/admin/rentals`)**: Filter transaksi multi-status, modal inspeksi kondisi fisik unit (`#returnVerifyModal`), penyesuaian denda/kerusakan, pencatatan berita acara serah terima (`admin_notes`), dan konfirmasi pengembalian yang otomatis merilis armada kembali menjadi `available`.

---

## 🧮 Logika Bisnis & Formula Perhitungan

Aplikasi menerapkan standar perhitungan finansial dan durasi yang adil dan transparan:

1. **Durasi Sewa Hari Kalender Inklusif**:
   - `Durasi Sewa (Hari) = (Tanggal Selesai - Tanggal Mulai) + 1 Hari`
   - *Contoh: Sewa mulai 28 Agustus s.d. 30 Agustus dihitung 3 hari penuh.*

2. **Subtotal Sewa Pokok**:
   - `Subtotal Sewa Pokok = Tarif Harian Mobil × Durasi Sewa (Hari)`

3. **Denda Keterlambatan Dinamis**:
   - `Hari Terlambat = MAX(0, Tanggal Pengembalian Aktual - Tanggal Selesai Sewa)`
   - `Denda Keterlambatan = Hari Terlambat × Tarif Harian Mobil`
   - *(Denda Rp 0 jika dikembalikan tepat waktu atau lebih awal).*

4. **Total Pelunasan Akhir Transaksi (Grand Total)**:
   - `Total Pelunasan = Subtotal Sewa Pokok + Denda Keterlambatan / Biaya Kerusakan`

---

## 📸 Tangkapan Layar Aplikasi (*Screenshots*)

Seluruh tangkapan layar antarmuka resolusi tinggi (Mode Terang & Mode Gelap) tersedia di folder [`screenshots/`](screenshots/):

| Halaman / Modul | Mode Terang | Mode Gelap |
|:---|:---|:---|
| **Landing Page** (`/`) | [Lihat Gambar](screenshots/01_home_page_light.png) | [Lihat Gambar](screenshots/01_home_page_dark.png) |
| **Katalog Armada** (`/fleet`) | [Lihat Gambar](screenshots/02_fleet_catalog_light.png) | [Lihat Gambar](screenshots/02_fleet_catalog_dark.png) |
| **Detail Mobil & Booking** (`/fleet/2`) | [Lihat Gambar](screenshots/03_car_detail_light.png) | [Lihat Gambar](screenshots/03_car_detail_dark.png) |
| **Login & Register** | [Lihat Login](screenshots/04_login_page_light.png) | [Lihat Register](screenshots/05_register_page_dark.png) |
| **Customer Dashboard** (`/dashboard`) | [Lihat Gambar](screenshots/06_customer_dashboard_light.png) | [Lihat Gambar](screenshots/06_customer_dashboard_dark.png) |
| **Sewa Saya & Kuitansi** (`/rentals`) | [Lihat Kuitansi](screenshots/09_customer_digital_invoice_modal_light.png) | [Lihat Sewa](screenshots/07_customer_rentals_active_dark.png) |
| **Portal Pengembalian** (`/returns`) | [Lihat Gambar](screenshots/10_customer_returns_portal_light.png) | [Lihat Gambar](screenshots/10_customer_returns_portal_dark.png) |
| **Profil & Upload SIM** (`/profile`) | [Lihat Gambar](screenshots/11_customer_profile_light.png) | [Lihat Gambar](screenshots/11_customer_profile_dark.png) |
| **Admin Dashboard** (`/admin/dashboard`) | [Lihat Gambar](screenshots/12_admin_dashboard_light.png) | [Lihat Gambar](screenshots/12_admin_dashboard_dark.png) |
| **Kelola Armada** (`/admin/cars`) | [Lihat Gambar](screenshots/13_admin_fleet_management_light.png) | [Lihat Gambar](screenshots/13_admin_fleet_management_dark.png) |
| **Kelola Transaksi** (`/admin/rentals`) | [Lihat Gambar](screenshots/16_admin_rentals_management_light.png) | [Lihat Gambar](screenshots/16_admin_rentals_management_dark.png) |
| **Modal Inspeksi Serah Terima** | [Lihat Gambar](screenshots/17_admin_return_verification_modal_light.png) | [Lihat Gambar](screenshots/17_admin_return_verification_modal_dark.png) |
| **Kelola User & Review SIM** (`/admin/users`) | [Lihat Gambar](screenshots/19_admin_users_management_light.png) | [Lihat Gambar](screenshots/20_admin_user_sim_inspection_modal_dark.png) |

---

## 🗂️ Dokumentasi Arsitektur & Sequence Diagrams

Diagram teknis berbasis **Mermaid** tersedia secara lengkap di direktori `docs/diagrams/`:

- [📐 Diagram Relasi Database (ERD)](docs/diagrams/erd.md)
- [🔐 Alur Autentikasi & Registrasi Pengguna](docs/diagrams/auth-sequence.md)
- [🚗 Alur Katalog Publik & CRUD Armada Mobil](docs/diagrams/fleet-sequence.md)
- [🪪 Alur Verifikasi SIM A & Manajemen Pengguna](docs/diagrams/user-management-sequence.md)
- [📅 Alur Pemesanan Sewa & Portal "Sewa Saya"](docs/diagrams/rental-booking-sequence.md)
- [🔄 Alur Pengembalian Mobil & Rekonsiliasi Denda](docs/diagrams/returns-sequence.md)
- [📊 Alur Pusat Komando & Executive Dashboards](docs/diagrams/dashboard-sequence.md)

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

### Prasyarat Sistem:
- PHP >= 8.2 (Disarankan PHP 8.5)
- Composer
- Node.js >= 18 & NPM
- MySQL 8.0 / MariaDB / Podman / Docker

### Langkah-Langkah Instalasi:

1. **Clone Repository**:
   ```bash
   git clone https://github.com/MF-Rozi/indrasari-rental-car-task.git
   cd indrasari-rental-car-task
   ```

2. **Install Dependensi Backend & Frontend**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment (`.env`)**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Sesuaikan konfigurasi database `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` pada file `.env`.*

4. **Migrasi Database & Seeding Data Dummy**:
   ```bash
   php artisan migrate:fresh --seed
   ```
   *(Atau impor langsung file database terlampir: `db_indrasari_car_rental.sql`).*

5. **Kompilasi Aset Frontend (Tailwind CSS v4 & Vite)**:
   ```bash
   npm run build
   ```

6. **Jalankan Web Server Lokal**:
   ```bash
   php artisan serve
   ```
   Buka browser di `http://127.0.0.1:8000`.

---

## 🔑 Kredensial Akun Bawaan (Default Seeders)

| Role / Peran | Email | Password | Hak Akses & Status |
|---|---|---|---|
| **Super Admin** | `admin@rsudindrasari.com` | `password` | Akses penuh dashboard operasional admin (`/admin`) |
| **Verified Driver** | `customer@example.com` | `password` | Pelanggan dengan SIM A terverifikasi sah (Dapat memesan mobil) |
| **Pending Driver** | `pending@example.com` | `password` | Pelanggan baru yang sedang menunggu review SIM A oleh admin |

---

## 🧪 Pengujian & Standar Kualitas (*Quality Assurance*)

Proyek ini dilengkapi dengan **90 Pest Feature Tests** dengan **398 assertions** mencakup seluruh boundary keamanan, otorisasi, dan validasi transaksi:

```bash
# Menjalankan seluruh test suite Pest
vendor/bin/pest

# Menjalankan pemeriksaan format kode Laravel Pint
vendor/bin/pint --format agent
```

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah lisensi terbuka [MIT License](LICENSE).

