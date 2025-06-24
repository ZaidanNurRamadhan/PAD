<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'harian');
        $data = $this->getMonitoringData($filter);

        // Ambil data penjualan dan retur
        if ($filter === 'bulanan') {
            $salesData = $this->getMonthlySalesAndReturns();
        } else {
            $salesData = $this->getDailySalesAndReturns();
        }

        $transaksiData = Transaksi::with(['toko', 'produk'])
            ->select('toko_id', 'created_at', 'transactionDate', 'harga', 'terjual');

            if ($filter === 'bulanan') {
                $transaksiData->whereMonth('transactionDate', now()->month)
                              ->whereYear('transactionDate', now()->year);
            } else {
                $transaksiData->whereDate('transactionDate', now()->toDateString());
            }

            $transaksiData = $transaksiData->get();
        
        $produkMenipis = Produk::where('jumlah', '<', 20)->get();

        $bestSellers = Transaksi::with('produk')
            ->select('produk_id', DB::raw('SUM(terjual) as total_terjual'))
            ->when($filter === 'bulanan', function ($query) {
                return $query->whereMonth('transactionDate', now()->month)
                             ->whereYear('transactionDate', now()->year);
            })
            ->when($filter === 'harian', function ($query) {
                return $query->whereDate('transactionDate', now()->toDateString());
            })
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
        return view('dashboard', compact('data', 'produkMenipis','bestSellers', 'filter', 'salesData'));
    }

    private function getMonthlySalesAndReturns()
    {
        $monthlySales = [];
        $monthlyReturns = [];

        for ($month = 1; $month <= 12; $month++) {
            $sales = Transaksi::whereMonth('transactionDate', $month)
                ->sum('terjual');

            $returns = Transaksi::whereMonth('transactionDate', $month)
                ->sum(DB::raw('jumlahDibeli - terjual'));

            $monthlySales[] = $sales;
            $monthlyReturns[] = $returns;
        }

        return [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'sales' => $monthlySales,
            'returns' => $monthlyReturns,
        ];
    }

    private function getDailySalesAndReturns()
    {
        $dailySales = [];
        $dailyReturns = [];

        for ($day = 0; $day < 7; $day++) {
            $sales = Transaksi::whereDate('transactionDate', Carbon::now()->subDays($day)->toDateString())
                ->sum('terjual');

            $returns = Transaksi::whereDate('transactionDate', Carbon::now()->subDays($day)->toDateString())
                ->sum(DB::raw('jumlahDibeli - terjual'));

            $dailySales[] = $sales;
            $dailyReturns[] = $returns;
        }

        return [
            'labels' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            'sales' => array_reverse($dailySales), // Reverse to match the order of days
            'returns' => array_reverse($dailyReturns),
        ];
    }

    private function getMonitoringData()
    {
        $transaksis = Transaksi::with('produk')
            ->where('status', 'open') // Hanya ambil transaksi dengan status "open"
            ->get();

        $data = [];
        foreach ($transaksis as $transaksi) {
            $data[] = [
                'nama_toko' => $transaksi->toko->name ?? 'Toko tidak ditemukan',
                'kategori' => $transaksi->produk->name ?? 'Produk tidak ditemukan',
                'jumlah' => $transaksi->jumlahDibeli,
                'tanggal_keluar' => $transaksi->transactionDate,
                'hari' => Carbon::parse($transaksi->transactionDate)->translatedFormat('l'),
                'waktu_edar' => $transaksi->waktuEdar,
                'status' => $transaksi->status,
            ];
        }

        return $data;
    }
}