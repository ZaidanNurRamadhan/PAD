<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $transaksiData = Transaksi::with(['toko', 'produk'])
            ->select('toko_id', 'waktuEdar', 'transactionDate', 'amount', 'terjual')
            ->get();

        $produkMenipis = Produk::where('jumlah', '<', 20)->get();

        $bestSellers = Transaksi::with('produk')
            ->select('produk_id', DB::raw('SUM(terjual) as total_terjual'))
            ->groupBy('produk_id')
            ->orderBy('total_terjual', 'desc')
            ->take(10)
            ->get();

        $data = [];
        foreach ($transaksiData as $transaksi) {
            $data[] = [
                'nama_toko' => $transaksi->toko->name,
                'waktu_edar' => $transaksi->waktuEdar,
                'jumlah' => $transaksi->produk->jumlah,
                'kategori' => $transaksi->produk->category,
                'hari' => Carbon::parse($transaksi->transactionDate)->translatedFormat('l'),
                'tanggal_keluar' => $transaksi->transactionDate,
            ];
        }

        return view('dashboard', compact('data', 'produkMenipis'));
    }
}
