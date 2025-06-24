<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $transaksis = Transaksi::with('produk', 'toko')->orderBy('id', 'desc')->paginate(5);

        // $data = [];
        // foreach ($transaksis as $transaksi) {
        //     $data[] = [
        //         'nama_toko' => $transaksi->toko->name ?? 'Toko tidak ditemukan',
        //         'kategori' => $transaksi->produk->name ?? 'Produk tidak ditemukan',
        //         'jumlah' => $transaksi->terjual,
        //         'tanggal_keluar' => $transaksi->transactionDate,
        //         'hari' => Carbon::parse($transaksi->transactionDate)->translatedFormat('l'),
        //         'waktu_edar' => $transaksi->waktuEdar,
        //         'status' => $transaksi->status,
        //     ];
        // }
        // return view('Monitoring', compact('data', 'transaksis'));

        $transaksis = Transaksi::with('produk', 'toko')
            ->where('status', 'open') // Hanya ambil transaksi dengan status "open"
            ->orderBy('id', 'desc')
            ->paginate(5);

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
        return view('Monitoring', compact('data', 'transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
