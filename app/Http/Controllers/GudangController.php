<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pemasok;
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
        $produks = Produk::orderBy('id', 'desc')->paginate(5);
        $pemasok = Pemasok::paginate(5);

        return view('gudang-owner', compact('produks', 'pemasok'));
    }

    private function getGudangDataKaryawan()
    {
        $produks = Produk::orderBy('id', 'desc')->paginate(5);

        return view('gudang-karyawan', compact( 'produks'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'hargaBeli' => 'required|integer',
            'hargaJual' => 'required|integer',
            'jumlah' => 'required|integer',
            'batasKritis' => 'required|integer',
        ]);

        Produk::create([
            'name' => $request->name,
            'hargaBeli' => $request->hargaBeli,
            'hargaJual' => $request->hargaJual,
            'jumlah' => $request->jumlah,
            'batasKritis' => $request->batasKritis
        ]);

        // Stok::create([
        //     'product_id' => $produk->id,
        //     'jumlah' => $request->jumlah,
        //     'batasKritis' => $request->batasKritis,
        //     'tanggalDistribusi' => now(),
        // ]);

        return redirect()->route('gudang-owner')->with('success', 'Produk berhasil ditambahkan!');
        // return redirect()->route('gudang-owner');
    }



    // public function edit(Request $request, $id)
    // {
    //     $request->validate([
    //         'pname' => 'required|string|max:255',
    //         'hbeli' => 'required|integer',
    //         'hjual' => 'required|integer',
    //         'jstok' => 'required|integer',
    //         'astok' => 'required|integer',
    //     ]);

    //     $produk = Produk::findOrFail($id);
    //     $produk->update([
    //         'name' => $request->pname,
    //         'hargaBeli' => $request->hbeli,
    //         'hargaJual' => $request->hjual,
    //         'jumlah' => $request->jstok,
    //         'batasKritis' => $request->astok,
    //     ]);

    //     return redirect()->route('gudang-owner')->with('success', 'Produk berhasil diperbarui!');
    // }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json($produk);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pname' => 'required|string|max:255',
            'hbeli' => 'required|integer|min:0',
            'hjual' => 'required|integer|min:0',
            'jstok' => 'required|integer|min:0',
            'astok' => 'required|integer|min:0',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update([
            'name' => $request->pname,
            'hargaBeli' => $request->hbeli,
            'hargaJual' => $request->hjual,
            'jumlah' => $request->jstok,
            'batasKritis' => $request->astok,
        ]);
        return redirect()->route('gudang-owner')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        $produk->delete();

        return redirect()->route('gudang-owner')->with('success', 'Produk berhasil dihapus!');
    }
}
