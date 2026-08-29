# Sequence Diagram: Fleet Catalog, Car Detail, and Fleet Management - Indrasari Rental Car

Dokumen ini memuat diagram urutan (*Sequence Diagram*) visual berbasis Mermaid untuk seluruh fitur **Katalog Armada Publik, Showcase Detail Mobil & Kalkulator Sewa Real-Time, Manajemen Armada Admin (CRUD & Multi-Galeri), serta Modal Dossier Detail Mobil**.

---

## 1. 🚗 Alur Pencarian & Filter Katalog Armada Publik (Public Catalog Flow)

Diagram interaksi saat pengunjung menelusuri katalog mobil dan menerapkan filter dinamis (kategori, transmisi, bahan bakar, kata kunci pencarian).

```mermaid
sequenceDiagram
    autonumber
    actor Customer as Pengunjung / Pelanggan
    participant Browser as Web Browser / UI
    participant Route as routes/web.php
    participant FleetCtrl as FleetController
    participant Model as Fleet Model (Eloquent)
    participant DB as MySQL Database

    Customer->>Browser: Akses Halaman Katalog (/fleet) dengan opsi filter
    Browser->>Route: GET /fleet (search, type, transmission, fuel_type)
    Route->>FleetCtrl: publicIndex(Request $request)
    
    FleetCtrl->>Model: Fleet::query()
    
    opt Parameter search terisi
        FleetCtrl->>Model: where brand, model, atau plate_number match keyword
    end
    
    opt Parameter type dipilih spesifik
        FleetCtrl->>Model: where('type', $type)
    end
    
    opt Parameter transmission dipilih spesifik
        FleetCtrl->>Model: where('transmission', $transmission)
    end
    
    opt Parameter fuel_type dipilih spesifik
        FleetCtrl->>Model: where('fuel_type', $fuel_type)
    end
    
    FleetCtrl->>Model: orderByRaw availability available first, paginate 9 per page
    Model->>DB: Eksekusi SQL Query dan Pagination
    DB-->>Model: Return Koleksi $fleets dan Metadata Paginasi
    
    FleetCtrl->>Model: Query count total armada dan unit available
    Model->>DB: Eksekusi count query
    DB-->>Model: Return $totalCount dan $availableCount
    
    FleetCtrl-->>Browser: Render view fleet.index.blade.php ($fleets, $filters, $stats)
    Browser-->>Customer: Tampilkan kartu armada mobil responsif dan kontrol paginasi
```

---

## 2. 🔍 Alur Showcase Detail Mobil & Kalkulator Sewa Real-Time (Public Car Detail Flow)

Diagram alur ketika calon penyewa membuka halaman detail unit, berinteraksi dengan galeri foto multi-angle, dan menghitung estimasi biaya sewa berdasarkan rentang tanggal.

```mermaid
sequenceDiagram
    autonumber
    actor Customer as Calon Penyewa
    participant Browser as Web Browser / Client UI
    participant Route as routes/web.php
    participant FleetCtrl as FleetController
    participant Model as Fleet Model
    participant DB as MySQL Database

    Customer->>Browser: Klik Detail dan Pesan pada salah satu mobil
    Browser->>Route: GET /fleet/{car}
    Route->>FleetCtrl: publicShow(Fleet $car)
    
    FleetCtrl->>Model: Query unit serupa yang tersedia berdasarkan tipe yang sama
    Model->>DB: Eksekusi SELECT related fleets LIMIT 3
    DB-->>Model: Return $relatedCars
    
    FleetCtrl-->>Browser: Render view fleet.show.blade.php ($car, $relatedCars)
    Browser-->>Customer: Tampilkan foto utama, spesifikasi bento, dan widget kalkulator sewa

    opt Pengunjung Mengklik Thumbnail Galeri
        Customer->>Browser: Klik salah satu thumbnail foto (misal foto interior atau belakang)
        Browser->>Browser: Eksekusi JavaScript switchShowcaseImage(imgUrl, thumbElement)
        Browser-->>Customer: Update foto panggung utama dan aktifkan border thumbnail terpilih
    end

    opt Pengunjung Mengubah Tanggal Mulai atau Tanggal Selesai
        Customer->>Browser: Pilih Tanggal Mulai dan Tanggal Selesai
        Browser->>Browser: Eksekusi JavaScript calculateRentalPrice()
        Browser->>Browser: Hitung selisih hari penyewaan
        Browser->>Browser: Hitung total tarif sewa harian ditambah proteksi asuransi
        Browser-->>Customer: Perbarui label durasi hari, rincian biaya, dan total estimasi harga secara instan
    end

    Customer->>Browser: Klik Pesan Mobil Ini Sekarang
    alt Pengguna Belum Login
        Browser-->>Customer: Arahkan ke halaman /login
    else Pengguna Sudah Login dan SIM Terverifikasi
        Browser-->>Customer: Arahkan ke form pemesanan sewa (/rentals/create?car_id=id)
    end
```

---

## 3. 🛠️ Alur Manajemen Armada Admin: Tambah/Edit dengan Multi-Galeri (Admin Fleet CRUD Flow)

Diagram alur operasi pembuatan atau pembaruan armada oleh administrator, termasuk unggah berkas foto cover utama, upload berkas multi-foto galeri, dan penghapusan foto galeri lama.

