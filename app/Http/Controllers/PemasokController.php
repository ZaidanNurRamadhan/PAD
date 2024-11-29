<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasok;

class PemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemasok = Pemasok::all();
        return view('pemasok', compact('pemasok'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'produkDisediakan' => 'required',
            'nomorTelepon' => 'required|numeric',
            'email' => 'required|email',
        ]);

        $pemasok = Pemasok::create($request->all());
        return response()->json($pemasok);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pemasok = Pemasok::findOrFail($id);
        return view('pemasok.edit', compact('pemasok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'produkDisediakan' => 'required',
            'nomorTelepon' => 'required|numeric',
            'email' => 'required|email',
        ]);

        $pemasok = Pemasok::findOrFail($id);
        $pemasok->update($request->all());
        return response()->json($pemasok);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pemasok = Pemasok::findOrFail($id);
        $pemasok->delete();

        return response()->json(['success' => true]);
    }
}
