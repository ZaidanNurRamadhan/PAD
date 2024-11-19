<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class SettingController extends Controller
{
    public function index()
    {
        // Retrieve all users with the role of 'karyawan'
        $employees = User::where('role', 'karyawan')->get();

        // Create a Faker instance
        $faker = Faker::create();

        // Prepare the data to be passed to the view
        $data = [];
        foreach ($employees as $employee) {
            $data[] = [
                'name' => $faker->name, // Random name
                'contact' => $faker->contact, // Random contact
                'username' => $employee->name // Username from the database
            ];
        }

        return view('settings', compact('data'));
    }
}
