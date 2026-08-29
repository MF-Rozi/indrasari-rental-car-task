<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. Public Browsing Routes (No login required)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/fleet', [FleetController::class, 'publicIndex'])->name('fleet.index');
Route::get('/fleet/{car}', [FleetController::class, 'publicShow'])->name('fleet.show');

/*
|--------------------------------------------------------------------------
| 2. Guest Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'auth'])->name('login.post');

    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.post');

    Route::get('/auth', [AuthController::class, 'login'])->name('auth');
});

/*
|--------------------------------------------------------------------------
| 3. Customer Protected Routes (Requires logged in user)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/rentals', function () {
        return view('rentals.index');
    })->name('rentals.index');

    Route::get('/returns', function () {
        return view('returns.index');
    })->name('returns.index');

    Route::get('/profile', [UserController::class, 'show'])->name('profile.index');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password.update');
});

/*
|--------------------------------------------------------------------------
| 4. Admin Management Routes (Requires logged in user with role=admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard.index');
    })->name('dashboard');

    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('dashboard.index');

    Route::get('/cars', [FleetController::class, 'index'])->name('cars.index');
    Route::get('/cars/create', [FleetController::class, 'create'])->name('cars.create');
    Route::post('/cars', [FleetController::class, 'store'])->name('cars.store');
    Route::get('/cars/{car}/edit', [FleetController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{car}', [FleetController::class, 'update'])->name('cars.update');
    Route::delete('/cars/{car}', [FleetController::class, 'destroy'])->name('cars.destroy');
    Route::patch('/cars/{car}/status', [FleetController::class, 'updateStatus'])->name('cars.status');

    Route::get('/rentals', function () {
        return view('admin.rentals.index');
    })->name('rentals.index');

    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');
});
