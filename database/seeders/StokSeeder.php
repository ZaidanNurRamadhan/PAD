<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stok;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Stok::create([
                'product_id' => $i, // Menggunakan id produk mulai dari 1 hingga 10
                'jumlah' => fake()->numberBetween(50, 200), // Jumlah stok antara 50 hingga 200
                'tanggalDistribusi' => Carbon::now()->subDays(fake()->numberBetween(0, 30)), // Tanggal distribusi antara hari ini hingga 30 hari lalu
                'batasKritis' => fake()->numberBetween(10, 50), // Batas kritis antara 10 hingga 50
            ]);
        }
    }
}
