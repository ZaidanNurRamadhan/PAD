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
                'product_id' => $i,
                'jumlah' => fake()->numberBetween(50, 200),
                'tanggalDistribusi' => Carbon::now()->subDays(fake()->numberBetween(0, 30)),
                'batasKritis' => fake()->numberBetween(10, 50),
            ]);
        }
    }
}
