<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Faker\Factory as Faker;

class SettingController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'karyawan')->get();

        $faker = Faker::create();

        $data = [];
        foreach ($employees as $employee) {
            $data[] = [
                'id' => $employee->id,
                'name' => $employee->name,
                'contact' => $employee->contact,
                'username' => $employee->name
            ];
        }

        return view('settings', compact('data'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'contact' => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,contact',
        'username' => 'required|string|max:255|unique:users,name',
        'password' => 'required|string|min:8',
    ]);

    User::create([
        'name' => $request->name,
        'contact' => $request->contact,
        'role' => 'karyawan',
        'email' => $request->name . '@example.com',
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

public function update(Request $request, $id)
    {
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'contact' => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,contact,' . $user->id,
        'username' => 'required|string|max:255|unique:users,name,' . $user->id,
        'password' => 'nullable|string|min:8',
    ]);

    $user->update([
        'name' => $request->name,
        'contact' => $request->contact,
        'password' => $request->password ? bcrypt($request->password) : $user->password,
    ]);

    return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

public function destroy($id)
{
    $user = User::findOrFail($id);

    if ($user->role !== 'karyawan') {
        return redirect()->route('karyawan.index')->with('error', 'Hanya karyawan yang bisa dihapus.');
    }

    $user->delete();

    return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
}
}
