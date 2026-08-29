<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FleetController extends Controller
{
    /**
     * Display a listing of the fleet cars with search, filters, and metrics (Admin).
     */
    public function index(Request $request): View
    {
        $query = Fleet::query()->withCount([
            'rentals as total_rentals_count',
            'rentals as active_rentals_count' => function ($q) {
                $q->whereIn('status', ['active', 'pending_return']);
            },
        ]);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('availability') && in_array($request->availability, ['available', 'rented', 'maintenance'])) {
            $query->where('availability', $request->availability);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('transmission') && in_array($request->transmission, ['Automatic', 'Manual'])) {
            $query->where('transmission', $request->transmission);
        }

        $totalCount = Fleet::count();
        $availableCount = Fleet::where('availability', 'available')->count();
        $rentedCount = Fleet::where('availability', 'rented')->count();
        $maintenanceCount = Fleet::where('availability', 'maintenance')->count();

        $fleets = $query->latest()->paginate(10)->withQueryString();

        return view('admin.cars.index', compact(
            'fleets',
            'totalCount',
            'availableCount',
            'rentedCount',
            'maintenanceCount'
        ));
    }

    /**
     * Public catalog listing of all fleets.
     */
    public function publicIndex(Request $request): View
    {
        $query = Fleet::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        $totalCount = Fleet::count();
        $availableCount = Fleet::where('availability', 'available')->count();
        $fleets = $query->latest()->paginate(9)->withQueryString();

        return view('fleet.index', compact('fleets', 'totalCount', 'availableCount'));
    }

    /**
     * Public detail view for a specific car.
     */
    public function publicShow(Fleet $car): View
    {
        $relatedCars = Fleet::where('id', '!=', $car->id)
            ->where(function ($q) use ($car) {
                $q->where('type', $car->type)
                    ->orWhere('brand', $car->brand);
            })
            ->where('availability', 'available')
            ->limit(3)
            ->get();

        return view('fleet.show', compact('car', 'relatedCars'));
    }

    /**
     * Show the form for creating a new fleet car.
     */
    public function create(): View
    {
        return view('admin.cars.create-edit', [
            'car' => new Fleet,
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created fleet car in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'max:50'],
            'year' => ['required', 'integer', 'min:1990', 'max:2035'],
            'color' => ['required', 'string', 'max:50'],
            'plate_number' => ['required', 'string', 'max:20', 'unique:fleets,plate_number'],
            'transmission' => ['required', 'string', 'in:Automatic,Manual'],
            'fuel_type' => ['required', 'string', 'in:Bensin,Diesel,Hybrid,Listrik'],
            'seat_capacity' => ['required', 'integer', 'min:1', 'max:30'],
            'price' => ['required', 'integer', 'min:0'],
            'availability' => ['required', 'string', 'in:available,rented,maintenance'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'gallery_images' => ['nullable', 'array', 'max:8'],
            'gallery_images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ], [
            'brand.required' => 'Merek mobil wajib diisi.',
            'model.required' => 'Model & varian mobil wajib diisi.',
            'type.required' => 'Kategori mobil wajib dipilih.',
            'year.required' => 'Tahun pembuatan wajib diisi.',
            'color.required' => 'Warna mobil wajib diisi.',
            'plate_number.required' => 'Nomor plat polisi wajib diisi.',
            'plate_number.unique' => 'Nomor plat polisi ini sudah terdaftar dalam sistem.',
            'transmission.required' => 'Jenis transmisi wajib dipilih.',
            'fuel_type.required' => 'Jenis bahan bakar wajib dipilih.',
            'seat_capacity.required' => 'Kapasitas tempat duduk wajib diisi.',
            'price.required' => 'Tarif sewa harian wajib diisi.',
            'image.image' => 'Berkas cover foto harus berupa file gambar.',
            'image.max' => 'Ukuran cover foto tidak boleh lebih dari 3MB.',
            'gallery_images.*.image' => 'Semua file galeri harus berupa format gambar (JPG/PNG/WEBP).',
            'gallery_images.*.max' => 'Ukuran tiap file galeri tidak boleh lebih dari 3MB.',
        ]);

        // Process primary image
        $primaryImagePath = 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80';
        if ($request->hasFile('image')) {
            $primaryImagePath = $request->file('image')->store('fleets', 'public');
        } elseif (! empty($validated['image_url'])) {
            $primaryImagePath = $validated['image_url'];
        }

        // Process gallery images
        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $galleryFile) {
                $galleryPaths[] = $galleryFile->store('fleets/gallery', 'public');
            }
        }

        $fleet = Fleet::create([
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'type' => $validated['type'],
            'year' => (string) $validated['year'],
            'color' => $validated['color'],
            'plate_number' => strtoupper(trim($validated['plate_number'])),
            'transmission' => $validated['transmission'],
            'fuel_type' => $validated['fuel_type'],
            'seat_capacity' => (string) $validated['seat_capacity'],
            'price' => (string) $validated['price'],
            'availability' => $validated['availability'],
            'image' => $primaryImagePath,
            'images' => $galleryPaths,
        ]);

        return redirect()->route('admin.cars.index')->with(
            'success',
            "Unit mobil {$fleet->brand} {$fleet->model} ({$fleet->plate_number}) berhasil ditambahkan ke sistem."
        );
    }

    /**
     * Show the form for editing the specified fleet car.
     */
    public function edit(Fleet $car): View
    {
        return view('admin.cars.create-edit', [
            'car' => $car,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified fleet car in storage.
     */
    public function update(Request $request, Fleet $car): RedirectResponse
    {
        $validated = $request->validate([
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'max:50'],
            'year' => ['required', 'integer', 'min:1990', 'max:2035'],
            'color' => ['required', 'string', 'max:50'],
            'plate_number' => ['required', 'string', 'max:20', Rule::unique('fleets', 'plate_number')->ignore($car->id)],
            'transmission' => ['required', 'string', 'in:Automatic,Manual'],
            'fuel_type' => ['required', 'string', 'in:Bensin,Diesel,Hybrid,Listrik'],
            'seat_capacity' => ['required', 'integer', 'min:1', 'max:30'],
            'price' => ['required', 'integer', 'min:0'],
            'availability' => ['required', 'string', 'in:available,rented,maintenance'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'gallery_images' => ['nullable', 'array', 'max:8'],
            'gallery_images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'deleted_gallery_images' => ['nullable', 'array'],
        ], [
            'brand.required' => 'Merek mobil wajib diisi.',
            'model.required' => 'Model & varian mobil wajib diisi.',
            'type.required' => 'Kategori mobil wajib dipilih.',
            'year.required' => 'Tahun pembuatan wajib diisi.',
            'color.required' => 'Warna mobil wajib diisi.',
            'plate_number.required' => 'Nomor plat polisi wajib diisi.',
            'plate_number.unique' => 'Nomor plat polisi ini sudah terdaftar pada unit lain.',
            'transmission.required' => 'Jenis transmisi wajib dipilih.',
            'fuel_type.required' => 'Jenis bahan bakar wajib dipilih.',
            'seat_capacity.required' => 'Kapasitas tempat duduk wajib diisi.',
            'price.required' => 'Tarif sewa harian wajib diisi.',
            'image.image' => 'Berkas cover foto harus berupa file gambar.',
            'image.max' => 'Ukuran cover foto tidak boleh lebih dari 3MB.',
            'gallery_images.*.image' => 'Semua file galeri harus berupa format gambar (JPG/PNG/WEBP).',
            'gallery_images.*.max' => 'Ukuran tiap file galeri tidak boleh lebih dari 3MB.',
        ]);

        $updateData = [
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'type' => $validated['type'],
            'year' => (string) $validated['year'],
            'color' => $validated['color'],
            'plate_number' => strtoupper(trim($validated['plate_number'])),
            'transmission' => $validated['transmission'],
            'fuel_type' => $validated['fuel_type'],
            'seat_capacity' => (string) $validated['seat_capacity'],
            'price' => (string) $validated['price'],
            'availability' => $validated['availability'],
        ];

        // Handle primary image replacement
        if ($request->hasFile('image')) {
            if ($car->image && ! str_starts_with($car->image, 'http') && Storage::disk('public')->exists($car->image)) {
                Storage::disk('public')->delete($car->image);
            }
            $updateData['image'] = $request->file('image')->store('fleets', 'public');
        } elseif (! empty($validated['image_url'])) {
            $updateData['image'] = $validated['image_url'];
        }

        // Handle gallery images
        $currentGallery = is_array($car->images) ? $car->images : [];
        if ($request->filled('deleted_gallery_images') && is_array($request->deleted_gallery_images)) {
            foreach ($request->deleted_gallery_images as $deletedPath) {
                if (($key = array_search($deletedPath, $currentGallery)) !== false) {
                    unset($currentGallery[$key]);
                    if (! str_starts_with($deletedPath, 'http') && Storage::disk('public')->exists($deletedPath)) {
                        Storage::disk('public')->delete($deletedPath);
                    }
                }
            }
            $currentGallery = array_values($currentGallery);
        }

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $galleryFile) {
                $currentGallery[] = $galleryFile->store('fleets/gallery', 'public');
            }
        }
        $updateData['images'] = $currentGallery;

        $car->update($updateData);

        return redirect()->route('admin.cars.index')->with(
            'success',
            "Data unit mobil {$car->brand} {$car->model} ({$car->plate_number}) berhasil diperbarui."
        );
    }

    /**
     * Remove the specified fleet car from storage (Soft Delete with rental integrity check).
     */
    public function destroy(Fleet $car): RedirectResponse
    {
        $hasActiveRentals = $car->rentals()->whereIn('status', ['active', 'confirmed', 'pending'])->exists();

        if ($hasActiveRentals) {
            return redirect()->back()->with(
                'error',
                "Unit mobil {$car->brand} {$car->model} ({$car->plate_number}) tidak dapat dihapus karena masih memiliki transaksi sewa aktif."
            );
        }

        $plate = $car->plate_number;
        $name = "{$car->brand} {$car->model}";
        $car->delete();

        return redirect()->route('admin.cars.index')->with(
            'success',
            "Unit mobil {$name} ({$plate}) berhasil dihapus / dinonaktifkan dari armada aktif."
        );
    }

    /**
     * Quick toggle / update car availability status from table.
     */
    public function updateStatus(Request $request, Fleet $car): RedirectResponse
    {
        $validated = $request->validate([
            'availability' => ['required', 'string', 'in:available,rented,maintenance'],
        ]);

        $car->update([
            'availability' => $validated['availability'],
        ]);

        $statusLabels = [
            'available' => 'Tersedia (Ready)',
            'rented' => 'Sedang Disewa',
            'maintenance' => 'Dalam Perawatan',
        ];

        return redirect()->back()->with(
            'success',
            "Status ketersediaan unit {$car->plate_number} berhasil diubah menjadi {$statusLabels[$validated['availability']]}."
        );
    }
}
