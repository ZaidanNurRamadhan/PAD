<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Toko;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = $this->getTransaksiData();
        $tokos = Toko::all();
        $produk = Produk::all();
        return view('transaksi-owner', compact('data', 'tokos', 'produk'));
    }

    public function karyawan()
    {
        $data = $this->getTransaksiData();
        $tokos = Toko::all();
        $produk = Produk::all();
        return view('transaksi-karyawan', compact('data', 'tokos', 'produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'toko_id' => 'required|exists:toko,id',
            'produk_id' => 'required|exists:produk,id',
            'harga' => 'required|numeric',
            'terjual' => 'required|numeric',
            'tanggal_keluar' => 'required|date',
            'tanggal_retur' => 'nullable|date',
        ]);

        $toko = Toko::findOrFail($request->toko_id);
        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->jumlah < $request->terjual) {
            return back()->withErrors(['terjual' => 'Jumlah produk tidak mencukupi.']);
        }

        $waktuEdar = $request->tanggal_retur ?
            (strtotime($request->tanggal_retur) - strtotime($request->tanggal_keluar)) / (60 * 60 * 24) :
            null;

        $status = $request->tanggal_retur ? 'close' : 'open';

        Transaksi::create([
            'toko_id' => $toko->id,
            'produk_id' => $produk->id,
            'transactionDate' => $request->tanggal_keluar,
            'returDate' => $request->tanggal_retur,
            'amount' => $request->harga,
            'terjual' => $request->terjual,
            'waktuEdar' => $waktuEdar,
            'status' => $status,
        ]);

        $produk->update(['jumlah' => $produk->jumlah - $request->terjual]);

        return redirect()->route('transaksi-owner')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'toko_id' => 'required|exists:toko,id',
            'produk_id' => 'required|exists:produk,id',
            'harga' => 'required|numeric',
            'terjual' => 'required|numeric|min:0',
            'tanggal_keluar' => 'required|date',
            'tanggal_retur' => 'nullable|date|after_or_equal:tanggal_keluar',
        ]);
        $transaksi = Transaksi::findOrFail($id);
        $produk = Produk::findOrFail($request->produk_id);
        $toko = Toko::findOrFail($request->toko_id);

        $selisihTerjual = $request->terjual - $transaksi->terjual;

        if ($selisihTerjual > 0 && $produk->jumlah < $selisihTerjual) {
            return back()->withErrors(['terjual' => 'Jumlah produk tidak mencukupi.']);
        }

        if ($selisihTerjual != 0) {
            $produk->update(['jumlah' => $produk->jumlah - $selisihTerjual]);
        }


        $waktuEdar = $request->tanggal_retur ?
            (strtotime($request->tanggal_retur) - strtotime($request->tanggal_keluar)) / (60 * 60 * 24) :
            null;

        $status = $request->tanggal_retur ? 'close' : 'open';

        $transaksi->update([
            'toko_id' => $toko->id,
            'produk_id' => $produk->id,
            'transactionDate' => $request->tanggal_keluar,
            'returDate' => $request->tanggal_retur,
            'amount' => $request->harga,
            'terjual' => $request->terjual,
            'waktuEdar' => $waktuEdar,
            'status' => $status,
        ]);

        return redirect()->route('transaksi-owner')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $tokos = Toko::all();
        return view('transaksi-owner', compact('transaksi', 'tokos'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi-owner')->with('success', 'Transaksi berhasil dihapus.');
    }

    private function getTransaksiData()
    {
    $transaksis = Transaksi::with('produk')->get();

    $data = [];
    foreach ($transaksis as $transaksi) {
        $data[] = [
            'id' => $transaksi->id,
            'toko' => $transaksi->toko->name ?? 'Toko tidak ditemukan',
            'produk' => $transaksi->produk->name ?? 'Produk tidak ditemukan',
            'jumlah_stok' => $transaksi->produk->jumlah ?? 0,
            'terjual' => $transaksi->terjual,
            'total_harga' => $transaksi->amount * $transaksi->terjual,
            'harga' => $transaksi->amount,
            'tanggal_keluar' => $transaksi->transactionDate,
            'tanggal_retur' => $transaksi->returDate,
            'waktu_edar' => $transaksi->waktuEdar,
            'status' => $transaksi->status,
        ];
    }

    return $data;
    }
}
