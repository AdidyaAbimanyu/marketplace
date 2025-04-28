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
        Schema::create('review', function (Blueprint $table) {
            $table->id('id_review');
            $table->string('isi_review');
            $table->decimal('rating_review', 2, 1)->default(5.0); // Rating antara 1.0 hingga 5.0
            $table->string('gambar_review')->nullable(); // URL gambar review
            $table->unsignedBigInteger('id_produk'); // Relasi ke produk
            $table->unsignedBigInteger('id_pengguna'); // Relasi ke pengguna
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review');
    }
};
