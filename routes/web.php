<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/pemasok', function () {
    return view('pemasok');
})->name('pemasok');

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

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/monitoring', function () {
    return view('monitoring');
})->name('monitoring');
