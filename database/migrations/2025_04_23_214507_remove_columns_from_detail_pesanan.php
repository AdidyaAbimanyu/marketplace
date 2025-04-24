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
        Schema::table('detail_pesanan', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['id_keranjang']);
            $table->dropForeign(['id_produk']);
            
            // Drop the columns after removing the foreign keys
            $table->dropColumn(['id_keranjang', 'id_produk', 'nama_produk']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_pesanan', function (Blueprint $table) {
            // Add the columns back
            $table->unsignedBigInteger('id_keranjang')->after('id_detail_pesanan');
            $table->unsignedBigInteger('id_produk')->after('id_keranjang');
            $table->string('nama_produk')->after('id_produk');

            // Recreate foreign keys
            $table->foreign('id_keranjang')->references('id_keranjang')->on('keranjang')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }
};
