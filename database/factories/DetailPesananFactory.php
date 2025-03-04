<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DetailPesanan;
use App\Models\Pembeli;
use App\Models\Keranjang;
use App\Models\Produk;

class DetailPesananFactory extends Factory
{
    protected $model = DetailPesanan::class;

    public function definition(): array
    {
        $produk = Produk::factory()->create(); // Buat produk otomatis
        $keranjang = Keranjang::factory()->create(['id_produk' => $produk->id]); // Buat keranjang terkait
        $totalHarga = $keranjang->jumlah_produk * $produk->harga_produk;

        return [
            'nama_produk' => $produk->nama_produk,
            'status_detail_pesanan' => $this->faker->randomElement(['Pending', 'Diproses', 'Dikirim', 'Selesai']),
            'total_harga' => $totalHarga,
            'id_pembeli' => $keranjang->id_pembeli, // Ambil pembeli dari keranjang
            'id_keranjang' => $keranjang->id,
            'id_produk' => $produk->id,
        ];
    }
}
