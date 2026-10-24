<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BendunganController;
use App\Http\Controllers\DaerahIrigasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmbungController;
use App\Http\Controllers\KelembagaanController;
use App\Http\Controllers\PaketPekerjaanController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RealisasiFisikKeuanganController;
use App\Http\Controllers\SungaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('daerah-irigasi/print-all', [DaerahIrigasiController::class, 'printAll'])->name('daerah-irigasi.print-all');
    Route::get('daerah-irigasi/export-all', [DaerahIrigasiController::class, 'exportAll'])->name('daerah-irigasi.export-all');
    Route::get('daerah-irigasi/{id}/print', [DaerahIrigasiController::class, 'print'])->name('daerah-irigasi.print');
    Route::get('daerah-irigasi/{id}/export', [DaerahIrigasiController::class, 'export'])->name('daerah-irigasi.export');

    Route::get('embung/{id}/print', [EmbungController::class, 'print'])->name('embung.print');
    Route::get('embung/{id}/export', [EmbungController::class, 'export'])->name('embung.export');

    Route::get('bendungan/{id}/print', [BendunganController::class, 'print'])->name('bendungan.print');
    Route::get('bendungan/{id}/export', [BendunganController::class, 'export'])->name('bendungan.export');

    Route::get('sungai/{id}/print', [SungaiController::class, 'print'])->name('sungai.print');
    Route::get('sungai/{id}/export', [SungaiController::class, 'export'])->name('sungai.export');

    Route::get('paket-pekerjaan/{id}/print', [PaketPekerjaanController::class, 'print'])->name('paket-pekerjaan.print');
    Route::get('paket-pekerjaan/{id}/export', [PaketPekerjaanController::class, 'export'])->name('paket-pekerjaan.export');

    Route::get('kelembagaan/{id}/print', [KelembagaanController::class, 'print'])->name('kelembagaan.print');
    Route::get('kelembagaan/{id}/export', [KelembagaanController::class, 'export'])->name('kelembagaan.export');

    Route::get('perencanaan/{id}/print', [PerencanaanController::class, 'print'])->name('perencanaan.print');
    Route::get('perencanaan/{id}/export', [PerencanaanController::class, 'export'])->name('perencanaan.export');

    Route::get('realisasi/{id}/print', [RealisasiFisikKeuanganController::class, 'print'])->name('realisasi.print');
    Route::get('realisasi/{id}/export', [RealisasiFisikKeuanganController::class, 'export'])->name('realisasi.export');

    Route::resource('daerah-irigasi', DaerahIrigasiController::class);
    Route::resource('embung', EmbungController::class);
    Route::resource('bendungan', BendunganController::class);
    Route::resource('sungai', SungaiController::class);
    Route::resource('paket-pekerjaan', PaketPekerjaanController::class);
    Route::resource('kelembagaan', KelembagaanController::class);
    Route::resource('perencanaan', PerencanaanController::class);
    Route::resource('realisasi', RealisasiFisikKeuanganController::class);
});
