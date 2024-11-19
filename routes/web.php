<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SettingController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Route::get('/gudang-owner', function () {
//     return view('gudang-owner');
// })->name('gudang-owner');
Route::get('/gudang-owner', [GudangController::class, 'index'])->name('gudang-owner');
Route::get('/gudang-karyawan', [GudangController::class, 'karyawan'])->name('gudang-karyawan');


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
Route::get('/pemasok/{id}/edit', [PemasokController::class, 'edit'])->name('pemasok.edit');
Route::post('/pemasok/update/{id}', [PemasokController::class, 'update'])->name('pemasok.update');
Route::post('/pemasok/destroy/{id}', [PemasokController::class, 'destroy'])->name('pemasok.destroy');

// Route::get('/transaksi-owner', function () {
//     return view('transaksi-owner');
// })->name('transaksi-owner');
Route::get('/transaksi-owner', [TransaksiController::class, 'index'])->name('transaksi-owner');
Route::get('/transaksi-karyawan', [TransaksiController::class, 'karyawan'])->name('transaksi-karyawan');

// Route::get('/transaksi-karyawan', function () {
//     return view('transaksi-karyawan');
// })->name('transaksi-karyawan');

// Route::get('/manajemen-toko', function () {
//     return view('manajemen-toko');
// })->name('manajemen-toko');
Route::get('/manajemen-toko', [TokoController::class, 'index'])->name('manajemen-toko');

// Route::get('/settings', function () {
//     return view('settings');
// })->name('settings');
Route::get('/settings', [SettingController::class, 'index'])->name('settings');

// Route::get('/login', function () {
//     return view('login');
// })->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('layout.owner');  // Mengarahkan ke owner.blade.php di folder layout
//     })->name('dashboard');

//     Route::get('/gudang-karyawan', function () {
//         return view('layout.karyawan');  // Mengarahkan ke karyawan.blade.php di folder layout
//     })->name('gudang-karyawan');
// });


Route::get('/coba', function () {
    return view('coba');
})->name('lo');
