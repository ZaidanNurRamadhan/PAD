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
        'name' => 'required|max:255',
        'produkDisediakan' => 'required|max:255',
        'nomorTelepon' => 'required|numeric',
        'email' => 'required|email|max:255',
    ]);

    Pemasok::create($request->all());
    return redirect()->route('pemasok')->with('success', 'Pemasok berhasil ditambahkan.');
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
    public function update(Request $request, $id)
    {
    $request->validate([
        'name' => 'required|max:255',
        'produkDisediakan' => 'required|max:255',
        'nomorTelepon' => 'required|numeric',
        'email' => 'required|email|max:255',
    ]);

    $pemasok = Pemasok::findOrFail($id);
    $pemasok->update($request->all());
    return redirect()->route('pemasok')->with('success', 'Pemasok berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    $pemasok = Pemasok::findOrFail($id);
    $pemasok->delete();
    return redirect()->route('pemasok')->with('success', 'Pemasok berhasil dihapus.');
    }
}
