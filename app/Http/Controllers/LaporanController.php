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
        $transaksis = Transaksi::with('produk')->get();

        $data = [];
        foreach ($transaksis as $transaksi) {
            $data[] = [
                'toko' => $transaksi->toko->name ?? 'Toko tidak ditemukan',
                'id' => $transaksi->id,
                'produk' => $transaksi->produk->name ?? 'Produk tidak ditemukan',
                'jumlah_stok' => $transaksi->produk->jumlah ?? 0,
                'terjual' => $transaksi->terjual,
                'total_harga' => $transaksi->amount * $transaksi->terjual,
                'harga' => $transaksi->amount,
                'tanggal_keluar' => $transaksi->transactionDate,
                'tanggal_retur' => $transaksi->returDate,
                'waktu_edar' => $transaksi->waktuEdar,
                'status' => $transaksi->status,
            ];
        }

        return $data;
    }
}
