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
            'name' => 'Owner User',
            'email' => 'owner@example.com',
            'role' => 'owner',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'role' => 'karyawan',
            'password' => Hash::make('password'),
        ]);
    }
}
