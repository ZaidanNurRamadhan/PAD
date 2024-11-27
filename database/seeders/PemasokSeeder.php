<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pemasok;

class PemasokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            Pemasok::create([
                'name' => fake()->company(), // Nama perusahaan sebagai nama pemasok
                'produkDisediakan' => fake()->word(), // Satu kata random sebagai produk disediakan
                'nomorTelepon' => fake()->phoneNumber(), // Nomor telepon random
                'email' => fake()->unique()->safeEmail(), // Email random yang unik
            ]);
        }
    }
}
