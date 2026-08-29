<?php

use App\Models\Fleet;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('admin can view fleet management page with metrics and cars table', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    Fleet::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Innova Zenix 2.0 Q Hybrid',
        'plate_number' => 'B 2419 IND',
        'availability' => 'available',
    ]);
    Fleet::factory()->create([
        'brand' => 'Mitsubishi',
        'model' => 'Pajero Sport Dakar',
        'plate_number' => 'B 1888 MFS',
        'availability' => 'rented',
    ]);

    $response = $this->actingAs($admin)->get('/admin/cars');

    $response->assertStatus(200);
    $response->assertSee('Toyota Innova Zenix 2.0 Q Hybrid');
    $response->assertSee('B 2419 IND');
    $response->assertSee('Mitsubishi Pajero Sport Dakar');
    $response->assertSee('B 1888 MFS');
    $response->assertSee('2 Unit');
});

test('regular user cannot access admin fleet management', function () {
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)->get('/admin/cars')->assertStatus(403);
    $this->actingAs($user)->get('/admin/cars/create')->assertStatus(403);
});

test('guest is redirected to login when accessing admin fleet management', function () {
    $this->get('/admin/cars')->assertRedirect('/login');
});

test('admin can filter fleet list by search query and availability', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    Fleet::factory()->create(['brand' => 'Hyundai', 'model' => 'IONIQ 5', 'plate_number' => 'B 1055 EV', 'availability' => 'available']);
    Fleet::factory()->create(['brand' => 'Toyota', 'model' => 'Avanza', 'plate_number' => 'B 1492 AVZ', 'availability' => 'maintenance']);

    $response = $this->actingAs($admin)->get('/admin/cars?search=IONIQ');
    $response->assertStatus(200);
    $response->assertSee('IONIQ 5');
    $response->assertDontSee('B 1492 AVZ');

    $responseStatus = $this->actingAs($admin)->get('/admin/cars?availability=maintenance');
    $responseStatus->assertStatus(200);
    $responseStatus->assertSee('B 1492 AVZ');
    $responseStatus->assertDontSee('IONIQ 5');
});

test('admin can store new car with primary image and gallery images', function () {
    Storage::fake('public');
    $admin = User::factory()->create(['role' => 'admin']);

    $coverFile = UploadedFile::fake()->create('cover.jpg', 300, 'image/jpeg');
    $gallery1 = UploadedFile::fake()->create('interior.jpg', 200, 'image/jpeg');
    $gallery2 = UploadedFile::fake()->create('rear.jpg', 200, 'image/jpeg');

    $response = $this->actingAs($admin)->post('/admin/cars', [
        'brand' => 'Honda',
        'model' => 'Civic RS Turbo',
        'type' => 'Sedan',
        'year' => 2024,
        'color' => 'Ignite Red Metallic',
        'plate_number' => 'B 9999 HND',
        'transmission' => 'Automatic',
        'fuel_type' => 'Bensin',
        'seat_capacity' => 5,
        'price' => 750000,
        'availability' => 'available',
        'image' => $coverFile,
        'gallery_images' => [$gallery1, $gallery2],
    ]);

    $response->assertRedirect('/admin/cars');
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('fleets', [
        'brand' => 'Honda',
        'model' => 'Civic RS Turbo',
        'plate_number' => 'B 9999 HND',
        'type' => 'Sedan',
        'price' => '750000',
    ]);

    $fleet = Fleet::where('plate_number', 'B 9999 HND')->first();
    expect($fleet)->not->toBeNull();
    Storage::disk('public')->assertExists($fleet->image);
    expect($fleet->images)->toHaveCount(2);
    foreach ($fleet->images as $imgPath) {
        Storage::disk('public')->assertExists($imgPath);
    }
});

test('admin can update car details and gallery', function () {
    Storage::fake('public');
    $admin = User::factory()->create(['role' => 'admin']);
    $car = Fleet::factory()->create([
        'brand' => 'Toyota',
        'model' => 'Innova Reborn',
        'plate_number' => 'B 1234 OLD',
        'price' => '500000',
    ]);

    $response = $this->actingAs($admin)->put("/admin/cars/{$car->id}", [
        'brand' => 'Toyota',
        'model' => 'Innova Reborn 2.4 V Diesel',
        'type' => 'MPV',
        'year' => 2023,
        'color' => 'Hitam Metalik',
        'plate_number' => 'B 1234 NEW',
        'transmission' => 'Manual',
        'fuel_type' => 'Diesel',
        'seat_capacity' => 7,
        'price' => 550000,
        'availability' => 'maintenance',
    ]);

    $response->assertRedirect('/admin/cars');
    $response->assertSessionHas('success');

    $car->refresh();
    expect($car->model)->toBe('Innova Reborn 2.4 V Diesel')
        ->and($car->plate_number)->toBe('B 1234 NEW')
        ->and($car->fuel_type)->toBe('Diesel')
        ->and((int) $car->price)->toBe(550000)
        ->and($car->availability)->toBe('maintenance');
});

test('admin can quick toggle car availability status', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $car = Fleet::factory()->create(['availability' => 'available']);

    $response = $this->actingAs($admin)->patch("/admin/cars/{$car->id}/status", [
        'availability' => 'maintenance',
    ]);

    $response->assertSessionHas('success');
    $car->refresh();
    expect($car->availability)->toBe('maintenance');
});

test('admin cannot delete car when active rentals exist', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $car = Fleet::factory()->create(['plate_number' => 'B 7777 LCK']);

    Rental::factory()->create([
        'fleet_id' => $car->id,
        'status' => 'active',
    ]);

    $response = $this->actingAs($admin)->delete("/admin/cars/{$car->id}");
    $response->assertSessionHas('error');

    $this->assertDatabaseHas('fleets', [
        'id' => $car->id,
        'deleted_at' => null,
    ]);
});

test('admin can soft delete car when no active rentals exist', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $car = Fleet::factory()->create(['plate_number' => 'B 8888 DEL']);

    $response = $this->actingAs($admin)->delete("/admin/cars/{$car->id}");
    $response->assertRedirect('/admin/cars');
    $response->assertSessionHas('success');

    $this->assertSoftDeleted('fleets', [
        'id' => $car->id,
    ]);
});
