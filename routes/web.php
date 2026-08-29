<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public & Customer Routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('login.post');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/auth', [AuthController::class, 'login'])->name('auth');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::get('/fleet', function () {
    return view('fleet.index');
})->name('fleet.index');

Route::get('/fleet/{id}', function ($id) {
    return view('fleet.show', ['carId' => $id]);
})->name('fleet.show');

Route::get('/rentals', function () {
    return view('rentals.index');
})->name('rentals.index');

Route::get('/returns', function () {
    return view('returns.index');
})->name('returns.index');

Route::get('/profile', function () {
    return view('profile.index');
})->name('profile.index');

// Admin Management Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');

    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('dashboard.index');

    Route::get('/cars', function () {
        return view('admin.cars.index');
    })->name('cars.index');

    Route::get('/cars/create', function () {
        return view('admin.cars.create-edit');
    })->name('cars.create');

    Route::get('/cars/{id}/edit', function ($id) {
        return view('admin.cars.create-edit', ['carId' => $id]);
    })->name('cars.edit');

    Route::get('/rentals', function () {
        return view('admin.rentals.index');
    })->name('rentals.index');

    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');
});
