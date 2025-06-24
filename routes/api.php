<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\MonitoringController;
use App\Http\Controllers\Api\PemasokController;
use App\Http\Controllers\Api\TokoController;
use App\Http\Controllers\Api\GudangController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\SearchController;

Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return response()->json([
        'success' => true,
        'user' => $request->user()
    ]);
});


Route::post('/login', [LoginController::class, 'login'])->name('api.login');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');
Route::post('/forgot-password', [LoginController::class, 'handleForgotPassword'])->name('api.password.email');
Route::post('/validate-token', [LoginController::class, 'handleTokenValidation'])->name('api.password.token');
Route::post('/reset-password', [LoginController::class, 'handleResetPassword'])->name('api.password.reset');

Route::middleware('auth:sanctum', 'check.role:owner')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('api.dashboard');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('api.laporan');
        Route::get('/export-transaksi', [TransaksiController::class, 'export'])->name('api.laporan.export');
        Route::get('/export-pdf', [LaporanController::class, 'exportPdf'])->name('api.laporan.export-pdf');

        // Monitoring Routes
        Route::get('/monitoring', [MonitoringController::class, 'index']);
        Route::get('/monitoring/{id}', [MonitoringController::class, 'show']);

        // Gudang Routes
        Route::get('/gudang', [GudangController::class, 'index']);
        Route::post('/gudang', [GudangController::class, 'store']);
        Route::get('/gudang/{id}', [GudangController::class, 'show']);
        Route::put('/gudang/{id}', [GudangController::class, 'update']);
        Route::delete('/gudang/{id}', [GudangController::class, 'destroy']);

        // Pemasok Routes
        Route::get('/pemasok', [PemasokController::class, 'index']);
        Route::post('/pemasok', [PemasokController::class, 'store']);
        Route::get('/pemasok/{id}', [PemasokController::class, 'show']);
        Route::put('/pemasok/{id}', [PemasokController::class, 'update']);
        Route::delete('/pemasok/{id}', [PemasokController::class, 'destroy']);

        // Toko Routes
        Route::get('/toko', [TokoController::class, 'index']);
        Route::post('/toko', [TokoController::class, 'store']);
        Route::get('/toko/{id}', [TokoController::class, 'show']);
        Route::put('/toko/{id}', [TokoController::class, 'update']);
        Route::delete('/toko/{id}', [TokoController::class, 'destroy']);

        // Transaksi Routes
        Route::get('/transaksi', [TransaksiController::class, 'index']);
        Route::post('/transaksi', [TransaksiController::class, 'store']);
        Route::get('/transaksi/{id}', [TransaksiController::class, 'show']);
        Route::put('/transaksi/{id}', [TransaksiController::class, 'update']);

        // Karyawan Routes (Setting)
        Route::get('/karyawan', [SettingController::class, 'index']);
        Route::post('/karyawan', [SettingController::class, 'store']);
        Route::get('/karyawan/{id}', [SettingController::class, 'show']);
        Route::put('/karyawan/{id}', [SettingController::class, 'update']);
        Route::delete('/karyawan/{id}', [SettingController::class, 'destroy']);
});

Route::middleware('auth:sanctum','check.role:karyawan')->group(function () {
    Route::get('/gudang-karyawan', [GudangController::class, 'karyawan'])->name('api.gudang.karyawan');

    // Transaksi Routes for Karyawan
    Route::get('/transaksi-karyawan', [TransaksiController::class, 'getKaryawan'])->name('api.transaksi.karyawan');
    Route::post('/transaksi-karyawan', [TransaksiController::class, 'postKaryawan'])->name('api.transaksi.karyawan.store');
    Route::get('/transaksi-karyawan/{id}', [TransaksiController::class, 'showKaryawan'])->name('api.transaksi.karyawan.show');
    Route::put('/transaksi-karyawan/{id}', [TransaksiController::class, 'updateKaryawan'])->name('api.transaksi.karyawan.update');
});

Route::get('/search', [SearchController::class, 'search'])->name('api.search');