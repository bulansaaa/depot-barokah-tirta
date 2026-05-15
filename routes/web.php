<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalRutinController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pelanggan
    Route::resource('pelanggan', PelangganController::class);

    // Produk
    Route::resource('produk', ProdukController::class)->except(['show']);

    // Transaksi
    Route::get('/transaksi/{transaksi}/nota', [TransaksiController::class, 'cetakNota'])->name('transaksi.nota');
    Route::patch('/transaksi/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.status.update');
    Route::resource('transaksi', TransaksiController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

    // Jadwal Rutin
    Route::patch('/jadwal-rutin/{jadwalRutin}/toggle', [JadwalRutinController::class, 'toggleStatus'])->name('jadwal-rutin.toggle');
    Route::resource('jadwal-rutin', JadwalRutinController::class)->except(['show']);

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/harian', [LaporanController::class, 'harian'])->name('laporan.harian');
    Route::get('/laporan/bulanan', [LaporanController::class, 'bulanan'])->name('laporan.bulanan');
    Route::get('/laporan/harian/pdf', [LaporanController::class, 'exportHarianPdf'])->name('laporan.harian.pdf');
    Route::get('/laporan/bulanan/pdf', [LaporanController::class, 'exportBulananPdf'])->name('laporan.bulanan.pdf');
    Route::get('/laporan/nota/{transaksi}/pdf', [LaporanController::class, 'exportNotaPdf'])->name('laporan.nota.pdf');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
