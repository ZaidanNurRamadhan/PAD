<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Toko;
use Illuminate\Support\Facades\Validator;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tokoList = Toko::orderBy('id', 'desc')->get();

        return response()->json([
            'data' => $tokoList,
            'message' => 'Daftar toko berhasil diambil.',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'namaPemilik' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $toko = Toko::create($request->all());

        return response()->json([
            'data' => $toko,
            'message' => 'Toko berhasil ditambahkan.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $toko = Toko::find($id);
        if (!$toko) {
            return response()->json(['message' => 'Toko tidak ditemukan.'], 404);
        }

        return response()->json(['data' => $toko], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $toko = Toko::find($id);
        if (!$toko) {
            return response()->json(['message' => 'Toko tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'namaPemilik' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $toko->update($request->all());

        return response()->json([
            'data' => $toko,
            'message' => 'Toko berhasil diperbarui.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $toko = Toko::find($id);
        if (!$toko) {
            return response()->json(['message' => 'Toko tidak ditemukan.'], 404);
        }

        $toko->delete();

        return response()->json(['message' => 'Toko berhasil dihapus.'], 200);
    }
}
