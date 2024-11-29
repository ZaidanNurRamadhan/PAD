<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Toko;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Toko::create(['name' => 'Budi Punya', 'namaPemilik' => 'Budi', 'address' => 'Jl. Merdeka No.1', 'phone_number' => '081234567890']);
        Toko::create(['name' => 'Jaya Kemenangan', 'namaPemilik' => 'Joko', 'address' => 'Jl. Pahlawan No.2', 'phone_number' => '082345678901']);
        Toko::create(['name' => 'Sinar Mas', 'namaPemilik' => 'SiMas', 'address' => 'Jl. Cendana No.3', 'phone_number' => '083456789012']);
        Toko::create(['name' => 'Warmin Asep', 'namaPemilik' => 'Asep', 'address' => 'Jl. Kenanga No.4', 'phone_number' => '084567890123']);
        Toko::create(['name' => 'Toko Sejahtera', 'namaPemilik' => 'Sabar', 'address' => 'Jl. Bunga No.5', 'phone_number' => '085678901234']);
    }
}
