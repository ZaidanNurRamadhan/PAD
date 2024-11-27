<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;

class LaporanController extends Controller
{
    public function index()
    {
        $data = $this->getTransaksiData();
        return view('laporan', compact('data'));
    }

    private function getTransaksiData()
    {
        // Ambil semua data dari tabel transaksi
        $transaksis = Transaksi::all();

        // Siapkan data dalam format yang sama seperti pada TransaksiController
        $data = [];
        foreach ($transaksis as $transaksi) {
            $data[] = [
                'id' => $transaksi->id,
                'total_harga' => $transaksi->amount * $transaksi->terjual, // Total harga dihitung
                'jumlah' => $transaksi->terjual, // Jumlah terjual
                'produk' => $transaksi->nama_produk, // Nama produk langsung dari tabel transaksi
                'terjual' => $transaksi->terjual,
                'harga' => $transaksi->amount, // Harga produk dari amount
                'tanggal_keluar' => $transaksi->transactionDate,
                'tanggal_retur' => $transaksi->returDate,
                'waktu_edar' => $transaksi->waktuEdar,
                'status' => $transaksi->status,
            ];
        }

        return $data;
    }
}
