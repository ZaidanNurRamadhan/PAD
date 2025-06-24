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
        // Mengambil pemasok dan mengurutkannya berdasarkan ID secara menurun
        $pemasok = Pemasok::orderBy('id', 'desc')->paginate(5);

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
        Pemasok::create($request->all());
        // return response()->json($pemasok);
        return redirect()->route('pemasok')->with('success','data telah tambah');
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
    public function edit($id)
    {
        $pemasok = Pemasok::findOrFail($id);
        return response()->json($pemasok);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'produkDisediakan' => 'required',
            'nomorTelepon' => 'required|numeric',
            'email' => 'required|email',
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
        // Mencari pemasok berdasarkan ID
        $pemasok = Pemasok::findOrFail($id);

        // Menghapus pemasok
        $pemasok->delete();

        // Kembali ke halaman pemasok, tanpa menggunakan alert
        return redirect()->route('pemasok')->with('success', 'pemasok berhasil dihapus!');
    }

}
