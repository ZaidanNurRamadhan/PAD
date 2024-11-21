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
        Schema::create('toko', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama toko
            $table->string('namaPemilik'); // Pemilik toko
            $table->text('address')->nullable(); // Alamat toko
            $table->string('phone_number', 255)->nullable(); // Nomor telepon toko
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toko');
    }
};
