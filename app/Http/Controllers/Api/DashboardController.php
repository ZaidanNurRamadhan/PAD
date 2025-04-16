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

        // Produk stok menipis
        $produkMenipis = Produk::where('jumlah', '<', 20)->get();

        // Produk terlaris
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
            ->where('status', 'open')
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
