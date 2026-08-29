# Sequence Diagram: Executive Dashboards (Customer & Admin)

Dokumen ini memuat diagram alur interaksi (*Sequence Diagrams*) menggunakan sintaks **Mermaid** untuk fitur **Customer & Admin Executive Dashboards** pada aplikasi Indrasari Rental Car.

---

## 1. Customer Dashboard Aggregation & Active Command Flow (`GET /dashboard`)

Diagram berikut mengilustrasikan proses saat pelanggan yang telah login membuka halaman `/dashboard`. Sistem melakukan isolasi query untuk mengambil armada sewa aktif pengguna, menghitung keterlambatan/denda dinamis, merangkum metrik personal, serta menyiapkan riwayat transaksi terbaru.

```mermaid
sequenceDiagram
    autonumber
    actor Customer as Pelanggan (Customer)
    participant Browser as Web Browser (Blade View)
    participant Route as routes/web.php
    participant AuthMiddleware as Authenticate Middleware
    participant Controller as DashboardController
    participant ModelRental as Rental Model & DB
    participant ModelUser as User Model & DB
    participant View as dashboard.index

    Customer->>Browser: Akses URL /dashboard
    Browser->>Route: HTTP GET /dashboard
    Route->>AuthMiddleware: Periksa Sesi Login Pelanggan

    alt Sesi Belum Login (Guest)
        AuthMiddleware-->>Browser: Redirect ke /login (HTTP 302)
        Browser-->>Customer: Tampilkan Formulir Login
    else Sesi Valid (Authenticated User)
        AuthMiddleware->>Controller: customerDashboard(Request)
        
        Controller->>ModelUser: Ambil Data Akun Pelanggan ($request->user())
        ModelUser-->>Controller: Objek User (Nama, Role, verification_status)
        
        Controller->>ModelRental: Query Sewa Aktif Utama (status: pending/active/pending_return)
        ModelRental-->>Controller: Objek Active Rental + Relasi Fleet
        
        opt Terdapat Sewa Aktif ($activeRental != null)
            Controller->>ModelRental: $activeRental->calculateSettlementSummary()
            ModelRental-->>Controller: Array settlement (durasi inklusif, is_overdue, denda, grand_total)
        end
        
        Controller->>ModelRental: Agregasi Statistik Personal Pelanggan
        Note over Controller,ModelRental: Hitung total_bookings, active_count, completed_count, total_spent
        ModelRental-->>Controller: Array $stats
        
        Controller->>ModelRental: Query 4 Riwayat Transaksi Terakhir ($user->rentals())
        ModelRental-->>Controller: Collection $recentRentals
        
        Controller->>View: view('dashboard.index', compact('user', 'activeRental', 'activeSettlement', 'stats', 'recentRentals'))
        View-->>Browser: Render HTML Responsif (Hero Banner, Active Command Card, Bento Metrik, Riwayat)
        Browser-->>Customer: Tampilkan Dashboard Pelanggan
    end
```

---

## 2. Admin Operational Central Dashboard Multi-Domain Aggregation Flow (`GET /admin/dashboard`)

Diagram berikut menjelaskan bagaimana Controller mengumpulkan metrik dari berbagai domain (*financial*, *fleets*, *users*, *transactions*, dan *action queues*) untuk disajikan pada Pusat Kontrol Eksekutif Administrator.

