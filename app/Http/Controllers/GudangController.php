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
        $produks = Produk::all();
        // $data = $produks->map(function ($produk) use ($stoks) {
        //     $stok = $stoks->firstWhere('id', $produk->id);

        //     return [
        //         'id' => $produk->id,
        //         'name' => $produk->name,
        //         'hargaBeli' => $produk->hargaBeli,
        //         'hargaJual' => $produk->hargaJual,
        //         'jumlah' => $stok ? $stok->jumlah : 0,
        //         'batasKritis' => $stok ? $stok->batasKritis : 0,
        //     ];
        // });

        // return view('gudang-owner', compact('data', 'produks'));
        $pemasok = Pemasok::all(); // Atau bisa menggunakan 'with' jika ada relasi

        return view('gudang-owner', compact('produks','pemasok'));

    }

    private function getGudangDataKaryawan()
    {
        $produks = Produk::all();
        // $batas = ba
        // $stoks = Stok::all();

        // $data = $produks->map(function ($produk) use ($stoks) {
        //     $stok = $stoks->firstWhere('id', $produk->id);

        //     return [
        //         'id' => $produk->id,
        //         'name' => $produk->name,
        //         'hargaBeli' => $produk->hargaBeli,
        //         'hargaJual' => $produk->hargaJual,
        //         'jumlah' => $stok ? $stok->jumlah : 0,
        //         'batasKritis' => $stok ? $stok->batasKritis : 0,
        //     ];
        // });

        // return view('gudang-karyawan', compact('data', 'produks'));

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

        $produk = Produk::create([
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

        // return redirect()->route('gudang-owner')->with('success', 'Produk berhasil ditambahkan!');
        return redirect()->route('gudang-owner');
    }



    public function edit(Request $request, $id)
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
            'jumlah' => $request->jstok,
            'batasKritis' => $request->astok,
        ]);

        return redirect()->route('gudang-owner')->with('success', 'Produk berhasil diperbarui!');
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
