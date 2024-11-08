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
        // Creating dummy data for the pemasok table
        Pemasok::create([
            'name' => 'Pemasok A',
            'produkDisediakan' => 'Produk A1',
            'nomorTelepon' => '081234567890',
            'email' => 'pemasokA@example.com',
        ]);

        Pemasok::create([
            'name' => 'Pemasok B',
            'produkDisediakan' => 'Produk B1',
            'nomorTelepon' => '081234567891',
            'email' => 'pemasokB@example.com',
        ]);

        Pemasok::create([
            'name' => 'Pemasok C',
            'produkDisediakan' => 'Produk C1',
            'nomorTelepon' => '081234567892',
            'email' => 'pemasokC@example.com',
        ]);

        Pemasok::create([
            'name' => 'Pemasok D',
            'produkDisediakan' => 'Produk D1',
            'nomorTelepon' => '081234567893',
            'email' => 'pemasokD@example.com',
        ]);

        Pemasok::create([
            'name' => 'Pemasok E',
            'produkDisediakan' => 'Produk E1',
            'nomorTelepon' => '081234567894',
            'email' => 'pemasokE@example.com',
        ]);
    }
}
