<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PemasokController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/gudang-owner', function () {
    return view('gudang-owner');
})->name('gudang-owner');

Route::get('/gudang-karyawan', function () {
    return view('gudang-karyawan');
})->name('gudang-karyawan');

Route::get('/laporan', function () {
    return view('laporan');
})->name('laporan');

// Route::get('/pemasok', function () {
//     return view('pemasok');
// })->name('pemasok');
Route::get('/pemasok', [PemasokController::class, 'index'])->name('pemasok');
Route::post('/pemasok/store', [PemasokController::class, 'store'])->name('pemasok.store');
Route::get('/pemasok/{id}/edit', [PemasokController::class, 'edit'])->name('pemasok.edit');
Route::post('/pemasok/update/{id}', [PemasokController::class, 'update'])->name('pemasok.update');
Route::post('/pemasok/destroy/{id}', [PemasokController::class, 'destroy'])->name('pemasok.destroy');

Route::get('/transaksi-owner', function () {
    return view('transaksi-owner');
})->name('transaksi-owner');

Route::get('/transaksi-karyawan', function () {
    return view('transaksi-karyawan');
})->name('transaksi-karyawan');

Route::get('/manajemen-toko', function () {
    return view('manajemen-toko');
})->name('manajemen-toko');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

<<<<<<< HEAD
// Route::get('/login', function () {
//     return view('login');
// })->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/gudang-karyawan', function () {
        return view('gudang-karyawan');
    })->name('gudang-karyawan');
});

Route::get('/coba', function () {
    return view('coba');
})->name('lo');
=======
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/monitoring', function () {
    return view('monitoring');
})->name('monitoring');
>>>>>>> 3260a7cb04a6a20fa917acd674467c36de27fc4b
