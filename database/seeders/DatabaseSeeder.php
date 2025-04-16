<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TokoSeeder::class);
        $this->call(ProdukSeeder::class);
        $this->call(TransaksiSeeder::class);
        $this->call(LoginSeeder::class);
        $this->call(PemasokSeeder::class);
    }
}
