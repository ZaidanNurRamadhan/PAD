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
        $data = $this->getMonitoringData();
        $transaksiData = Transaksi::with(['toko', 'produk'])
            ->select('toko_id', 'created_at', 'transactionDate', 'harga', 'terjual')
            ->get();

        $produkMenipis = Produk::where('jumlah', '<', 20)->get();

        $bestSellers = Transaksi::with('produk')
            ->select('produk_id', DB::raw('SUM(terjual) as total_terjual'))
            ->groupBy('produk_id')
            ->orderBy('total_terjual', 'desc')
            ->take(10)
            ->get();

            // $data = [];
            // foreach ($transaksiData as $transaksi) {
            //     $produk = $transaksi->produk;

            //     $data[] = [
            //         'nama_toko' => $transaksi->toko->name ?? 'Tidak ada toko',
            //         'waktu_edar' =>  $transaksi->waktuEdar ?? 'Tidak ada waktu edar',
            //         'jumlah' => $produk ? $produk->jumlah : 'Produk tidak ditemukan',
            //         'kategori' => $produk ? $produk->category : 'Tidak ada kategori',
            //         'hari' => Carbon::parse($transaksi->transactionDate)->translatedFormat('l'),
            //         'tanggal_keluar' => $transaksi->transactionDate,
            //     ];
            // }
            // dd($data);
        return view('dashboard', compact('data', 'produkMenipis','bestSellers'));
    }
    private function getMonitoringData()
    {
        $transaksis = Transaksi::with('produk')->get();

        $data = [];
        foreach ($transaksis as $transaksi) {
            $data[] = [
                'nama_toko' => $transaksi->toko->name ?? 'Toko tidak ditemukan',
                'kategori' => $transaksi->produk->name ?? 'Produk tidak ditemukan',
                'jumlah' => $transaksi->terjual,
                'tanggal_keluar' => $transaksi->transactionDate,
                'hari' => Carbon::parse($transaksi->transactionDate)->translatedFormat('l'),
                'waktu_edar' => $transaksi->waktuEdar,
                'status' => $transaksi->status,
            ];
        }

        return $data;
    }
}
