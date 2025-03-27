<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pemasok;
use App\Models\Toko;
use App\Models\Produk;
use App\Models\User;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Validasi input
        try {
            // Validate input
            $request->validate([
                'search' => 'required|string|max:255',
                'page' => 'required|string|in:transaksi-owner,gudang-owner,pemasok,manajemen-toko,settings,laporan, transaksi-karyawan, gudang-karyawan', // Validate page
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log the validation errors if validation fails
            \Log::debug('Validation Errors:', $e->errors());
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        }

        // Ambil query dan halaman aktif
        $query = $request->input('search');
        $page = $request->input('page');

        \Log::debug('Page: ' . $page);
        \Log::debug('Query: ' . $query);

        if (!in_array($page, ['transaksi-owner', 'gudang-owner', 'pemasok', 'manajemen-toko', 'settings','laporan', 'transaksi-karyawan', 'gudang-karyawan'])) {
            return response()->json(['error' => 'Invalid page'], 422);
        }

        // Menentukan model dan pencarian berdasarkan halaman aktif
        switch ($page) {
            case 'transaksi-owner':
                $results = Transaksi::with('produk', 'toko') // Include 'produk' relationship to search product details
                    ->whereHas('produk', function ($search) use ($query) {
                        $search->where('name', 'LIKE', "%$query%"); // Search in produk's name
                    })
                    ->orWhereHas('toko', function ($search) use ($query) {
                        $search->where('name', 'LIKE', "%$query%"); // Search in to
                    })
                    ->orWhere('transactionDate', 'LIKE', "%$query%")
                    ->orWhere('returDate', 'LIKE', "%$query%")
                    ->orWhere('harga', 'LIKE', "%$query%")
                    ->orWhere('jumlahDibeli', 'LIKE', "%$query%")
                    ->orWhere('terjual', 'LIKE', "%$query%")
                    ->paginate(10);
                return response()->json(view('partials.searchTransaksiResults', compact('results'))->render());

                case 'transaksi-karyawan':
                    $results = Transaksi::with('produk', 'toko') // Include 'produk' relationship to search product details
                        ->whereHas('produk', function ($search) use ($query) {
                            $search->where('name', 'LIKE', "%$query%"); // Search in produk's name
                        })
                        ->orWhereHas('toko', function ($search) use ($query) {
                            $search->where('name', 'LIKE', "%$query%"); // Search in to
                        })
                        ->orWhere('transactionDate', 'LIKE', "%$query%")
                        ->orWhere('returDate', 'LIKE', "%$query%")
                        ->orWhere('harga', 'LIKE', "%$query%")
                        ->orWhere('jumlahDibeli', 'LIKE', "%$query%")
                        ->orWhere('terjual', 'LIKE', "%$query%")
                        ->paginate(10);
                    return response()->json(view('partials.searchTransaksiResults', compact('results'))->render());


            case 'gudang-owner':
                $gudang = Produk::where('name', 'LIKE', "%$query%")
                    ->orWhere('hargaBeli', 'LIKE', "%$query%")
                    ->orWhere('hargaJual', 'LIKE', "%$query%")
                    ->orWhere('batasKritis', 'LIKE', "%$query%")
                    ->orWhere('jumlah', 'LIKE', "%$query%")
                    ->paginate(10);
                    return response()->json(view('partials.searchGudangResults', compact('gudang'))->render());


            case 'pemasok':
                $pemasok = Pemasok::where('name', 'LIKE', "%$query%")
                    ->orWhere('produkDisediakan', 'LIKE', "%$query%")
                    ->orWhere('nomorTelepon', 'LIKE', "%$query%")
                    ->orWhere('email', 'LIKE', "%$query%")
                    ->paginate(10);

                return response()->json(view('partials.searchPemasokResults', compact('pemasok'))->render());


            case 'manajemen-toko':
                $results = Toko::where('name', 'LIKE', "%$query%")
                    ->orWhere('address', 'LIKE', "%$query%")
                    ->orWhere('phone_number', 'LIKE', "%$query%")
                    ->orWhere('namaPemilik', 'LIKE', "%$query%")
                    ->paginate(10);
                    return response()->json(view('partials.searchTokoResults', compact('results'))->render());

            case 'settings':
                $results = User::where('name', 'LIKE', "%$query%")
                ->orWhere('email', 'LIKE', "%$query%")
                ->orWhere('contact', 'LIKE', "%$query%")
                ->paginate(10);
                return response()->json(view('partials.searchSettingResults', compact('results'))->render());


            case 'laporan':
                // Pencarian untuk laporan transaksi dengan relasi produk dan toko
                $results = Transaksi::with('produk', 'toko')
                ->where('status', 'closed') // Menambahkan kondisi untuk hanya mencari transaksi dengan status 'closed'
                ->whereHas('produk', function ($search) use ($query) {
                    $search->where('name', 'LIKE', "%$query%"); // Pencarian berdasarkan nama produk
                })
                ->orWhereHas('toko', function ($search) use ($query) {
                    $search->where('name', 'LIKE', "%$query%"); // Pencarian berdasarkan nama toko
                })
                ->orWhere('transactionDate', 'LIKE', "%$query%")
                ->orWhere('returDate', 'LIKE', "%$query%")
                ->orWhere('harga', 'LIKE', "%$query%")
                ->orWhere('jumlahDibeli', 'LIKE', "%$query%")
                ->orWhere('terjual', 'LIKE', "%$query%")
                ->paginate(10);

                return response()->json(view('partials.searchLaporanResults', compact('results'))->render());

            case 'gudang-karyawan':
                $gudang = Produk::where('name', 'LIKE', "%$query%")
                ->orWhere('hargaBeli', 'LIKE', "%$query%")
                ->orWhere('hargaJual', 'LIKE', "%$query%")
                ->orWhere('batasKritis', 'LIKE', "%$query%")
                ->orWhere('jumlah', 'LIKE', "%$query%")
                ->paginate(10);
                return response()->json(view('partials.searchGudangResults', compact('gudang'))->render());


            default:
                return response()->json(['error' => 'Page not found'], 404);
        }

        // Mengembalikan hasil pencarian
        return response()->json($results);
    }
}
