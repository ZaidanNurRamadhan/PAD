<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemasok;
use Illuminate\Support\Facades\Validator;

class PemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemasok = Pemasok::orderBy('id', 'desc')->get();

        return response()->json([
            'data' => $pemasok,
            'message' => 'Data pemasok berhasil diambil.'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'produkDisediakan' => 'required|string|max:255',
            'nomorTelepon' => 'required|numeric',
            'email' => 'required|email|max:255|unique:pemasok,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pemasok = Pemasok::create($request->all());

        return response()->json([
            'data' => $pemasok,
            'message' => 'Pemasok berhasil ditambahkan.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pemasok = Pemasok::find($id);

        if (!$pemasok) {
            return response()->json(['message' => 'Pemasok tidak ditemukan.'], 404);
        }

        return response()->json(['data' => $pemasok], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pemasok = Pemasok::find($id);

        if (!$pemasok) {
            return response()->json(['message' => 'Pemasok tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'produkDisediakan' => 'required|string|max:255',
            'nomorTelepon' => 'required|numeric',
            'email' => 'required|email|max:255|unique:pemasoks,email,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pemasok->update($request->all());

        return response()->json([
            'data' => $pemasok,
            'message' => 'Pemasok berhasil diperbarui.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pemasok = Pemasok::find($id);

        if (!$pemasok) {
            return response()->json(['message' => 'Pemasok tidak ditemukan.'], 404);
        }

        $pemasok->delete();

        return response()->json(['message' => 'Pemasok berhasil dihapus.'], 200);
    }
}
