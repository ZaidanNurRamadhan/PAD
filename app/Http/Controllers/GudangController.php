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
    
        $produk = Produk::create([
            'name' => $request->pname,
            'hargaBeli' => $request->hbeli,
            'hargaJual' => $request->hjual,
            'category' => 'Uncategorized',
            'jumlah' => $request->jstok,
        ]);
    
        Stok::create([
            'product_id' => $produk->id,
            'jumlah' => $request->jstok,
            'batasKritis' => $request->astok,
            'tanggalDistribusi' => now(),
        ]);
    
        return redirect()->route('gudang-owner')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('gudang-owner', compact('produk'));
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
    
        $produk = Produk::findOrFail($id);
        $produk->update([
            'name' => $request->pname,
            'hargaBeli' => $request->hbeli,
            'hargaJual' => $request->hjual,
        ]);
    
        $stok = Stok::where('product_id', $id)->first();
        if ($stok) {
            $stok->update([
                'jumlah' => $request->jstok,
                'batasKritis' => $request->astok,
            ]);
        }
    
        return redirect()->route('gudang-owner')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        $stok = Stok::where('product_id', $produk->id)->first();
        if ($stok) {
            $stok->delete();
        }
    
        $produk->delete();

        return redirect()->route('gudang-owner')->with('success', 'Produk berhasil dihapus!');
    }
}