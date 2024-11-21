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
            $table->date('transactionDate'); // Tanggal transaksi
            $table->date('returDate'); // Tanggal retur
            $table->integer('amount'); // Jumlah transaksi
            $table->integer('terjual'); // Jumlah terjual
            $table->integer('waktuEdar'); // Waktu edar
            $table->enum('status', ['open', 'closed']);
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
