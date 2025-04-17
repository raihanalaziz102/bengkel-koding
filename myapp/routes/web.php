<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PeriksaController;
use App\Http\Controllers\PemeriksaanController;

// Landing & Auth (Publik, Tanpa Middleware)
Route::get('/', fn () => view('layout.landing_page'))->name('landing');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk Dokter (Middleware: auth, role:dokter)
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', fn () => view('dokter.index'))->name('dokter.dashboard');
    Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
    Route::post('/obat', [ObatController::class, 'store'])->name('obat.store');
    Route::get('/obat/{id}/edit', [ObatController::class, 'edit'])->name('obat.edit');
    Route::put('/obat/{id}', [ObatController::class, 'update'])->name('obat.update');
    Route::delete('/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');
    Route::get('/memeriksa', [PeriksaController::class, 'index'])->name('dokter.memeriksa');
    Route::get('/periksa/{id}/edit', [PemeriksaanController::class, 'edit'])->name('dokter.periksa.edit');
    Route::post('/periksa/{id}', [PemeriksaanController::class, 'update'])->name('dokter.periksa.update');
    Route::put('/periksa/{id}', [PemeriksaanController::class, 'update'])->name('dokter.periksa.update');
});

// Route untuk Pasien (Middleware: auth, role:pasien)
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', fn () => view('pasien.index'))->name('pasien.dashboard');
    Route::get('/periksa', [PeriksaController::class, 'create'])->name('pasien.periksa.create');
    Route::post('/periksa', [PeriksaController::class, 'store'])->name('pasien.periksa.store');
});