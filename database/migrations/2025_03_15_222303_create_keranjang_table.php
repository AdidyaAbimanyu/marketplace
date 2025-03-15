<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id('id_keranjang');
            $table->string('nama_produk');
            $table->bigInteger('jumlah_produk');
            $table->bigInteger('harga_produk');
            $table->bigInteger('total_harga');
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_produk');
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('keranjang');
    }
};
