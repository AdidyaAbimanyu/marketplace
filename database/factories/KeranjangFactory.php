<?php

namespace Database\Factories;

use App\Models\Keranjang;
use App\Models\Pengguna;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeranjangFactory extends Factory
{
    protected $model = Keranjang::class;

    public function definition()
    {
        return [
            'nama_produk' => $this->faker->word(),
            'jumlah_produk' => $this->faker->numberBetween(1, 5),
            'harga_produk' => $this->faker->numberBetween(10000, 500000),
            'total_harga' => function (array $attributes) {
                return $attributes['harga_produk'] * $attributes['jumlah_produk'];
            },
            'id_pengguna' => Pengguna::factory(),
            'id_produk' => Produk::factory(),
        ];
    }
}
