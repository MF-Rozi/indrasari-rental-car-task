<?php

use Illuminate\Support\Facades\Route;

// Customer Landing Page
Route::get('/', function () {
    return view('home');
})->name('home');

// Auth (Login & Register Split-Screen)
Route::get('/auth', function () {
    return view('auth.auth');
})->name('auth');

Route::get('/login', function () {
    return view('auth.auth');
})->name('login');

Route::get('/register', function () {
    return view('auth.auth');
})->name('register');

// Customer Fleet Catalog & Details
Route::get('/fleet', function () {
    return view('fleet.index');
})->name('fleet.index');

Route::get('/fleet/{id}', function ($id = 1) {
    return view('fleet.show', ['id' => $id]);
})->name('fleet.show');

// Admin Fleet Management
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/cars', function () {
        return view('admin.cars.index');
    })->name('cars.index');

    Route::get('/cars/create', function () {
        return view('admin.cars.create-edit');
    })->name('cars.create');
});
