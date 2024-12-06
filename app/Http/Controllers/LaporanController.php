<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter');
        $data = $this->getTransaksiData($filter);
        return view('laporan', compact('data', 'filter'));
    }

    private function getTransaksiData($filter)
    {
        $query = Transaksi::with('produk');

        if ($filter === 'bulanan') {
            // Ambil semua data dan urutkan berdasarkan bulan
            $query->orderByRaw('MONTH(transactionDate) ASC');
        }

        $transaksis = $query->get();

        $data = [];
        foreach ($transaksis as $transaksi) {
            $data[] = [
                'toko' => $transaksi->toko->name ?? 'Toko tidak ditemukan',
                'id' => $transaksi->id,
                'produk' => $transaksi->produk->name ?? 'Produk tidak ditemukan',
                'jumlahDibeli' => $transaksi->jumlahDibeli ?? 0,
                'terjual' => $transaksi->terjual,
                'total_harga' => $transaksi->harga * $transaksi->terjual,
                'harga' => $transaksi->harga,
                'tanggal_keluar' => $transaksi->transactionDate,
                'tanggal_retur' => $transaksi->returDate,
                'waktu_edar' => $transaksi->waktuEdar,
                'status' => $transaksi->status,
            ];
        }

        return $data;
    }
}
