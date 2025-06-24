<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = User::where('role', 'karyawan')->orderBy('id', 'desc')->paginate(10);

        return response()->json($employees, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact' => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,contact',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'role' => 'karyawan',
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'data' => $user,
            'message' => 'Karyawan berhasil ditambahkan.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = User::where('role', 'karyawan')->find($id);

        if (!$employee) {
            return response()->json(['message' => 'Karyawan tidak ditemukan.'], 404);
        }

        return response()->json(['data' => $employee], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::where('role', 'karyawan')->find($id);

        if (!$user) {
            return response()->json(['message' => 'Karyawan tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact' => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,contact,' . $id,
            'email' => 'required|string|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->update([
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json([
            'data' => $user,
            'message' => 'Karyawan berhasil diperbarui.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('role', 'karyawan')->find($id);

        if (!$user) {
            return response()->json(['message' => 'Karyawan tidak ditemukan.'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Karyawan berhasil dihapus.'], 200);
    }
}
