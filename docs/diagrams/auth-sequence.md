# Sequence Diagram: Authentication & Authorization - Indrasari Rental Car

Dokumen ini memuat diagram urutan (*Sequence Diagram*) visual berbasis Mermaid untuk seluruh alur **Autentikasi, Registrasi dengan Unggah SIM, Otorisasi Middleware Berbasis Peran, dan Logout**.

---

## 1. 🔐 Alur Masuk (Login Flow)

Diagram alur ketika pengguna (Customer atau Admin) melakukan autentikasi login ke sistem.

```mermaid
sequenceDiagram
    autonumber
    actor User as Pengguna (Guest)
    participant Browser as Web Browser / UI
    participant Route as routes/web.php
    participant AuthCtrl as AuthController
    participant Model as User Model / Database
    participant Session as Laravel Session & Auth Guard

    User->>Browser: Akses Halaman /login
    Browser->>Route: GET /login (guest middleware)
    Route->>AuthCtrl: login()
    AuthCtrl-->>Browser: Render view auth.blade.php (tab: signin)

    User->>Browser: Masukkan Email & Password, lalu submit
    Browser->>Route: POST /login (CSRF Token, credentials)
    Route->>AuthCtrl: auth(Request $request)
    
    AuthCtrl->>AuthCtrl: Validasi format email & password
    alt Validasi Form Gagal
        AuthCtrl-->>Browser: Redirect back with errors & old input
    end

    AuthCtrl->>Session: Auth::attempt($credentials, $remember)
    Session->>Model: Query user by email & verifikasi Hash::check(password)
    
    alt Kredensial Salah
        Model-->>Session: Return false
        Session-->>AuthCtrl: Autentikasi Gagal
        AuthCtrl-->>Browser: Redirect back with error 'Email atau password salah'
    else Kredensial Valid
        Model-->>Session: Return User Record
        Session->>Session: regenerate() session ID
        Session-->>AuthCtrl: Autentikasi Berhasil
        
        alt Role == 'admin'
            AuthCtrl-->>Browser: Redirect to /admin/dashboard
        else Role == 'user'
            AuthCtrl-->>Browser: Redirect to /dashboard
        end
    end
```

---

## 2. 📝 Alur Registrasi & Unggah SIM A (Registration Flow)

Diagram alur pendaftaran pengguna baru dengan validasi data identitas dan penyimpanan foto SIM A.

```mermaid
sequenceDiagram
    autonumber
    actor Customer as Calon Customer
    participant Browser as Web Browser / UI
    participant Route as routes/web.php
    participant AuthCtrl as AuthController
    participant Storage as File Storage (public disk)
    participant DB as MySQL Database
    participant Session as Laravel Auth Guard

    Customer->>Browser: Buka tab registrasi (/register)
    Browser->>Route: GET /register (guest middleware)
    Route->>AuthCtrl: register()
    AuthCtrl-->>Browser: Render view auth.blade.php (tab: register)

    Customer->>Browser: Isi nama, email, phone, no SIM, masa berlaku, password & upload foto SIM
    Browser->>Route: POST /register (multipart/form-data)
    Route->>AuthCtrl: store(Request $request)

    AuthCtrl->>AuthCtrl: Validasi keunikan email, phone, nomor SIM, batas ukuran foto (max 2MB), dan konfirmasi password
    alt Validasi Gagal (misal: Nomor SIM sudah terdaftar)
        AuthCtrl-->>Browser: Redirect back with errors & old input
    end

    AuthCtrl->>Storage: Store file ke 'driving_license/' pada disk public
    Storage-->>AuthCtrl: Return $photoPath (e.g. driving_license/xyz.jpg)

    AuthCtrl->>DB: User::create(data, role='user', verification_status='pending', driving_license_photo=$photoPath)
    DB-->>AuthCtrl: User Model Created

    AuthCtrl->>Session: Auth::login($user) & regenerate session
    AuthCtrl-->>Browser: Redirect to /dashboard with flash message ('Pendaftaran berhasil')
```

---

## 3. 🛡️ Alur Otorisasi Middleware (Route Protection Flow)

Diagram alur pemeriksaan hak akses saat pengguna mengakses rute Customer atau rute Admin.

```mermaid
sequenceDiagram
    autonumber
    actor User as Pengguna
    participant Route as routes/web.php
    participant AuthMW as Authenticate Middleware ('auth')
    participant AdminMW as AdminMiddleware ('admin')
    participant Controller as Admin / Customer Controller
    participant View as Blade View

    Note over User, Route: Skenario A: Mengakses Rute Customer (/dashboard, /rentals, /returns, /profile)
    User->>Route: GET /dashboard
    Route->>AuthMW: handle()
    alt Pengguna Belum Login (Guest)
        AuthMW-->>User: Redirect 302 to /login with notification
    else Pengguna Sudah Login
        AuthMW->>Controller: Lolos ke Controller / Action
        Controller-->>User: Render halaman 200 OK
    end

    Note over User, Route: Skenario B: Mengakses Rute Panel Admin (/admin/*)
    User->>Route: GET /admin/dashboard
    Route->>AuthMW: handle()
    alt Belum Login
        AuthMW-->>User: Redirect 302 to /login
    else Sudah Login
        AuthMW->>AdminMW: handle()
        alt Role User !== 'admin' (Customer Biasa)
            AdminMW-->>User: Abort 403 Forbidden ('Akses ditolak')
        else Role User === 'admin'
            AdminMW->>Controller: Lolos ke AdminController
            Controller-->>User: Render Admin Dashboard 200 OK
        end
    end
```

---

## 4. 🚪 Alur Keluar (Logout Flow)

Diagram alur pengakhiran sesi pengguna dari sistem.

```mermaid
sequenceDiagram
    autonumber
    actor User as Pengguna Aktif
    participant Browser as Web Browser / UI
    participant Route as routes/web.php
    participant AuthCtrl as AuthController
    participant Session as Laravel Session Manager

    User->>Browser: Klik tombol 'Keluar' (Logout)
    Browser->>Route: POST /logout (CSRF Token)
    Route->>AuthCtrl: logout(Request $request)

    AuthCtrl->>Session: Auth::logout()
    AuthCtrl->>Session: $request->session()->invalidate()
    AuthCtrl->>Session: $request->session()->regenerateToken()
    
    AuthCtrl-->>Browser: Redirect 302 to '/' (Beranda) with flash message ('Berhasil keluar')
    Browser-->>User: Menampilkan Beranda dalam status Guest
```
