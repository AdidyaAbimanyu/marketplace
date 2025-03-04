<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->bigInteger('stok_produk');
            $table->bigInteger('harga_produk');
            $table->string('review_produk')->nullable();
            $table->decimal('rating_produk', 2, 1)->nullable();
            $table->string('gambar_produk')->nullable();
            $table->foreignId('id_penjual')->constrained('penjual')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
};
