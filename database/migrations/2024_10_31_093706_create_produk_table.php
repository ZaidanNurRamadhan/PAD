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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // Nama produk
            $table->integer('hargaBeli'); // Harga produk
            $table->integer('hargaJual'); // Harga jual produk
            $table->integer('jumlah'); // Jumlah produk
            $table->integer('batasKritis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
