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
        // Fetch all transactions
        $transaksis = Transaksi::all();

        // Prepare data for the view
        $data = [];
        foreach ($transaksis as $transaksi) {
            // Find the product related to the transaction
            $produk = Produk::where('id', $transaksi->id)->first(); // Assuming there's a relation between Transaksi and Produk

            if ($produk) { // Check if product exists
                $data[] = [
                    'total_harga' => $produk->hargaJual * $transaksi->terjual, // Total price (harga jual * terjual)
                    'jumlah' => $produk->jumlah, // Jumlah dari tabel produk
                    'produk' => $produk->name, // Nama produk dari tabel produk
                    'terjual' => $transaksi->terjual, // Terjual dari tabel transaksi
                    'harga' => $produk->hargaBeli, // Harga beli dari tabel produk
                    'tanggal_keluar' => $transaksi->transactionDate, // Tanggal keluar dari tabel transaksi
                    'tanggal_retur' => $transaksi->returDate, // Tanggal retur dari tabel transaksi
                    'waktu_edar' => $transaksi->waktuEdar, // Waktu edar dari tabel transaksi
                    'status' => $transaksi->status, // Status dari tabel transaksi
                ];
            }
        }

        return view('transaksi-owner', compact('data'));
    }

    private function getTransaksiDataKaryawan()
    {
        // Fetch all transactions
        $transaksis = Transaksi::all();

        // Prepare data for the view
        $data = [];
        foreach ($transaksis as $transaksi) {
            $produk = Produk::where('id', $transaksi->id)->first();

            if ($produk) {
                $data[] = [
                    'total_harga' => $produk->hargaJual * $transaksi->terjual, // Total price (harga jual * terjual)
                    'jumlah' => $produk->jumlah, // Jumlah dari tabel produk
                    'produk' => $produk->name, // Nama produk dari tabel produk
                    'terjual' => $transaksi->terjual, // Terjual dari tabel transaksi
                    'harga' => $produk->hargaBeli, // Harga beli dari tabel produk
                    'tanggal_keluar' => $transaksi->transactionDate, // Tanggal keluar dari tabel transaksi
                    'tanggal_retur' => $transaksi->returDate, // Tanggal retur dari tabel transaksi
                    'waktu_edar' => $transaksi->waktuEdar, // Waktu edar dari tabel transaksi
                    'status' => $transaksi->status, // Status dari tabel transaksi
                ];
            }
        }

        return view('transaksi-karyawan', compact('data'));
    }
}