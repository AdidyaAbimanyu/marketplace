<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->string('status_detail_pesanan');
            $table->bigInteger('total_harga');
            $table->foreignId('id_pembeli')->constrained('pembeli')->onDelete('cascade');
            $table->foreignId('id_keranjang')->constrained('keranjang')->onDelete('cascade');
            $table->foreignId('id_produk')->constrained('produk')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