```mermaid
sequenceDiagram
    autonumber
    actor Admin as Administrator
    participant Browser as Web Browser (Admin Panel)
    participant Route as routes/web.php
    participant AdminMiddleware as Admin Middleware
    participant Controller as DashboardController
    participant DB as MySQL Database
    participant View as admin.dashboard.index

    Admin->>Browser: Akses URL /admin/dashboard
    Browser->>Route: HTTP GET /admin/dashboard
    Route->>AdminMiddleware: Periksa Autentikasi & Role Admin

    alt Pengguna Bukan Admin (Customer Biasa)
        AdminMiddleware-->>Browser: HTTP 403 Forbidden
        Browser-->>Admin: Tampilkan Halaman Akses Ditolak
    else Pengguna Adalah Admin Sah
        AdminMiddleware->>Controller: adminDashboard(Request)
        
        par Agregasi Metrik Finansial
            Controller->>DB: SUM(total_price + penalty_price) WHERE status = 'completed'
            DB-->>Controller: total_revenue & monthly_revenue
        and Agregasi Status Armada
            Controller->>DB: COUNT(*) GROUP BY availability (available, rented, maintenance)
            DB-->>Controller: $fleetStats
        and Agregasi Status SIM Pengguna
            Controller->>DB: COUNT(*) GROUP BY verification_status (verified, pending, rejected)
            DB-->>Controller: $userStats
        and Antrean Tindakan Cepat (Action Queues)
            Controller->>DB: SELECT * FROM rentals WHERE status = 'pending_return' LIMIT 5
            DB-->>Controller: $pendingReturns
            Controller->>DB: SELECT * FROM users WHERE verification_status = 'pending' LIMIT 5
            DB-->>Controller: $pendingVerifications
        and 5 Transaksi Terbaru Seluruh Platform
            Controller->>DB: SELECT * FROM rentals WITH (user, fleet) ORDER BY created_at DESC LIMIT 5
            DB-->>Controller: $recentRentals
        end

        Controller->>View: view('admin.dashboard.index', compact('stats', 'fleetStats', 'userStats', 'pendingReturns', 'pendingVerifications', 'recentRentals'))
        View-->>Browser: Render Pusat Kontrol Eksekutif (Financial Bento, Fleet Health Bar, Action Queues, Table)
        Browser-->>Admin: Tampilkan Dashboard Pusat Kontrol
    end
```

---

## 3. Action Required Navigation & Resolution Queue Flow

Diagram berikut memvisualisasikan bagaimana Administrator merespons antrean tindakan cepat langsung dari Dashboard Operasional menuju eksekusi verifikasi.

```mermaid
sequenceDiagram
    autonumber
    actor Admin as Administrator
    participant Dashboard as Admin Dashboard (/admin/dashboard)
    participant RentalPanel as Kelola Transaksi (/admin/rentals)
    participant UserPanel as Kelola Pengguna (/admin/users)
    participant Modal as Verification Modal (JS & DOM)
    participant Server as Backend Controllers & DB

    alt Tindakan 1: Verifikasi Pengembalian Fisik Unit
        Admin->>Dashboard: Klik tombol "Verifikasi" pada Antrean Pengembalian Fisik
        Dashboard->>RentalPanel: Navigasi ke /admin/rentals?search=KODE_BOOKING
        RentalPanel->>Modal: Buka Modal Inspeksi Fisik Mobil (#returnVerifyModal)
        Admin->>Modal: Masukkan catatan serah terima & konfirmasi pelunasan
        Modal->>Server: PATCH /admin/rentals/{id}/confirm-return
        Server->>Server: Update status='completed', fleet='available'
        Server-->>RentalPanel: Flash notifikasi sukses
        RentalPanel-->>Admin: Tampilkan status transaksi selesai & armada kembali tersedia
    else Tindakan 2: Verifikasi Legalitas SIM A Pelanggan
        Admin->>Dashboard: Klik tombol "Periksa SIM" pada Antrean Legalitas SIM A
        Dashboard->>UserPanel: Navigasi ke /admin/users?search=NAMA_USER
        UserPanel->>Modal: Buka Modal Inspeksi Dokumen (#userInspectionModal)
        Admin->>Modal: Validasi foto SIM A & e-KTP, lalu klik "Setujui Verifikasi"
        Modal->>Server: PATCH /admin/users/{id}/verify
        Server->>Server: Update verification_status='verified'
        Server-->>UserPanel: Flash notifikasi sukses
        UserPanel-->>Admin: Tampilkan badge "Verified Driver" & izin sewa aktif
    end
```
