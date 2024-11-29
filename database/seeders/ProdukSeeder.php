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
            'name' => 'Produk A',
            'price' => 10000,
            'category' => 'Kategori 1',
        ]);

        Produk::create([
            'name' => 'Produk B',
            'price' => 20000,
            'category' => 'Kategori 2',
        ]);

        Produk::create([
            'name' => 'Produk C',
            'price' => 30000,
            'category' => 'Kategori 1',
        ]);

        Produk::create([
            'name' => 'Produk D',
            'price' => 40000,
            'category' => 'Kategori 3',
        ]);

        Produk::create([
            'name' => 'Produk E',
            'price' => 50000,
            'category' => 'Kategori 2',
        ]);
    }
}
