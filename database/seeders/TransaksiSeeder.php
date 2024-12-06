<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\Produk;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produkList = Produk::all();

        if ($produkList->isEmpty()) {
            $this->command->error('Tidak ada data produk. Harap tambahkan data ke tabel produk terlebih dahulu.');
            return;
        }

        for ($i = 0; $i < 5; $i++) {
            $transactionDate = Carbon::now()->subDays(fake()->numberBetween(1, 30));
            $returDate = (clone $transactionDate)->addDays(fake()->numberBetween(1, 7));
            $produk = $produkList->random();
            $jumlahDibeli = fake()->numberBetween(1,$produk->jumlah);

            Transaksi::create([
                'produk_id' => $produk->id,
                'transactionDate' => $transactionDate,
                'returDate' => fake()->boolean(70) ? $returDate : null,
                'harga' => $produk->hargaJual,
                'jumlahDibeli' => $jumlahDibeli,
                'terjual' => fake()->numberBetween(1, $jumlahDibeli),
                'waktuEdar' => $returDate ? $returDate->diffInDays($transactionDate) : null,
                'status' => $returDate ? 'closed' : 'open',
                'toko_id' => 1,  // Pastikan toko_id ada, misalnya ID toko pertama
            ]);


            $produk->update(['jumlah' => $produk->jumlah - 1]);
        }
    }
}