```mermaid
sequenceDiagram
    autonumber
    actor Admin as Admin Operasional
    participant Browser as Web Browser (Admin Panel)
    participant Route as routes/web.php (prefix: admin)
    participant Middleware as Auth dan Admin Middleware
    participant FleetCtrl as FleetController
    participant Storage as File Storage (public disk)
    participant DB as MySQL Database

    Admin->>Browser: Buka formulir Tambah Mobil (/admin/cars/create) atau Edit (/admin/cars/{id}/edit)
    Browser->>Route: GET /admin/cars/create atau /admin/cars/{car}/edit
    Route->>Middleware: Verifikasi autentikasi dan role admin
    Middleware->>FleetCtrl: create() atau edit(Fleet $car)
    FleetCtrl-->>Browser: Render view admin.cars.create-edit.blade.php
    
    Admin->>Browser: Lengkapi data spesifikasi, pilih cover image, dan upload berkas galeri
    Browser->>Route: POST /admin/cars atau PUT /admin/cars/{car} (multipart/form-data)
    Route->>Middleware: Verifikasi hak akses admin
    Middleware->>FleetCtrl: store(Request $request) atau update(Request $request, Fleet $car)
    
    FleetCtrl->>FleetCtrl: Validasi merek, model, tahun, plat nomor unik, tipe, harga, dan file gambar
    alt Validasi Gagal
        FleetCtrl-->>Browser: Redirect back with errors and old input
    end

    opt Berkas Foto Cover Utama Baru Diunggah
        FleetCtrl->>Storage: $request->file('image_file')->store('fleets', 'public')
        Storage-->>FleetCtrl: Return path cover image baru
    end

    opt Berkas Foto Galeri Tambahan Diunggah
        loop Setiap berkas galeri baru
            FleetCtrl->>Storage: $file->store('fleets/gallery', 'public')
            Storage-->>FleetCtrl: Tambahkan path baru ke koleksi $galleryImages
        end
    end

    opt Mode Edit dan Admin Mencentang Foto Galeri yang Dihapus
        loop Setiap foto yang dicentang
            FleetCtrl->>Storage: Hapus file fisik dari disk public jika ada
            FleetCtrl->>FleetCtrl: Hapus path dari array galeri mobil
        end
    end

    alt Mode Store (Mobil Baru)
        FleetCtrl->>DB: Fleet::create(data, image, images)
    else Mode Update (Edit Mobil)
        FleetCtrl->>DB: $car->update(data, image, images)
    end
    DB-->>FleetCtrl: Record armada berhasil disimpan ke database

    FleetCtrl-->>Browser: Redirect to /admin/cars dengan flash message sukses
    Browser-->>Admin: Tampilkan daftar tabel armada terbaru
```

---

## 4. 🗂️ Alur Modal Dossier Detail Mobil & Quick Status Switcher (Admin Detail Modal Flow)

Diagram alur interaksi administrator dalam memeriksa data lengkap armada melalui modal dossier dan mengubah status operasional unit secara instan tanpa memuat ulang form edit.

```mermaid
sequenceDiagram
    autonumber
    actor Admin as Admin Operasional
    participant Browser as Web Browser (Admin Panel)
    participant DOM as JavaScript openCarDetailModal
    participant Route as routes/web.php
    participant FleetCtrl as FleetController
    participant DB as MySQL Database

    Admin->>Browser: Klik baris unit mobil (Nama Unit, Foto Thumbnail, atau Ikon Mata)
    Browser->>DOM: Panggil fungsi openCarDetailModal(carPayload)
    DOM->>DOM: Injeksi data spesifikasi lengkap ke elemen modal
    DOM->>DOM: Render foto cover dan buat tombol thumbnail galeri foto
    DOM->>DOM: Set endpoint update status (/admin/cars/{id}/status) dan pilih value aktif
    DOM->>DOM: Tampilkan elemen #carDetailModal dengan animasi fade-in
    Browser-->>Admin: Modal Dossier terbuka menampilkan rincian spesifikasi dan riwayat sewa

    opt Admin Mengklik Thumbnail Galeri di Dalam Modal
        Admin->>DOM: Klik salah satu thumbnail foto galeri
        DOM-->>Admin: Ganti foto pratinjau utama (#modalMainImg) seketika
    end

    opt Admin Mengubah Status Ketersediaan Cepat di Modal
        Admin->>DOM: Ubah dropdown status (misal Tersedia menjadi Servis / Perawatan)
        DOM->>Route: Submit form PATCH /admin/cars/{car}/status
        Route->>FleetCtrl: updateStatus(Request $request, Fleet $car)
        FleetCtrl->>FleetCtrl: Validasi availability (available, rented, maintenance)
        FleetCtrl->>DB: $car->update(['availability' => $request->availability])
        DB-->>FleetCtrl: Status ketersediaan berhasil diperbarui
        FleetCtrl-->>Browser: Redirect back dengan notifikasi sukses
        Browser-->>Admin: Tabel armada ter-refresh dengan badge status terbaru
    end

    opt Admin Menutup Modal
        Admin->>DOM: Klik tombol Tutup, ikon silang, backdrop, atau tekan tombol Escape
        DOM->>DOM: Jalankan animasi fade-out dan sembunyikan elemen modal
        Browser-->>Admin: Kembali ke tampilan tabel armada
    end
```
