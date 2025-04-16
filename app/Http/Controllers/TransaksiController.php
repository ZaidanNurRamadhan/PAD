<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Toko;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{
    public function export()
    {
        // Mengunduh file Excel yang berisi data transaksi
        return Excel::download(new TransaksiExport, 'transaksi.xlsx');
    }
    public function index()
    {
        $data = $this->getTransaksiData();
        $tokos = Toko::all();
        $produks = Produk::all();
        return view('transaksi-owner', compact('data', 'tokos', 'produks'));
    }

    public function karyawan()
    {
        $data = $this->getTransaksiData();
        $tokos = Toko::all();
        $produks = Produk::all();
        return view('transaksi-karyawan', compact('data', 'tokos', 'produks'));
    }

    public function store(Request $request)
    {
        // Validasi inputan dari request
        $request->validate([
            'toko_id' => 'required|exists:toko,id',
            'produk_id' => 'required|exists:produk,id',
            'jumlahDibeli' => 'required|numeric',
            'harga' => 'required|numeric',
            'terjual' => 'required|numeric',
            'tanggal_keluar' => 'required|date',
            'tanggal_retur' => 'nullable|date',
        ]);

        // Ambil data toko dan produk berdasarkan ID yang diberikan
        $toko = Toko::findOrFail($request->toko_id);
        $produk = Produk::findOrFail($request->produk_id);

        // Cek apakah jumlah produk mencukupi untuk transaksi
        if ($produk->jumlah < $request->terjual) {
            return back()->withErrors(['terjual' => 'Jumlah produk tidak mencukupi.']);
        }

        // Menghitung waktu edar jika ada tanggal retur
        $waktuEdar = $request->tanggal_retur ?
            (strtotime($request->tanggal_retur) - strtotime($request->tanggal_keluar)) / (60 * 60 * 24) :
            null;

        // Menentukan status transaksi berdasarkan ada tidaknya tanggal retur
        $status = $request->tanggal_retur ? 'closed' : 'open';

        // Menyimpan data transaksi
        Transaksi::create([
            'toko_id' => $toko->id,
            'produk_id' => $produk->id,
            'transactionDate' => $request->tanggal_keluar,
            'returDate' => $request->tanggal_retur,
            'jumlahDibeli' => $request->jumlahDibeli,
            'harga' => $request->harga,
            'terjual' => $request->terjual,
            'waktuEdar' => $waktuEdar,
            'status' => $status,
        ]);

        // Mengupdate jumlah produk setelah transaksi
        $produk->update(['jumlah' => $produk->jumlah - $request->terjual]);

        // Redirect berdasarkan role pengguna
        if (auth()->user()->role == 'karyawan') {
            return redirect()->route('transaksi-karyawan')->with('success', 'Transaksi berhasil ditambahkan.');
        }

        return redirect()->route('transaksi-owner')->with('success', 'Transaksi berhasil ditambahkan.');
    }

public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'toko_id' => 'required|exists:toko,id',
        'produk_id' => 'required|exists:produk,id',
        'jumlahDibeli' => 'required|numeric|min:1',
        'harga' => 'required|numeric|min:0',
        'terjual' => 'required|numeric|min:0',
        'tanggal_keluar' => 'required|date',
        'tanggal_retur' => 'nullable|date|after_or_equal:tanggal_keluar',
    ]);

    // Temukan transaksi yang akan diperbarui
    $transaksi = Transaksi::findOrFail($id);
    $produk = Produk::findOrFail($request->produk_id);
    $toko = Toko::findOrFail($request->toko_id);

    // Menghitung selisih terjual untuk mengelola stok
    $selisihTerjual = $request->jumlahDibeli - $transaksi->terjual;

    // Cek apakah stok mencukupi
    if ($selisihTerjual > 0 && $produk->jumlah < $selisihTerjual) {
        return back()->withErrors(['terjual' => 'Jumlah produk tidak mencukupi.']);
    }

    // Perbarui stok produk jika ada perubahan
    if ($selisihTerjual != 0) {
        $produk->update(['jumlah' => $produk->jumlah - $selisihTerjual]);
    }

    // Hitung waktu edar jika ada tanggal retur
    $waktuEdar = $request->tanggal_retur
        ? (strtotime($request->tanggal_retur) - strtotime($request->tanggal_keluar)) / (60 * 60 * 24)
        : null;

    // Tentukan status berdasarkan ada tidaknya tanggal retur
    $status = $request->tanggal_retur ? 'closed' : 'open';

    // Perbarui data transaksi
    $transaksi->update([
        'toko_id' => $toko->id,
        'produk_id' => $produk->id,
        'transactionDate' => $request->tanggal_keluar,
        'returDate' => $request->tanggal_retur,
        'jumlahDibeli' => $request->jumlahDibeli,
        'harga' => $request->harga,
        'terjual' => $request->terjual,
        'waktuEdar' => $waktuEdar,
        'status' => $status,
    ]);

    // if (auth()->user()->role == 'owner') {
    //     return redirect()->route('transaksi-owner')->with('success', 'Transaksi berhasil diperbarui.');
    // }

    return redirect()->route('transaksi-owner')->with('success', 'Transaksi berhasil diperbarui.');
}

public function edit($id)
{
    $transaksi = Transaksi::with('toko', 'produk')->findOrFail($id);
    return response()->json($transaksi);
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
            'toko_id' => $transaksi->toko_id,  // Pastikan toko_id ada
            'produk_id' => $transaksi->produk_id,
            'toko' => $transaksi->toko->name ?? 'Toko tidak ditemukan',
            'produk' => $transaksi->produk->name ?? 'Produk tidak ditemukan',
            'jumlahDibeli' => $transaksi->jumlahDibeli ?? 0,
            'terjual' => $transaksi->terjual,
            'total_harga' => $transaksi->harga * $transaksi->terjual,
            'harga' => $transaksi->harga,
            'tanggal_keluar' => $transaksi->transactionDate,
            'tanggal_retur' => $transaksi->returDate,
            'waktu_edar' => $transaksi->waktuEdar,
            'status' => $transaksi->status,
        ];
    }

    return $data;
    }
}
