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
        // Create dummy data
        Stok::create([
            'jumlah' => 100,
            'tanggalDistribusi' => Carbon::now()->subDays(10), // 10 days ago
            'batasKritis' => 50,
        ]);

        Stok::create([
            'jumlah' => 200,
            'tanggalDistribusi' => Carbon::now()->subDays(5), // 5 days ago
            'batasKritis' => 25,
        ]);

        Stok::create([
            'jumlah' => 150,
            'tanggalDistribusi' => Carbon::now(), // Today
            'batasKritis' => 20,
        ]);
    }
}
