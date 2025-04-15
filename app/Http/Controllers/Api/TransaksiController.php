<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::with('produk', 'toko')->orderBy('id', 'desc')->get();

        $data = $transaksis->map(function ($transaksi) {
            return [
                'id' => $transaksi->id,
                'toko_id' => $transaksi->toko_id,
                'produk_id' => $transaksi->produk_id,
                'toko' => $transaksi->toko->name ?? 'Toko tidak ditemukan',
                'produk' => $transaksi->produk->name ?? 'Produk tidak ditemukan',
                'jumlahDibeli' => $transaksi->jumlahDibeli,
                'terjual' => $transaksi->terjual,
                'total_harga' => $transaksi->harga * $transaksi->terjual,
                'harga' => $transaksi->harga,
                'tanggal_keluar' => $transaksi->transactionDate,
                'tanggal_retur' => $transaksi->returDate,
                'waktu_edar' => $transaksi->waktuEdar,
                'status' => $transaksi->status,
            ];
        });

        return response()->json(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'toko_id' => 'required|exists:toko,id',
            'produk_id' => 'required|exists:produk,id',
            'jumlahDibeli' => 'required|numeric|min:1',
            'harga' => 'required|numeric|min:0',
            'terjual' => 'nullable|numeric|min:0',
            'tanggal_keluar' => 'required|date',
            'tanggal_retur' => 'nullable|date|after_or_equal:tanggal_keluar',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $produk = Produk::find($request->produk_id);

        if ($produk->jumlah < $request->jumlahDibeli) {
            return response()->json(['message' => 'Jumlah produk tidak mencukupi.'], 400);
        }

        $waktuEdar = $request->tanggal_retur
            ? (strtotime($request->tanggal_retur) - strtotime($request->tanggal_keluar)) / (60 * 60 * 24)
            : null;

        $status = $request->tanggal_retur ? 'closed' : 'open';

        $transaksi = Transaksi::create([
            'toko_id' => $request->toko_id,
            'produk_id' => $request->produk_id,
            'transactionDate' => $request->tanggal_keluar,
            'returDate' => $request->tanggal_retur,
            'jumlahDibeli' => $request->jumlahDibeli,
            'harga' => $request->harga,
            'terjual' => $request->terjual,
            'waktuEdar' => $waktuEdar,
            'status' => $status,
        ]);

        // Update stok
        $produk->decrement('jumlah', $request->jumlahDibeli);
        if ($request->tanggal_retur) {
            $produk->increment('jumlah', ($request->jumlahDibeli - $request->terjual));
        }

        return response()->json(['message' => 'Transaksi berhasil ditambahkan', 'data' => $transaksi], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::with('produk', 'toko')->find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json(['data' => $transaksi], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaksi = Transaksi::find($id);
        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'toko_id' => 'required|exists:toko,id',
            'produk_id' => 'required|exists:produk,id',
            'jumlahDibeli' => 'required|numeric|min:1',
            'harga' => 'required|numeric|min:0',
            'terjual' => 'required|numeric|min:0',
            'tanggal_keluar' => 'required|date',
            'tanggal_retur' => 'nullable|date|after_or_equal:tanggal_keluar',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $produk = Produk::find($request->produk_id);
        $produk->increment('jumlah', $transaksi->jumlahDibeli);

        if ($produk->jumlah < $request->jumlahDibeli) {
            return response()->json(['message' => 'Jumlah produk tidak mencukupi.'], 400);
        }

        $waktuEdar = $request->tanggal_retur
            ? (strtotime($request->tanggal_retur) - strtotime($request->tanggal_keluar)) / (60 * 60 * 24)
            : null;

        $status = $request->tanggal_retur ? 'closed' : 'open';

        $transaksi->update([
            'toko_id' => $request->toko_id,
            'produk_id' => $request->produk_id,
            'transactionDate' => $request->tanggal_keluar,
            'returDate' => $request->tanggal_retur,
            'jumlahDibeli' => $request->jumlahDibeli,
            'harga' => $request->harga,
            'terjual' => $request->terjual,
            'waktuEdar' => $waktuEdar,
            'status' => $status,
        ]);

        $produk->decrement('jumlah', $request->jumlahDibeli);
        if ($request->tanggal_retur) {
            $produk->increment('jumlah', ($request->jumlahDibeli - $request->terjual));
        }

        return response()->json(['message' => 'Transaksi berhasil diperbarui', 'data' => $transaksi], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaksi = Transaksi::find($id);
        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $transaksi->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus'], 200);
    }
}
