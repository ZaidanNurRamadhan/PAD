<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Mpdf\Mpdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter'); // 'harian', 'bulanan', atau null
        $data = $this->getTransaksiData($filter);

        return response()->json([
            'message' => 'Data laporan transaksi berhasil diambil.',
            'filter' => $filter,
            'data' => $data
        ], 200);
    }

    private function getTransaksiData($filter)
    {
        $query = Transaksi::with(['produk', 'toko']);

        if ($filter === 'bulanan') {
            $query->whereMonth('transactionDate', now()->month)
                  ->whereYear('transactionDate', now()->year);
        } elseif ($filter === 'harian') {
            $query->whereDate('transactionDate', now()->toDateString());
        }

        $query->orderBy('id', 'desc');
        $transaksis = $query->get();

        $data = [];
        foreach ($transaksis as $transaksi) {
            $retur = 0;
            if ($transaksi->status === 'closed') {
                $retur = max(0, $transaksi->jumlahDibeli - $transaksi->terjual);
            }
            $data[] = [
                'id' => $transaksi->id,
                'toko' => $transaksi->toko->name ?? 'Toko tidak ditemukan',
                'produk' => $transaksi->produk->name ?? 'Produk tidak ditemukan',
                'jumlahDibeli' => $transaksi->jumlahDibeli ?? 0,
                'terjual' => $transaksi->terjual ?? 0,
                'harga' => $transaksi->harga ?? 0,
                'total_harga' => ($transaksi->terjual ?? 0) * ($transaksi->harga ?? 0),
                'tanggal_keluar' => $transaksi->transactionDate,
                'tanggal_retur' => $transaksi->returDate,
                'waktu_edar' => $transaksi->waktuEdar,
                'status' => $transaksi->status,
                'retur' => $retur,
            ];
        }

        return $data;
    }

    public function exportPdf()
    {
        $data = Transaksi::with(['produk', 'toko'])
            ->where('status', 'closed')
            ->get();

        $html = view('export-pdf', compact('data'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return response()->streamDownload(
            fn() => print($mpdf->Output('', 'S')),
            'Laporan_Transaksi.pdf'
        );
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
