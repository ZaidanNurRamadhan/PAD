<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create dummy products
        Produk::create([
            'id' => 1,
            'name' => 'Produk A',
            'hargaBeli' => 10000,
            'hargaJual' => 15000,
            'category' => 'Kategori 1',
            'jumlah' => 10,
        ]);

        Produk::create([
            'id' => 2,
            'name' => 'Produk B',
            'hargaBeli' => 20000,
            'hargaJual' => 25000,
            'category' => 'Kategori 2',
            'jumlah' => 20,
        ]);

        Produk::create([
            'id' => 3,
            'name' => 'Produk C',
            'hargaBeli' => 30000,
            'hargaJual' => 35000,
            'category' => 'Kategori 1',
            'jumlah' => 30,
        ]);

        Produk::create([
            'id' => 4,
            'name' => 'Produk D',
            'hargaBeli' => 40000,
            'hargaJual' => 45000,
            'category' => 'Kategori 3',
            'jumlah' => 40,
        ]);

        Produk::create([
            'id' => 5,
            'name' => 'Produk E',
            'hargaBeli' => 50000,
            'hargaJual' => 55000,
            'category' => 'Kategori 2',
            'jumlah' => 50,
        ]);
    }
}
