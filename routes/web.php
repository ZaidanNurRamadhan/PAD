<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route::get('/gudang-owner', function () {
//     return view('gudang-owner');
// })->name('gudang-owner');
Route::get('/gudang-owner', [GudangController::class, 'index'])->name('gudang-owner');
Route::get('/gudang-karyawan', [GudangController::class, 'karyawan'])->name('gudang-karyawan');
Route::post('/gudang/store', [GudangController::class, 'store'])->name('gudang.store');
Route::put('/gudang/update/{id}', [GudangController::class, 'update'])->name('gudang.update');
Route::delete('/gudang/destroy/{id}', [GudangController::class, 'destroy'])->name('gudang.destroy');


// Route::get('/gudang-karyawan', function () {
//     return view('gudang-karyawan');
// })->name('gudang-karyawan');

// Route::get('/laporan', function () {
//     return view('laporan');
// })->name('laporan');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

// Route::get('/pemasok', function () {
//     return view('pemasok');
// })->name('pemasok');
Route::get('/pemasok', [PemasokController::class, 'index'])->name('pemasok');
Route::post('/pemasok/store', [PemasokController::class, 'store'])->name('pemasok.store');
Route::post('/pemasok/update/{id}', [PemasokController::class, 'update'])->name('pemasok.update');
Route::post('/pemasok/destroy/{id}', [PemasokController::class, 'destroy'])->name('pemasok.destroy');


// Route::get('/transaksi-owner', function () {
//     return view('transaksi-owner');
// })->name('transaksi-owner');
Route::get('/transaksi-owner', [TransaksiController::class, 'index'])->name('transaksi-owner');
Route::get('/transaksi-karyawan', [TransaksiController::class, 'karyawan'])->name('transaksi-karyawan');
Route::prefix('transaksi')->group(function () {
    Route::get('/create', [TransaksiController::class, 'create'])->name('transaksi.create'); // Menampilkan form create
    Route::post('/store', [TransaksiController::class, 'store'])->name('transaksi.store');  // Menyimpan data baru
    Route::get('/edit/{id}', [TransaksiController::class, 'edit'])->name('transaksi.edit'); // Menampilkan form edit
    Route::put('/update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update'); // Memperbarui data
    Route::delete('/destroy/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy'); // Menghapus data
});

// Route::get('/transaksi-karyawan', function () {
//     return view('transaksi-karyawan');
// })->name('transaksi-karyawan');

// Route::get('/manajemen-toko', function () {
//     return view('manajemen-toko');
// })->name('manajemen-toko');
Route::get('/manajemen-toko', [TokoController::class, 'index'])->name('manajemen-toko');
Route::get('/toko', [TokoController::class, 'index'])->name('toko.index');
Route::post('/toko', [TokoController::class, 'store'])->name('toko.store');
Route::get('/toko/{toko}/edit', [TokoController::class, 'edit'])->name('toko.edit');
Route::put('/toko/{toko}', [TokoController::class, 'update'])->name('toko.update');
Route::delete('/toko/{toko}', [TokoController::class, 'destroy'])->name('toko.destroy');

// Route::get('/settings', function () {
//     return view('settings');
// })->name('settings');
Route::get('/settings', [SettingController::class, 'index'])->name('settings');
Route::prefix('karyawan')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('karyawan.index'); // Read
    Route::post('/store', [SettingController::class, 'store'])->name('karyawan.store'); // Create
    Route::post('/update/{id}', [SettingController::class, 'update'])->name('karyawan.update'); // Update
    Route::post('/destroy/{id}', [SettingController::class, 'destroy'])->name('karyawan.destroy'); // Delete
});

// Route::get('/login', function () {
//     return view('login');
// })->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::middleware('auth')->group(function () {
//     Route::middleware('role:owner')->group(function () {
//         Route::get('/dashboard', function () {
//             return view('layout.owner'); // Halaman owner
//         })->name('dashboard');
//     });

//     Route::middleware('role:karyawan')->group(function () {
//         Route::get('/transaksi-karyawan', function () {
//             return view('layout.karyawan'); // Halaman karyawan
//         })->name('transaksi-karyawan');
//     });
// });


// Route::get('/coba', function () {
//     return view('coba');
// })->name('lo');
