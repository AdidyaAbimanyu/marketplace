<?php

namespace Database\Factories;

use App\Models\DetailPesanan;
use App\Models\Pengguna;
use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailPesananFactory extends Factory
{
    protected $model = DetailPesanan::class;

    public function definition()
    {
        return [
            'nama_produk' => $this->faker->word(),
            'status_detail_pesanan' => $this->faker->randomElement(['placed', 'packed', 'shipping', 'delivered']),
            'total_harga' => $this->faker->numberBetween(10000, 500000),
            'id_pengguna' => Pengguna::factory(),
            'id_keranjang' => Keranjang::factory(),
            'id_produk' => Produk::factory(),
        ];
    }
}
