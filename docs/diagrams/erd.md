# Entity Relationship Diagram (ERD) - Indrasari Rental Car

Dokumen ini memuat rancangan diagram relasi entitas (*Entity Relationship Diagram*) untuk database aplikasi **Indrasari Rental Car**.

---

## 📊 Diagram ERD (Mermaid)

```mermaid
erDiagram
    USERS ||--o{ RENTALS : "places"
    FLEETS ||--o{ RENTALS : "is rented in"

    USERS {
        bigint id PK "Auto Increment"
        string name "Full Name"
        string email UK "Unique Email Address"
        string password "Hashed Password"
        string driving_license_number UK "Nomor SIM A (Unique)"
        date driving_license_expiry_date "Masa Berlaku SIM"
        string driving_license_photo "Path Foto SIM A"
        string phone_number UK "Nomor Telepon (Unique)"
        string address "Alamat Tempat Tinggal"
        enum role "admin, user"
        enum verification_status "pending, verified, rejected"
        timestamp email_verified_at "Nullable"
        string remember_token "Nullable"
        timestamp created_at
        timestamp updated_at
    }

    FLEETS {
        bigint id PK "Auto Increment"
        string brand "Toyota, Mitsubishi, Honda, etc."
        string type "MPV, SUV, Luxury, Electric"
        string model "Nama Model Kendaraan"
        string year "Tahun Perakitan"
        string color "Warna Kendaraan"
        string plate_number UK "Nomor Plat Polisi (Unique)"
        string transmission "Automatic, Manual"
        string fuel_type "Bensin, Diesel, Hybrid, Listrik"
        string seat_capacity "Kapasitas Kursi (e.g. 5, 7)"
        string price "Tarif Sewa Harian (IDR)"
        enum availability "available, rented, maintenance"
        string image "URL / Path Foto Unit"
        timestamp created_at
        timestamp updated_at
    }

    RENTALS {
        bigint id PK "Auto Increment"
        bigint user_id FK "References USERS(id)"
        bigint fleet_id FK "References FLEETS(id)"
        date start_date "Tanggal Mulai Sewa"
        date end_date "Tanggal Selesai Sewa"
        date return_date "Tanggal Pengembalian Aktual (Nullable)"
        string daily_rate "Tarif Sewa Harian saat Transaksi"
        int total_days "Jumlah Hari Kalender Sewa"
        string total_price "Total Biaya Sewa (daily_rate * total_days)"
        string penalty_price "Denda Keterlambatan (Default: 0)"
        enum status "pending, active, pending_return, completed, cancelled"
        text notes "Catatan Tambahan (Nullable)"
        timestamp created_at
        timestamp updated_at
    }
```

---

## 📖 Deskripsi Entitas & Relasi

### 1. `users`
Menyimpan data seluruh pengguna sistem, baik **Customer** maupun **Admin**:
- `role`: Membedakan hak akses (`admin` untuk panel administrasi, `user` untuk penyewa).
- `verification_status`: Status verifikasi identitas & SIM oleh Admin (`pending`, `verified`, `rejected`).
- **Relasi**: 1 Pengguna dapat memiliki banyak transaksi sewa (**1-to-Many** dengan `rentals`).

---

### 2. `fleets`
Menyimpan data katalog armada mobil:
- `plate_number`: Nomor plat kendaraan bersifat unik (`UNIQUE`).
- `availability`: Status ketersediaan unit saat ini (`available`, `rented`, `maintenance`).
- **Relasi**: 1 Mobil dapat tercatat dalam banyak riwayat transaksi sewa (**1-to-Many** dengan `rentals`).

---

### 3. `rentals`
Menyimpan data transaksi pemesanan (*booking*) dan pengembalian (*return*):
- `user_id`: Foreign Key ke `users.id` (`onDelete: CASCADE`).
- `fleet_id`: Foreign Key ke `fleets.id` (`onDelete: CASCADE`).
- `status`:
  - `pending`: Menunggu konfirmasi pengambilan unit.
  - `active`: Unit sedang aktif digunakan pelanggan.
  - `pending_return`: Pengajuan pengembalian diajukan oleh customer, menunggu inspeksi admin.
  - `completed`: Pengembalian selesai dan transaksi lunas.
  - `cancelled`: Transaksi dibatalkan.
- **Kalkulasi Biaya**:
  - $\text{Total Biaya Selesai} = \text{total\_price} + \text{penalty\_price}$
