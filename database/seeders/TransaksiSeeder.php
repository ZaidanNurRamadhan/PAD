<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $transactionDate = Carbon::now()->subDays(fake()->numberBetween(1, 30));
            $returDate = (clone $transactionDate)->addDays(fake()->numberBetween(1, 7));

            Transaksi::create([
                'namaProduk' => fake()->word(), // Nama produk random
                'transactionDate' => $transactionDate, // Tanggal transaksi random
                'returDate' => $returDate, // Tanggal retur random setelah transaksi
                'amount' => fake()->numberBetween(500, 5000), // Jumlah transaksi antara 500 hingga 5000
                'terjual' => fake()->numberBetween(100, 3000), // Jumlah terjual antara 100 hingga 3000
                'waktuEdar' => $returDate->diffInDays($transactionDate), // Selisih hari antara transactionDate dan returDate
                'status' => fake()->randomElement(['open', 'closed']), // Status transaksi random
            ]);
        }
    }
}
