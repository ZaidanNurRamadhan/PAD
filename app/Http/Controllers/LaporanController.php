<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use Carbon\Carbon;
use Mpdf\Mpdf;

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
            // Filter berdasarkan bulan ini
            $query->whereMonth('transactionDate', now()->month)
                  ->whereYear('transactionDate', now()->year);
        } elseif ($filter === 'harian') {
            // Filter berdasarkan hari ini
            $query->whereDate('transactionDate', now()->toDateString());
        }

        // Tambahkan pengurutan berdasarkan ID secara menurun
        $query->orderBy('id', 'desc');

        // $transaksis = $query->paginate(5);
        $transaksis = $query->get();

        $data = [];
        foreach ($transaksis as $transaksi) {
            $retur = 0;
            if ($transaksi->status === 'closed') {
                $retur = max(0, $transaksi->jumlahDibeli - $transaksi->terjual); // Hindari nilai negatif
            }
            $data[] = [
                'toko' => $transaksi->toko->name ?? 'Toko tidak ditemukan',
                'id' => $transaksi->id,
                'produk' => $transaksi->produk->name ?? 'Produk tidak ditemukan',
                'jumlahDibeli' => $transaksi->jumlahDibeli ?? 0,
                'terjual' => $transaksi->terjual,
                'total_harga' => ($transaksi->terjual ?? 0) * ($transaksi->harga ?? 0),
                'harga' => $transaksi->harga,
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
        $data = Transaksi::where('status', 'Closed')->get(); // Ambil data transaksi

        $retur = $data->reduce(function ($carry, $item) {
            return $carry + max(0, $item->jumlahDibeli - $item->terjual);
        }, 0);

        $html = view('pdf.laporan', compact('data', 'retur'))->render(); // Render tampilan ke HTML

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return response()->streamDownload(
            fn() => print($mpdf->Output('', 'S')),
            'Laporan_Transaksi.pdf'
        );
    }
}
