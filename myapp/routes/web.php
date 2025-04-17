<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PeriksaController;
use App\Http\Controllers\PemeriksaanController;
// Landing & Auth
Route::get('/', fn () => view('layout.landing_page'));
Route::get('/login', fn () => view('layout.login'))->name('login');
Route::get('/register', fn () => view('layout.register'))->name('register');

// Dokter Dashboard
Route::get('/dokter/dashboard', fn () => view('dokter.index'))->name('dokter.dashboard');

// Obat (Dokter CRUD)
Route::get('/dokter/obat', [ObatController::class, 'index'])->name('obat.index');
Route::post('/dokter/obat', [ObatController::class, 'store'])->name('obat.store');
Route::get('/dokter/obat/{id}/edit', [ObatController::class, 'edit'])->name('obat.edit');
Route::put('/dokter/obat/{id}', [ObatController::class, 'update'])->name('obat.update');
Route::delete('/dokter/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');

// Dokter Memeriksa (list pasien yang buat janji)
Route::get('/dokter/memeriksa', [PeriksaController::class, 'index'])->name('dokter.memeriksa');

// Dokter Form Pemeriksaan (edit catatan dan obat)
Route::get('/dokter/periksa/{id}/edit', [PemeriksaanController::class, 'edit'])->name('dokter.periksa.edit');
Route::post('/dokter/periksa/{id}', [PemeriksaanController::class, 'update'])->name('dokter.periksa.update');
Route::put('/dokter/periksa/{id}', [PemeriksaanController::class, 'update'])->name('dokter.periksa.update');


// Pasien Dashboard
Route::get('/pasien/dashboard', fn () => view('pasien.index'))->name('pasien.dashboard');

// Pasien Buat Janji Periksa
Route::get('/pasien/periksa', [PeriksaController::class, 'create'])->name('pasien.periksa.create');
Route::post('/pasien/periksa', [PeriksaController::class, 'store'])->name('pasien.periksa.store');

Route::get('/pasien/riwayat', [PeriksaController::class, 'riwayat'])->name('pasien.riwayat');
