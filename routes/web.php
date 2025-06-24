<?php

use App\Http\Controllers\MonitoringController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'loginWeb'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logoutWeb'])->name('logout');
Route::get('/lupa-password',[LoginController::class, 'lupa_password'])->name('lupa-password');
Route::post('/lupa-password-aksi',[LoginController::class, 'lupa_password_aksi'])->name('lupa-password-aksi');


Route::middleware('auth:sanctum', 'check.role:owner')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('export-transaksi', action: [TransaksiController::class, 'export'])->name('laporan.export');
    Route::get('export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
    Route::resource('monitoring',MonitoringController::class);

    Route::get('/gudang-owner', [GudangController::class, 'index'])->name('gudang-owner');
    Route::prefix('gudang')->group(function(){
        Route::post('/store', [GudangController::class, 'store'])->name('gudang.store');
        // Route::put('/update/{id}', [GudangController::class, 'update'])->name('gudang.update');
        Route::delete('/destroy/{id}', [GudangController::class, 'destroy'])->name('gudang.destroy');
    });
    Route::put('/gudang/update/{id}', [GudangController::class, 'update'])->name('gudang.update');


    Route::get('/pemasok', [PemasokController::class, 'index'])->name('pemasok');
    Route::prefix('pemasok')->group(function(){
        Route::post('/store', [PemasokController::class, 'store'])->name('pemasok.store');
        Route::get('/{id}/edit', [PemasokController::class, 'edit'])->name('pemasok.edit');
        Route::delete('/destroy/{id}', [PemasokController::class, 'destroy'])->name('pemasok.destroy');
        Route::put('/{id}', [PemasokController::class, 'update'])->name('pemasok.update');
    });
    // Route::post('/pemasok/store', [PemasokController::class, 'store'])->name('pemasok.store');
    // Route::get('/pemasok/{id}/edit', [PemasokController::class, 'edit'])->name('pemasok.edit');
    // Route::delete('/pemasok/destroy/{id}', [PemasokController::class, 'destroy'])->name('pemasok.destroy');
    // Route::put('/pemasok/{id}', [PemasokController::class, 'update'])->name('pemasok.update');

    Route::get('/transaksi-owner', [TransaksiController::class, 'index'])->name('transaksi-owner');
    Route::prefix('transaksi')->group(function () {
        Route::get('/create', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/store', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
        Route::put('/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
        Route::delete('/destroy/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    });

    Route::get('/manajemen-toko', [TokoController::class, 'index'])->name('manajemen-toko');
    Route::prefix('toko')->group(function(){
        Route::get('/{toko}/edit', [TokoController::class, 'edit'])->name('toko.edit');
        Route::put('/{toko}', [TokoController::class, 'update'])->name('toko.update');
        Route::delete('/destroy/{toko}', [TokoController::class, 'destroy'])->name('toko.destroy');
    });
    Route::get('/toko', [TokoController::class, 'index'])->name('toko.index');
    Route::post('/toko', [TokoController::class, 'store'])->name('toko.store');
    // Route::get('/toko/{toko}/edit', [TokoController::class, 'edit'])->name('toko.edit');
    // Route::put('/toko/{toko}', [TokoController::class, 'update'])->name('toko.update');
    // Route::delete('/toko/destroy/{toko}', [TokoController::class, 'destroy'])->name('toko.destroy');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::prefix('karyawan')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('karyawan.index');
        Route::post('/store', [SettingController::class, 'store'])->name('karyawan.store');
        Route::put('/{id}', [SettingController::class, 'update'])->name('karyawan.update');
        Route::delete('/destroy/{id}', [SettingController::class, 'destroy'])->name('karyawan.destroy');
    });
});

Route::middleware('auth:sanctum', 'check.role:karyawan')->group(function () {
    Route::get('/gudang-karyawan',  [GudangController::class, 'karyawan'])->name('gudang-karyawan');
    Route::get('/transaksi-karyawan', [TransaksiController::class, 'karyawan'])->name('transaksi-karyawan');
    Route::prefix('transaksi')->group(function () {
        Route::get('/create', [TransaksiController::class, 'create'])->name('transaksi.create');
        Route::post('/store', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
        Route::put('/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
        Route::delete('/destroy/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    });
});



// Route untuk halaman Forgot Password
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.forgot');

// Route untuk menangani form email submit
Route::post('/forgot-password', [LoginController::class, 'handleForgotPassword'])->name('password.email.submit');

// Route untuk halaman memasukkan token
Route::get('/token-lupa-password', [LoginController::class, 'showTokenLupaPasswordForm'])->name('password.token.form');

// Route untuk menangani submit token
Route::post('/validate-token', [LoginController::class, 'handleTokenValidation'])->name('password.token.submit');

// Route untuk halaman reset password
Route::get('/reset-password', [LoginController::class, 'showResetPasswordForm'])->name('password.reset');

// Route untuk menangani submit password baru
Route::post('/reset-password', [LoginController::class, 'handleResetPassword'])->name('password.reset.submit');
