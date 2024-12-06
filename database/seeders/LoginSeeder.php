<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'MrRonggo',
            'email' => 'ronggo@gmail.com',
            'contact' => '089745612345',
            'role' => 'owner',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Zaidan',
            'email' => 'zaidan@gmail.com',
            'contact' => '089663452345',
            'role' => 'karyawan',
            'password' => Hash::make('12345678'),
        ]);
    }
}
