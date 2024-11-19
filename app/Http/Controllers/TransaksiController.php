<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        return $this->getTransaksiData();
    }

    public function karyawan()
    {
        return $this->getTransaksiDataKaryawan();
    }

    private function getTransaksiData()
    {
        // Fetch all transactions and products
        $transaksis = Transaksi::all();
        $produks = Produk::all();

        // Prepare data for the view
        $data = [];
        foreach ($transaksis as $transaksi) {
            $produk = $produks->random(); // Randomly select a product for demonstration
            $data[] = [
                'total_harga' => $produk->price * rand(1, 100), // Total price (price * random quantity)
                'jumlah' => rand(1, 100), // Random quantity sold
                'produk' => $produk->name,
                'terjual' => rand(1, 100), // Random sold quantity
                'harga' => $produk->price,
                'tanggal_keluar' => $transaksi->transactionDate,
                'tanggal_retur' => now()->addDays(rand(1, 30))->toDateString(), // Random return date
                'waktu_edar' => rand(1, 30), // Random shelf life
                'status' => rand(0, 1) ? 'Open' : 'Closed', // Randomly assign status as 'Open' or 'Closed'
            ];
        }

        return view('transaksi-owner', compact('data'));
    }

    private function getTransaksiDataKaryawan()
    {
        // Fetch all transactions and products
        $transaksis = Transaksi::all();
        $produks = Produk::all();

        // Prepare data for the view
        $data = [];
        foreach ($transaksis as $transaksi) {
            $produk = $produks->random(); // Randomly select a product for demonstration
            $data[] = [
                'total_harga' => $produk->price * rand(1, 100), // Total price (price * random quantity)
                'jumlah' => rand(1, 100), // Random quantity sold
                'produk' => $produk->name,
                'terjual' => rand(1, 100), // Random sold quantity
                'harga' => $produk->price,
                'tanggal_keluar' => $transaksi->transactionDate,
                'tanggal_retur' => now()->addDays(rand(1, 30))->toDateString(), // Random return date
                'waktu_edar' => rand(1, 30), // Random shelf life
                'status' => rand(0, 1) ? 'Open' : 'Closed', // Randomly assign status as 'Open' or 'Closed'
            ];
        }

        return view('transaksi-karyawan', compact('data'));
    }
}