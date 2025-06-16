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

        // --- PERUBAHAN DIMULAI DI SINI ---

        // Produk terlaris
        // Query ini diubah untuk mengambil stok dari tabel 'produk' dan total penjualan dari 'transaksi'.
        $bestSellers = Produk::select(
                'produk.id',
                'produk.name',
                'produk.jumlah as produk_tersisa', // Mengambil stok tersisa dari gudang (tabel produk)
                DB::raw('SUM(transaksi.terjual) as produk_keluar') // Menjumlahkan total produk terjual dari transaksi
            )
            ->join('transaksi', 'produk.id', '=', 'transaksi.produk_id')
            ->when($filter === 'bulanan', function ($query) {
                // Filter berdasarkan bulan dan tahun saat ini dari tabel transaksi
                return $query->whereMonth('transaksi.transactionDate', now()->month)
                             ->whereYear('transaksi.transactionDate', now()->year);
            })
            ->when($filter === 'harian', function ($query) {
                // Filter berdasarkan tanggal hari ini dari tabel transaksi
                return $query->whereDate('transaksi.transactionDate', now()->toDateString());
            })
            ->groupBy('produk.id', 'produk.name', 'produk.jumlah') // Group by untuk agregasi yang benar
            ->orderBy('produk_keluar', 'desc') // Urutkan berdasarkan produk yang paling banyak keluar (terjual)
            ->take(10)
            ->get();

        // --- PERUBAHAN SELESAI DI SINI ---


        return response()->json([
            'status' => 'success',
            'filter' => $filter,
            'monitoring_data' => $monitoringData,
            'sales_data' => $salesData,
            'produk_menipis' => $produkMenipis,
            'produk_terlaris' => $bestSellers, // Data ini sekarang berisi 'produk_tersisa' and 'produk_keluar'
            'transaksi' => $transaksiData,
        ]);
    }

    private function getMonthlySalesAndReturns()
    {
        $monthlySales = [];
        $monthlyReturns = [];

        for ($month = 1; $month <= 12; $month++) {
            // Menambahkan filter tahun agar data akurat untuk tahun berjalan
            $sales = Transaksi::whereYear('transactionDate', now()->year)
                ->whereMonth('transactionDate', $month)
                ->sum('terjual');

            // Menambahkan filter tahun untuk perhitungan retur
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
            // ->where('status', 'open') // Komentar ini dipertahankan sesuai kode asli
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