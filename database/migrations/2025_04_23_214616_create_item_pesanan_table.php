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
        Schema::create('item_pesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_detail_pesanan');
            $table->unsignedBigInteger('id_produk');
            $table->string('nama_produk');
            $table->integer('quantity');
            $table->integer('harga_produk');
            $table->integer('subtotal');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_detail_pesanan')->references('id_detail_pesanan')->on('detail_pesanan')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pesanan');
    }
};
