<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id') // Foreign key untuk produk_id
                  ->constrained('produk') // Merujuk ke tabel produk
                  ->onDelete('cascade'); // Cascade saat dihapus
            $table->foreignId('toko_id') // Foreign key untuk toko_id
                  ->constrained('toko') // Merujuk ke tabel toko
                  ->onDelete('cascade'); // Cascade saat dihapus
            $table->date('transactionDate'); // Tanggal transaksi
            $table->date('returDate')->nullable(); // Tanggal pengembalian
            $table->integer('harga')->nullable(); // Harga barang
            $table->integer('jumlahDibeli');//jumlah dibeli
            $table->integer('terjual')->nullable(); // Jumlah terjual
            $table->integer('waktuEdar')->nullable(); // Waktu edar
            $table->enum('status', ['open', 'closed']); // Status transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
