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
    Browser->>Route: GET /fleet?search=...&type=...&transmission=...&fuel_type=...
    Route->>FleetCtrl: publicIndex(Request $request)
    
    FleetCtrl->>Model: Fleet::query()
    
    opt Parameter 'search' terisi
        FleetCtrl->>Model: where(brand, 'like', '%') or where(model, 'like', '%') or where(plate_number, 'like', '%')
    end
    
    opt Parameter 'type' terisi & != 'all'
        FleetCtrl->>Model: where('type', $type)
    end
    
    opt Parameter 'transmission' terisi & != 'all'
        FleetCtrl->>Model: where('transmission', $transmission)
    end
    
    opt Parameter 'fuel_type' terisi & != 'all'
        FleetCtrl->>Model: where('fuel_type', $fuel_type)
    end
    
    FleetCtrl->>Model: orderByRaw("availability = 'available' desc")->paginate(9)->withQueryString()
    Model->>DB: Eksekusi SQL Query & Pagination
    DB-->>Model: Return Koleksi $fleets & Metadata Paginasi
    
    FleetCtrl->>Model: Fleet::count() & Fleet::where('availability', 'available')->count()
    Model->>DB: Query Total Armada & Unit Siap Sewa
    DB-->>Model: Return $totalCount & $availableCount
    
    FleetCtrl-->>Browser: Render view fleet.index.blade.php ($fleets, $filters, $stats)
    Browser-->>Customer: Tampilkan kartu armada mobil responsif & kontrol paginasi
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

    Customer->>Browser: Klik "Detail & Pesan →" pada salah satu mobil
    Browser->>Route: GET /fleet/{car}
    Route->>FleetCtrl: publicShow(Fleet $car)
    
    FleetCtrl->>Model: Fleet::where('availability', 'available')->where('id', '!=', $car->id)->where('type', $car->type)->take(3)->get()
    Model->>DB: Query armada serupa yang tersedia
    DB-->>Model: Return $relatedCars
    
    FleetCtrl-->>Browser: Render view fleet.show.blade.php ($car, $relatedCars)
    Browser-->>Customer: Tampilkan foto utama, spesifikasi bento, & widget kalkulator sewa

    opt Pengunjung Mengklik Thumbnail Galeri
        Customer->>Browser: Klik salah satu thumbnail foto (misal: interior / belakang)
        Browser->>Browser: JavaScript switchShowcaseImage(imgUrl, thumbElement)
        Browser-->>Customer: Update hero image stage & beri border aktif pada thumbnail terpilih
    end

    opt Pengunjung Mengubah Tanggal Mulai / Tanggal Selesai
        Customer->>Browser: Pilih Tanggal Mulai (Start Date) & Tanggal Selesai (End Date)
        Browser->>Browser: JavaScript calculateRentalPrice()
        Browser->>Browser: Hitung selisih hari = Math.ceil((end - start) / (1000 * 60 * 60 * 24))
        Browser->>Browser: Subtotal = durasiHari * tarifHarian; Total = Subtotal + biayaAsuransi
        Browser-->>Customer: Perbarui label durasi hari, rincian biaya, dan total estimasi harga secara real-time
    end

    Customer->>Browser: Klik "Pesan Mobil Ini Sekarang"
    alt User Belum Login
        Browser-->>Customer: Arahkan ke /login dengan parameter redirect
    else User Sudah Login & SIM Terverifikasi
        Browser-->>Customer: Arahkan ke alur checkout sewa (/rentals/create?car_id=...)
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
    participant Middleware as Auth & Admin Middleware
    participant FleetCtrl as FleetController
    participant Storage as File Storage (public disk)
    participant DB as MySQL Database

    Admin->>Browser: Buka formulir Tambah Mobil (/admin/cars/create) atau Edit (/admin/cars/{id}/edit)
    Browser->>Route: GET /admin/cars/create atau /admin/cars/{car}/edit
    Route->>Middleware: Verifikasi autentikasi & role == 'admin'
    Middleware->>FleetCtrl: create() atau edit(Fleet $car)
    FleetCtrl-->>Browser: Render view admin.cars.create-edit.blade.php
    
    Admin->>Browser: Lengkapi form spesifikasi, pilih cover image, & upload file galeri tambahan
    Browser->>Route: POST /admin/cars atau PUT /admin/cars/{car} (multipart/form-data)
    Route->>Middleware: Verifikasi hak akses admin
    Middleware->>FleetCtrl: store(Request $request) atau update(Request $request, Fleet $car)
    
    FleetCtrl->>FleetCtrl: Validasi merek, model, tahun, plat nomor unik, tipe, harga, dan file gambar
    alt Validasi Gagal
        FleetCtrl-->>Browser: Redirect back with errors & old input
    end

    opt Ada Berkas Foto Cover Utama Baru Diunggah
        FleetCtrl->>Storage: $request->file('image_file')->store('fleets', 'public')
        Storage-->>FleetCtrl: Return $primaryPath
    end

    opt Ada Berkas Foto Galeri Tambahan Diunggah
        loop Setiap berkas galeri baru
            FleetCtrl->>Storage: $file->store('fleets/gallery', 'public')
            Storage-->>FleetCtrl: Tambahkan path baru ke array $galleryImages
        end
    end

    opt (Mode Edit) Admin Mencentang Foto Galeri yang Dihapus
        loop Setiap foto yang dicentang
            FleetCtrl->>Storage: Hapus file fisik dari disk public jika ada
            FleetCtrl->>FleetCtrl: Hapus path dari array $existingGallery
        end
    end

    alt Mode Store (Mobil Baru)
        FleetCtrl->>DB: Fleet::create(data, image=$primaryPath, images=$galleryImages)
    else Mode Update (Edit Mobil)
        FleetCtrl->>DB: $car->update(data, image=$primaryPath, images=$updatedGallery)
    end
    DB-->>FleetCtrl: Record Armada Berhasil Disimpan

    FleetCtrl-->>Browser: Redirect to /admin/cars with success notification ('Unit berhasil disimpan')
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
    participant DOM as JavaScript openCarDetailModal(carData)
    participant Route as routes/web.php
    participant FleetCtrl as FleetController
    participant DB as MySQL Database

    Admin->>Browser: Klik baris unit mobil (Nama Unit / Foto Thumbnail / Ikon Mata 👁️)
    Browser->>DOM: Panggil fungsi openCarDetailModal(carPayload)
    DOM->>DOM: Injeksi data (nama, plat, harga, tahun, warna, transmisi, BBM, kapasitas) ke elemen modal
    DOM->>DOM: Render foto utama & generate tombol thumbnail strip galeri (#modalGalleryList)
    DOM->>DOM: Update status form action URL (/admin/cars/{id}/status) & value dropdown
    DOM->>DOM: Tampilkan #carDetailModal dengan animasi fade-in & scale-up
    Browser-->>Admin: Modal Dossier terbuka menampilkan rincian spesifikasi & metrik sewa

    opt Admin Mengklik Thumbnail Galeri di Dalam Modal
        Admin->>DOM: Klik salah satu thumbnail foto galeri
        DOM-->>Admin: Ganti foto pratinjau utama (#modalMainImg) secara instan
    end

    opt Admin Mengubah Status Ketersediaan Cepat di Modal
        Admin->>DOM: Ubah dropdown status (misal: 'Tersedia' -> 'Servis / Perawatan')
        DOM->>Route: Submit form PATCH /admin/cars/{car}/status
        Route->>FleetCtrl: updateStatus(Request $request, Fleet $car)
        FleetCtrl->>FleetCtrl: Validasi availability in:available,rented,maintenance
        FleetCtrl->>DB: $car->update(['availability' => $request->availability])
        DB-->>FleetCtrl: Status Berhasil Diperbarui
        FleetCtrl-->>Browser: Redirect back with success message ('Status armada berhasil diperbarui')
        Browser-->>Admin: Tabel armada ter-refresh dengan badge status baru
    end

    opt Admin Menutup Modal
        Admin->>DOM: Klik tombol 'Tutup', ikon 'X', backdrop, atau tekan tombol 'Escape'
        DOM->>DOM: Animasi fade-out & sembunyikan #carDetailModal
        Browser-->>Admin: Kembali ke tampilan tabel armada
    end
```
