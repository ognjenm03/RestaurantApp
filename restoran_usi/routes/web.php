<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

// Preusmeri / na /tables, ali samo ako je korisnik ulogovan (auth middleware)
Route::redirect('/', '/tables')->middleware('auth');

// Dashboard ruta, samo za ulogovane i verifikovane
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Dashboard (ovo može da se izbaci jer već imaš gore, ali nije problem)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil korisnika
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tables, Statistics i Bills rute za dashboard sekcije
    Route::get('/tables', [TableController::class, 'index'])->name('tables.index');
     Route::get('/tables/{table}', [TableController::class, 'show'])->name('tables.show');

    // kreiranje porudžbine
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::view('/statistics', 'statistics.index')->name('statistics.index');
    Route::view('/bills', 'bills.index')->name('bills.index');

    // Rute koje može samo Admin (registracija i korisnici)
    Route::middleware('role:Admin')->group(function () {
        // Registracija novih korisnika
        Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
        Route::post('/register', [RegisteredUserController::class, 'store']);

        // Upravljanje korisnicima
        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    });
});

require __DIR__.'/auth.php';