<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('nama_produk');
            $table->bigInteger('stok_produk');
            $table->bigInteger('harga_produk');
            $table->string('kategori_produk');
            $table->string('deskripsi_produk')->nullable();
            $table->bigInteger('jumlah_review_produk')->nullable();
            $table->decimal('rating_produk', 2, 1)->default(0.0)->nullable();
            $table->unsignedBigInteger('id_pengguna');
            $table->string('gambar_produk');
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('produk');
    }
};
