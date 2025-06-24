<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'harian'); // default harian

        // Monitoring data transaksi "open"
        $monitoringData = $this->getMonitoringData();

        // Penjualan dan retur (daily/monthly)
        $salesData = $filter === 'bulanan'
            ? $this->getMonthlySalesAndReturns()
            : $this->getDailySalesAndReturns();

        // Transaksi lengkap (untuk chart atau data list)
        $transaksiData = Transaksi::with(['toko', 'produk'])
            ->select('toko_id', 'produk_id', 'created_at', 'transactionDate', 'harga', 'terjual')
            ->when($filter === 'bulanan', function ($query) {
                $query->whereMonth('transactionDate', now()->month)
                      ->whereYear('transactionDate', now()->year);
            })
            ->when($filter === 'harian', function ($query) {
                $query->whereDate('transactionDate', now()->toDateString());
            })
            ->get();

        // --- PERUBAHAN 1: LOGIKA PRODUK MENIPIS ---
        // Produk stok menipis sekarang menggunakan 'batasKritis' dari setiap produk.
        $produkMenipis = Produk::whereColumn('jumlah', '<=', 'batasKritis')->get();


        // --- PERUBAHAN 2: LOGIKA PRODUK TERLARIS YANG MENIPIS ---
        // Query ini HANYA menampilkan produk terlaris yang stoknya sudah di bawah atau sama dengan 'batasKritis'.
        $bestSellers = Produk::select(
                'produk.id',
                'produk.name',
                'produk.jumlah as produk_tersisa',
                'produk.batasKritis', // Opsional: tampilkan juga batas kritisnya di hasil
                DB::raw('SUM(transaksi.terjual) as produk_keluar')
            )
            ->join('transaksi', 'produk.id', '=', 'transaksi.produk_id')
            // Menggunakan whereColumn untuk membandingkan stok dengan batas kritis per produk
            ->whereColumn('produk.jumlah', '<=', 'produk.batasKritis') 
            ->when($filter === 'bulanan', function ($query) {
                return $query->whereMonth('transaksi.transactionDate', now()->month)
                             ->whereYear('transaksi.transactionDate', now()->year);
            })
            ->when($filter === 'harian', function ($query) {
                return $query->whereDate('transaksi.transactionDate', now()->toDateString());
            })
            ->groupBy('produk.id', 'produk.name', 'produk.jumlah', 'produk.batasKritis')
            ->orderBy('produk_keluar', 'desc')
            ->take(10)
            ->get();


        return response()->json([
            'status' => 'success',
            'filter' => $filter,
            'monitoring_data' => $monitoringData,
            'sales_data' => $salesData,
            'produk_menipis' => $produkMenipis,
            'produk_terlaris' => $bestSellers,
            'transaksi' => $transaksiData,
        ]);
    }

    // ... (sisa metode lainnya tidak berubah)
    
    private function getMonthlySalesAndReturns()
    {
        $monthlySales = [];
        $monthlyReturns = [];

        for ($month = 1; $month <= 12; $month++) {
            $sales = Transaksi::whereYear('transactionDate', now()->year)
                ->whereMonth('transactionDate', $month)
                ->sum('terjual');

            $returns = Transaksi::whereYear('transactionDate', now()->year)
                ->whereMonth('transactionDate', $month)
                ->sum(DB::raw('jumlahDibeli - terjual'));

            $monthlySales[] = $sales;
            $monthlyReturns[] = $returns;
        }

        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'sales' => $monthlySales,
            'returns' => $monthlyReturns,
        ];
    }

    private function getDailySalesAndReturns()
    {
        $dailySales = [];
        $dailyReturns = [];
        $labels = [];

        for ($day = 6; $day >= 0; $day--) {
            $date = Carbon::now()->subDays($day);
            $sales = Transaksi::whereDate('transactionDate', $date->toDateString())->sum('terjual');
            $returns = Transaksi::whereDate('transactionDate', $date->toDateString())
                ->sum(DB::raw('jumlahDibeli - terjual'));

            $dailySales[] = $sales;
            $dailyReturns[] = $returns;
            $labels[] = $date->translatedFormat('l'); // Nama hari
        }

        return [
            'labels' => $labels,
            'sales' => $dailySales,
            'returns' => $dailyReturns,
        ];
    }

    private function getMonitoringData()
    {
        $transaksis = Transaksi::with(['produk', 'toko'])
            // ->where('status', 'open')
            ->orderBy('transactionDate', 'desc')
            ->get();

        $data = [];
        foreach ($transaksis as $transaksi) {
            $data[] = [
                'nama_toko' => $transaksi->toko->name ?? 'Tidak ada toko',
                'waktu_edar' =>  $transaksi->waktuEdar ?? 'Tidak ada waktu edar',
                'jumlah' => $transaksi->jumlahDibeli ?? 0,
                'kategori' => $transaksi->produk ? $transaksi->produk->name : 'Tidak ada kategori',
                'hari' => Carbon::parse($transaksi->transactionDate)->translatedFormat('l'),
                'tanggal_keluar' => $transaksi->transactionDate,
                'status' => $transaksi->status,
            ];
        }

        return $data;
    }

    // ... (metode store, show, update, destroy tetap ada di sini)
    public function store(Request $request) { /* ... */ }
    public function show(string $id) { /* ... */ }
    public function update(Request $request, string $id) { /* ... */ }
    public function destroy(string $id) { /* ... */ }
}