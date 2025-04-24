<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id('id_detail_pesanan');
            $table->string('nama_produk');
            $table->string('status_detail_pesanan'); // pending, processed, delivered
            $table->bigInteger('jumlah_produk');
            $table->bigInteger('total_harga');
            $table->string('alamat');
            $table->unsignedBigInteger('id_pengguna'); // pengguna yang pesan
            $table->unsignedBigInteger('id_produk'); // produk yang dibeli
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
