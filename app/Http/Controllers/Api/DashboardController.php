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
        $batas_menipis = 20; // Definisikan batas stok menipis di sini agar mudah diubah

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

        // Produk stok menipis (menggunakan variabel yang sudah didefinisikan)
        $produkMenipis = Produk::where('jumlah', '<', $batas_menipis)->get();


        // --- PERUBAHAN DIMULAI DI SINI ---

        // Produk terlaris yang stoknya menipis
        // Query ini HANYA menampilkan produk terlaris yang stoknya sudah memasuki batas menipis.
        $bestSellers = Produk::select(
                'produk.id',
                'produk.name',
                'produk.jumlah as produk_tersisa',
                DB::raw('SUM(transaksi.terjual) as produk_keluar')
            )
            ->join('transaksi', 'produk.id', '=', 'transaksi.produk_id')
            ->where('produk.jumlah', '<', $batas_menipis) // <-- KONDISI BARU DITAMBAHKAN DI SINI
            ->when($filter === 'bulanan', function ($query) {
                return $query->whereMonth('transaksi.transactionDate', now()->month)
                             ->whereYear('transaksi.transactionDate', now()->year);
            })
            ->when($filter === 'harian', function ($query) {
                return $query->whereDate('transaksi.transactionDate', now()->toDateString());
            })
            ->groupBy('produk.id', 'produk.name', 'produk.jumlah')
            ->orderBy('produk_keluar', 'desc')
            ->take(10)
            ->get();

        // --- PERUBAHAN SELESAI DI SINI ---


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