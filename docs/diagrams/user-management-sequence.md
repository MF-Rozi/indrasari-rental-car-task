# Sequence Diagram: Admin User Management & SIM A Verification - Indrasari Rental Car

Dokumen ini memuat diagram urutan (*Sequence Diagram*) visual berbasis Mermaid untuk seluruh alur **Manajemen Pengguna Admin, Filter Status Verifikasi, Inspeksi Dokumen Fisik SIM A, Persetujuan/Penolakan Verifikasi, dan Pengubahan Peran Akun**.

---

## 1. 👥 Alur Daftar Pengguna & Filter Status SIM A (Admin User Listing Flow)

Diagram alur saat administrator membuka panel kelola pengguna, melihat metrik KPI agregat, dan memfilter data berdasarkan kata kunci pencarian, status verifikasi, atau peran akun.

```mermaid
sequenceDiagram
    autonumber
    actor Admin as Admin Operasional
    participant Browser as Web Browser (Admin Panel)
    participant Route as routes/web.php
    participant Middleware as Auth & Admin Middleware
    participant UserCtrl as UserController
    participant Model as User Model (Eloquent)
    participant DB as MySQL Database

    Admin->>Browser: Akses Halaman Kelola Pengguna (/admin/users)
    Browser->>Route: GET /admin/users (search, verification_status, role)
    Route->>Middleware: Verifikasi autentikasi dan role admin
    Middleware->>UserCtrl: adminIndex(Request $request)
    
    UserCtrl->>Model: User::query() withCount total_rentals & active_rentals
    
    opt Parameter search terisi
        UserCtrl->>Model: where name, email, phone, atau driving_license_number match keyword
    end
    
    opt Parameter verification_status dipilih spesifik
        UserCtrl->>Model: where('verification_status', $status)
    end
    
    opt Parameter role dipilih spesifik
        UserCtrl->>Model: where('role', $role)
    end
    
    UserCtrl->>Model: latest()->paginate(10)->withQueryString()
    Model->>DB: Eksekusi SQL Query Pengguna & Pagination
    DB-->>Model: Return Koleksi $users & Metadata Paginasi
    
    UserCtrl->>Model: Query agregat KPI (total_users, verified, pending, rejected, active_renters)
    Model->>DB: Eksekusi query agregasi
    DB-->>Model: Return $stats array
    
    UserCtrl-->>Browser: Render view admin.users.index.blade.php ($users, $stats, $filters)
    Browser-->>Admin: Tampilkan kartu metrik KPI, filter toolbar, & tabel pengguna
```

---

## 2. 🔍 Alur Modal Inspeksi Dokumen SIM A (SIM A Inspection Modal Flow)

Diagram alur saat admin mengklik baris pengguna untuk memeriksa keabsahan foto fisik dokumen SIM A, masa berlaku, kontak WhatsApp, dan alamat domisili.

```mermaid
sequenceDiagram
    autonumber
    actor Admin as Admin Operasional
    participant Browser as Web Browser / UI
    participant DOM as JavaScript openUserInspectionModal
    
    Admin->>Browser: Klik tombol Verifikasi SIM, Detail, nama pengguna, atau avatar
    Browser->>DOM: Panggil fungsi openUserInspectionModal(userPayload)
    DOM->>DOM: Injeksi data identitas (nama, email, phone, nomor SIM, alamat)
    DOM->>DOM: Tampilkan foto fisik SIM A dari driving_license_photo_url
    DOM->>DOM: Hitung status kedaluwarsa masa berlaku SIM A
    DOM->>DOM: Siapkan tautan WhatsApp Web (wa.me) & link resolusi penuh foto
    DOM->>DOM: Set form action endpoints (/admin/users/id/verify, reject, role)
    DOM->>DOM: Tampilkan modal #userInspectionModal dengan animasi fade-in
    Browser-->>Admin: Modal Dossier terbuka menampilkan dokumen fisik SIM A & opsi verifikasi
```

---

## 3. ✅ Alur Persetujuan & Verifikasi SIM A (SIM Verification Approval Flow)

Diagram alur saat admin menyetujui dokumen SIM A sehingga pelanggan mendapatkan izin legalitas untuk menyewa kendaraan.

```mermaid
sequenceDiagram
    autonumber
    actor Admin as Admin Operasional
    participant Browser as Web Browser (Modal UI)
    participant Route as routes/web.php
    participant Middleware as Auth & Admin Middleware
    participant UserCtrl as UserController
    participant Model as User Model
    participant DB as MySQL Database

    Admin->>Browser: Klik tombol Setujui dan Verifikasi SIM A
    Browser->>Browser: Konfirmasi prompt persetujuan
    Browser->>Route: PATCH /admin/users/{user}/verify
    Route->>Middleware: Verifikasi autentikasi dan role admin
    Middleware->>UserCtrl: verifySim(User $user)
    
    UserCtrl->>Model: $user->update(['verification_status' => 'verified'])
    Model->>DB: UPDATE users SET verification_status = 'verified'
    DB-->>Model: Record updated
    
    UserCtrl-->>Browser: Redirect back with success message ('SIM A berhasil diverifikasi')
    Browser-->>Admin: Halaman ter-refresh dengan badge hijau Terverifikasi & metrik KPI ter-update
```

---

## 4. ❌ Alur Penolakan Verifikasi SIM A (SIM Verification Rejection Flow)

Diagram alur saat admin menolak dokumen SIM A yang tidak valid, buram, atau telah kedaluwarsa.

```mermaid
sequenceDiagram
    autonumber
    actor Admin as Admin Operasional
    participant Browser as Web Browser (Modal UI)
    participant Route as routes/web.php
    participant Middleware as Auth & Admin Middleware
    participant UserCtrl as UserController
    participant Model as User Model
    participant DB as MySQL Database

    Admin->>Browser: Klik tombol Tolak Verifikasi
    Browser->>Browser: Konfirmasi prompt penolakan
    Browser->>Route: PATCH /admin/users/{user}/reject
    Route->>Middleware: Verifikasi autentikasi dan role admin
    Middleware->>UserCtrl: rejectSim(Request $request, User $user)
    
    UserCtrl->>Model: $user->update(['verification_status' => 'rejected'])
    Model->>DB: UPDATE users SET verification_status = 'rejected'
    DB-->>Model: Record updated
    
    UserCtrl-->>Browser: Redirect back with flash notification ('Verifikasi SIM A telah ditolak')
    Browser-->>Admin: Halaman ter-refresh dengan badge merah Ditolak
```
