<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = $this->getTransaksiData();
        return view('transaksi-owner', compact('data'));
    }

    public function karyawan()
    {
        $data = $this->getTransaksiData();
        return view('transaksi-karyawan', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required', // Nama produk wajib diisi
            'harga' => 'required|numeric',
            'terjual' => 'required|numeric',
            'tanggal_keluar' => 'required|date',
            'tanggal_retur' => 'nullable|date',
        ]);

        // Hitung waktu edar
        $waktuEdar = $request->tanggal_retur ? 
            (strtotime($request->tanggal_retur) - strtotime($request->tanggal_keluar)) / (60 * 60 * 24) : 
            null;

        // Tentukan status
        $status = $request->tanggal_retur ? 'close' : 'open';

        Transaksi::create([
            'nama_produk' => $request->nama_produk,
            'transactionDate' => $request->tanggal_keluar,
            'returDate' => $request->tanggal_retur,
            'amount' => $request->harga,
            'terjual' => $request->terjual,
            'waktuEdar' => $waktuEdar,
            'status' => $status,
        ]);

        return redirect()->route('transaksi-owner')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'terjual' => 'required|numeric',
            'tanggal_keluar' => 'required|date',
            'tanggal_retur' => 'nullable|date',
        ]);

        // Hitung waktu edar
        $waktuEdar = $request->tanggal_retur ? 
            (strtotime($request->tanggal_retur) - strtotime($request->tanggal_keluar)) / (60 * 60 * 24) : 
            null;

        // Tentukan status
        $status = $request->tanggal_retur ? 'close' : 'open';

        // Update data di tabel transaksi
        Transaksi::where('id', $id)->update([
            'nama_produk' => $request->input('nama_produk'), // Nama produk diperbarui
            'transactionDate' => $request->input('tanggal_keluar'),
            'returDate' => $request->input('tanggal_retur'),
            'amount' => $request->input('harga'),
            'terjual' => $request->input('terjual'),
            'waktuEdar' => $waktuEdar,
            'status' => $status,
        ]);

        return redirect()->route('transaksi-owner')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi-owner')->with('success', 'Transaksi berhasil dihapus.');
    }

    private function getTransaksiData()
    {
        $transaksis = Transaksi::all(); // Ambil semua data dari tabel transaksi

        $data = [];
        foreach ($transaksis as $transaksi) {
            $data[] = [
                'id' => $transaksi->id,
                'total_harga' => $transaksi->amount * $transaksi->terjual, // Total harga dihitung
                'jumlah' => $transaksi->terjual, // Jumlah terjual
                'produk' => $transaksi->nama_produk, // Nama produk langsung dari tabel transaksi
                'terjual' => $transaksi->terjual,
                'harga' => $transaksi->amount, // Harga produk dari amount
                'tanggal_keluar' => $transaksi->transactionDate,
                'tanggal_retur' => $transaksi->returDate,
                'waktu_edar' => $transaksi->returDate ? 
                    (strtotime($transaksi->returDate) - strtotime($transaksi->transactionDate)) / (60 * 60 * 24) : 
                    null,
                'status' => $transaksi->returDate ? 'close' : 'open',
            ];
        }

        return $data;
    }
}