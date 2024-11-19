<?php

namespace App\Http\Controllers;

use App\Models\Produk;
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

        $data = $produks->map(function ($produk) {
            return [
                'id' => rand(1, 100),
                'name' => $produk->name,
                'harga_beli' => $produk->price,
                'harga_jual' => $produk->price * 2,
                'stok' => rand(1, 100),
                'batas_kritis' => rand(1, 20),
            ];
        });

        return view('gudang-owner', compact('data', 'produks'));
    }

    private function getGudangDataKaryawan()
    {
        $produks = Produk::all();

        $data = $produks->map(function ($produk) {
            return [
                'id' => rand(1, 100),
                'name' => $produk->name,
                'harga_beli' => $produk->price,
                'harga_jual' => $produk->price * 2,
                'stok' => rand(1, 100),
                'batas_kritis' => rand(1, 20),
            ];
        });

        return view('gudang-karyawan', compact('data', 'produks'));
    }
}