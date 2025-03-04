<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Keranjang;
use App\Models\Pembeli;
use App\Models\Produk;

class KeranjangFactory extends Factory
{
    protected $model = Keranjang::class;

    public function definition(): array
    {
        $produk = Produk::factory()->create();
        $jumlah = $this->faker->numberBetween(1, 10);

        return [
            'nama_produk' => $produk->nama_produk,
            'jumlah_produk' => $jumlah,
            'harga_produk' => $produk->harga_produk,
            'total_harga' => $jumlah * $produk->harga_produk,
            'id_pembeli' => Pembeli::factory(),
            'id_produk' => $produk->id,
        ];
    }
}
