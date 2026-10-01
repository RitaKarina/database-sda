<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DaerahIrigasiController;
use App\Http\Controllers\EmbungController;
use App\Http\Controllers\BendunganController;
use App\Http\Controllers\SungaiController;
use App\Http\Controllers\PaketPekerjaanController;
use App\Http\Controllers\KelembagaanController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\RealisasiFisikKeuanganController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

// Route Tambahan Export
Route::get('daerah-irigasi/{id}/export', [DaerahIrigasiController::class, 'export'])->name('daerah-irigasi.export');

// Route Modul Utama SDA
Route::resource('daerah-irigasi', DaerahIrigasiController::class);
Route::resource('embung', EmbungController::class);
Route::resource('bendungan', BendunganController::class);
Route::resource('sungai', SungaiController::class);
Route::resource('paket-pekerjaan', PaketPekerjaanController::class);
Route::resource('kelembagaan', KelembagaanController::class);
Route::resource('perencanaan', PerencanaanController::class);
Route::resource('realisasi', RealisasiFisikKeuanganController::class);