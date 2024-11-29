<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaksi;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaksi::create([
            'transactionDate' => '2023-10-01',
            'returDate' => '2023-10-02',
            'amount' => 1000,
            'terjual' => 500,
            'waktuEdar' => 2,
            'status' => 'closed',
        ]);

        Transaksi::create([
            'transactionDate' => '2023-10-02',
            'returDate' => '2023-10-03',
            'amount' => 500,
            'terjual' => 200,
            'waktuEdar' => 3,
            'status' => 'open',
        ]);

        Transaksi::create([
            'transactionDate' => '2023-10-03',
            'returDate' => '2023-10-04',
            'amount' => 2000,
            'terjual' => 1000,
            'waktuEdar' => 4,
            'status' => 'closed',
        ]);

        Transaksi::create([
            'transactionDate' => '2023-10-04',
            'returDate' => '2023-10-05',
            'amount' => 1500,
            'terjual' => 750,
            'waktuEdar' => 5,
            'status' => 'open',
        ]);

        Transaksi::create([
            'transactionDate' => '2023-10-05',
            'returDate' => '2023-10-06',
            'amount' => 700,
            'terjual' => 350,
            'waktuEdar' => 6,
            'status' => 'closed',
        ]);
    }
}
