<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tokoList = Toko::all();
        return view('manajemen-toko', compact('tokoList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This method can be used to show a form for creating a new Toko
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tname' => 'required|string|max:255',
            'pemilikname' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:255',
        ]);

        Toko::create([
            'name' => $request->tname,
            'namaPemilik' => $request->pemilikname,
            'address' => $request->alamat,
            'phone_number' => $request->kontak,
        ]);

        return redirect()->route('toko.index')->with('success', 'Toko berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Toko $toko)
    {
        // This method can be used to show a specific Toko
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Toko $toko)
    {
        return view('edit-toko', compact('toko'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Toko $toko)
    {
        $request->validate([
            'tname' => 'required|string|max:255',
            'pemilikname' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'kontak' => 'nullable|string|max:255',
        ]);

        $toko->update([
            'name' => $request->tname,
            'namaPemilik' => $request->pemilikname,
            'address' => $request->alamat,
            'phone_number' => $request->kontak,
        ]);

        return redirect()->route('toko.index')->with('success', 'Toko berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toko $toko)
    {
        $toko->delete();
        return redirect()->route('toko.index')->with('success', 'Toko berhasil dihapus.');
    }
}