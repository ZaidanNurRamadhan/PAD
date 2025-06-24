<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pemasok;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::orderBy('id', 'desc')->get();
        $pemasoks = Pemasok::all();

        return response()->json([
            'message' => 'Data gudang berhasil diambil.',
            'produks' => $produks,
            'pemasoks' => $pemasoks
        ], 200);
    }

    public function karyawan()
    {
        $produks = Produk::orderBy('id', 'desc')->get();
        $pemasoks = Pemasok::all();

        return response()->json([
            'message' => 'Data gudang untuk karyawan berhasil diambil.',
            'produks' => $produks,
            'pemasoks' => $pemasoks
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hargaBeli' => 'required|integer',
            'hargaJual' => 'required|integer',
            'jumlah' => 'required|integer',
            'batasKritis' => 'required|integer',
        ]);

        $produk = Produk::create([
            'name' => $request->name,
            'hargaBeli' => $request->hargaBeli,
            'hargaJual' => $request->hargaJual,
            'jumlah' => $request->jumlah,
            'batasKritis' => $request->batasKritis,
        ]);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan.',
            'produk' => $produk
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan.'], 404);
        }

        return response()->json($produk);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hargaBeli' => 'required|integer|min:0',
            'hargaJual' => 'required|integer|min:0',
            'jumlah' => 'required|integer|min:0',
            'batasKritis' => 'required|integer|min:0',
        ]);

        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan.'], 404);
        }

        $produk->update([
            'name' => $request->name,
            'hargaBeli' => $request->hargaBeli,
            'hargaJual' => $request->hargaJual,
            'jumlah' => $request->jumlah,
            'batasKritis' => $request->batasKritis,
        ]);

        return response()->json([
            'message' => 'Produk berhasil diperbarui.',
            'produk' => $produk
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan.'], 404);
        }

        $produk->delete();

        return response()->json(['message' => 'Produk berhasil dihapus.']);
    }
}
