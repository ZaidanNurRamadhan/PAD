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
    Schema::table('stok', function (Blueprint $table) {
        if (!Schema::hasColumn('stok', 'product_id')) {
            $table->unsignedBigInteger('product_id')->after('id'); // Tambahkan kolom product_id
            $table->foreign('product_id')->references('id')->on('produks')->onDelete('cascade'); // Tambahkan foreign key
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stok', function (Blueprint $table) {
            if (Schema::hasColumn('stok', 'product_id')) {
                $table->dropForeign(['product_id']); // Hapus foreign key jika ada
                $table->dropColumn('product_id');   // Hapus kolom jika ada
            }
        });
    }
};
