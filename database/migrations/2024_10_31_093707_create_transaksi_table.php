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
            $table->string('transactionType', 100); // Jenis transaksi
            $table->integer('amount'); // Jumlah transaksi
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
