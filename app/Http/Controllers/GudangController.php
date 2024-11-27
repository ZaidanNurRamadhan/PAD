<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        return $this->getGudangData();
    }

    public function karyawan()
    {
        return $this->getGudangDataKaryawan();
    }

    private function getGudangData()
    {
        $produks = Produk::all();
        $stoks = Stok::all();

        $data = $produks->map(function ($produk) use ($stoks) {
            $stok = $stoks->firstWhere('id', $produk->id);

            return [
                'id' => $produk->id,
                'name' => $produk->name,
                'harga_beli' => $produk->hargaBeli,
                'harga_jual' => $produk->hargaJual,
                'stok' => $stok ? $stok->jumlah : 0,
                'batas_kritis' => $stok ? $stok->batasKritis : 0,
            ];
        });

        return view('gudang-owner', compact('data', 'produks'));
    }

    private function getGudangDataKaryawan()
    {
        $produks = Produk::all();
        $stoks = Stok::all();

        $data = $produks->map(function ($produk) use ($stoks) {
            $stok = $stoks->firstWhere('id', $produk->id);

            return [
                'id' => $produk->id,
                'name' => $produk->name,
                'harga_beli' => $produk->hargaBeli,
                'harga_jual' => $produk->hargaJual,
                'stok' => $stok ? $stok->jumlah : 0,
                'batas_kritis' => $stok ? $stok->batasKritis : 0,
            ];
        });

        return view('gudang-karyawan', compact('data', 'produks'));
    }

    public function store(Request $request)
{
    $request->validate([
        'pname' => 'required|string|max:255',
        'hbeli' => 'required|integer',
        'hjual' => 'required|integer',
        'jstok' => 'required|integer',
        'astok' => 'required|integer',
    ]);

    // Buat produk baru
    $produk = new Produk();
    $produk->name = $request->pname;
    $produk->hargaBeli = $request->hbeli;
    $produk->hargaJual = $request->hjual;
    $produk->category = 'Uncategorized'; // Atur kategori default
    $produk->jumlah = $request->jstok;   // Pastikan kolom jumlah diisi
    $produk->save();

    // Buat stok baru yang terhubung dengan produk
    $stok = new Stok();
    $stok->product_id = $produk->id; // Hubungkan stok ke produk
    $stok->jumlah = $request->jstok;
    $stok->batasKritis = $request->astok;
    $stok->tanggalDistribusi = now();
    $stok->save();

    return redirect()->route('gudang-owner')->with('success', 'Produk berhasil ditambahkan!');
}

public function update(Request $request, $id)
{
    $request->validate([
        'pname' => 'required|string|max:255',
        'hbeli' => 'required|integer',
        'hjual' => 'required|integer',
        'jstok' => 'required|integer',
        'astok' => 'required|integer',
    ]);

    // Update produk
    $produk = Produk::findOrFail($id);
    $produk->name = $request->pname;
    $produk->hargaBeli = $request->hbeli;
    $produk->hargaJual = $request->hjual;
    $produk->save();

    // Update stok yang terhubung dengan produk
    $stok = Stok::where('product_id', $produk->id)->first();
    if ($stok) {
        $stok->jumlah = $request->jstok;
        $stok->batasKritis = $request->astok;
        $stok->save();
    }

    return redirect()->route('gudang-owner')->with('success', 'Produk berhasil diupdate!');
}

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

 // Delete corresponding stock entry
        $stok = Stok::where('id', $produk->id)->first();
        if ($stok) {
            $stok->delete();
        }

        return redirect()->route('gudang-owner')->with('success', 'Produk berhasil dihapus!');
    }
}