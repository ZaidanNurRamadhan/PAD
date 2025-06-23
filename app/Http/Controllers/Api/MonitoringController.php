<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::with('produk', 'toko')
            ->where('status', 'open')
            ->orderBy('id', 'desc')
            ->paginate(10); // Optional: Adjust pagination as needed

        $data = $transaksis->map(function ($transaksi) {
            return [
                'nama_toko' => $transaksi->toko->name ?? 'Tidak ada toko',
                'waktu_edar' =>  $transaksi->waktuEdar ?? 'Tidak ada waktu edar',
                'jumlah' => $transaksi->jumlahDibeli ?? 0,
                'kategori' => $transaksi ? $transaksi->produk->name : 'Tidak ada kategori',
                'hari' => Carbon::parse($transaksi->transactionDate)->translatedFormat('l'),
                'tanggal_keluar' => $transaksi->transactionDate,
                'status' => $transaksi->status,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Data monitoring berhasil diambil.',
            'data' => $data,
            'pagination' => [
                'current_page' => $transaksis->currentPage(),
                'last_page' => $transaksis->lastPage(),
                'per_page' => $transaksis->perPage(),
                'total' => $transaksis->total(),
            ]
        ]);
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
        $transaksi = Transaksi::with('produk', 'toko')->find($id);

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        $data = [
            'nama_toko' => $transaksi->toko->name ?? 'Toko tidak ditemukan',
            'kategori' => $transaksi->produk->name ?? 'Produk tidak ditemukan',
            'jumlah' => $transaksi->jumlahDibeli,
            'tanggal_keluar' => $transaksi->transactionDate,
            'hari' => Carbon::parse($transaksi->transactionDate)->translatedFormat('l'),
            'waktu_edar' => $transaksi->waktuEdar,
            'status' => $transaksi->status,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Detail transaksi berhasil diambil.',
            'data' => $data
        ]);
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
