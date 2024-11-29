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
        // Ambil semua produk
        $produks = Produk::all();
        
        // Ambil semua stok
        $stoks = Stok::all();

        // Menggabungkan data produk dengan stok
        $data = $produks->map(function ($produk) use ($stoks) {
            // Mencari stok yang sesuai dengan produk
            $stok = $stoks->firstWhere('id', $produk->id); // Asumsi id stok sesuai dengan id produk

            return [
                'id' => $produk->id, // ID produk
                'name' => $produk->name, // Nama produk
                'harga_beli' => $produk->hargaBeli, // Harga beli dari tabel produk
                'harga_jual' => $produk->hargaJual, // Harga jual dari tabel produk
                'stok' => $stok ? $stok->jumlah : 0, // Jumlah dari tabel stok, default 0 jika tidak ada
                'batas_kritis' => $stok ? $stok->batasKritis : 0, // Batas kritis dari tabel stok, default 0 jika tidak ada
            ];
        });

        return view('gudang-owner', compact('data', 'produks'));
    }

    private function getGudangDataKaryawan()
    {
        // Ambil semua produk
        $produks = Produk::all();
        
        // Ambil semua stok
        $stoks = Stok::all();

        // Menggabungkan data produk dengan stok
        $data = $produks->map(function ($produk) use ($stoks) {
            // Mencari stok yang sesuai dengan produk
            $stok = $stoks->firstWhere('id', $produk->id); // Asumsi id stok sesuai dengan id produk

            return [
                'id' => $produk->id, // ID produk
                'name' => $produk->name, // Nama produk
                'harga_beli' => $produk->hargaBeli, // Harga beli dari tabel produk
                'harga_jual' => $produk->hargaJual, // Harga jual dari tabel produk
                'stok' => $stok ? $stok->jumlah : 0, // Jumlah dari tabel stok, default 0 jika tidak ada
                'batas_kritis' => $stok ? $stok->batasKritis : 0, // Batas kritis dari tabel stok, default 0 jika tidak ada
            ];
        });

        return view('gudang-karyawan', compact('data', 'produks'));
    }
}