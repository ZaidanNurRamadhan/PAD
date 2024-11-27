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
        for ($i = 0; $i < 5; $i++) {
            Produk::create([
                'name' => fake()->word(), // Nama produk random
                'hargaBeli' => fake()->numberBetween(10000, 50000), // Harga beli antara 10.000 hingga 50.000
                'hargaJual' => fake()->numberBetween(60000, 100000), // Harga jual antara 60.000 hingga 100.000
                'category' => fake()->randomElement(['Kategori 1', 'Kategori 2', 'Kategori 3']), // Pilihan kategori
                'jumlah' => fake()->numberBetween(1, 100), // Jumlah stok antara 1 hingga 100
            ]);
        }
    }
}
