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
        for ($i = 0; $i < 5; $i++) {
            Toko::create([
                'name' => fake()->company(), // Nama toko random
                'namaPemilik' => fake()->name(), // Nama pemilik random
                'address' => fake()->address(), // Alamat random
                'phone_number' => fake()->phoneNumber(), // Nomor telepon random
            ]);
        }
    }
}
