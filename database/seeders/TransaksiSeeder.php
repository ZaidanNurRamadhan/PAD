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
            'transactionType' => 'Deposit',
            'amount' => 1000,
        ]);

        Transaksi::create([
            'transactionDate' => '2023-10-02',
            'transactionType' => 'Withdrawal',
            'amount' => 500,
        ]);

        Transaksi::create([
            'transactionDate' => '2023-10-03',
            'transactionType' => 'Transfer',
            'amount' => 2000,
        ]);

        Transaksi::create([
            'transactionDate' => '2023-10-04',
            'transactionType' => 'Deposit',
            'amount' => 1500,
        ]);

        Transaksi::create([
            'transactionDate' => '2023-10-05',
            'transactionType' => 'Withdrawal',
            'amount' => 700,
        ]);
    }
}
