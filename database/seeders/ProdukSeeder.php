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

            $hargaBeli = fake()->numberBetween(10000, 500000);
            $hargaJual = $hargaBeli + fake()->numberBetween(10000, 500000);

            Produk::create([
                'name' => fake()->word(),
                'hargaBeli' => $hargaBeli,
                'hargaJual' => $hargaJual,
                'category' => fake()->randomElement(['Kategori 1', 'Kategori 2', 'Kategori 3']),
                'jumlah' => fake()->numberBetween(1, 100),
            ]);
        }
    }
}
