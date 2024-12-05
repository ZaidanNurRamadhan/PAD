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
        // Schema::create('produk', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name', 255); // Nama produk
        //     $table->integer('price'); // Harga produk
        //     $table->string('category', 255); // Kategori produk
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('produk');
    }
};
