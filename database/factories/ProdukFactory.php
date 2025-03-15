<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition()
    {
        return [
            'nama_produk' => $this->faker->word(),
            'stok_produk' => $this->faker->numberBetween(10, 100),
            'harga_produk' => $this->faker->numberBetween(10000, 500000),
            'review_produk' => $this->faker->sentence(),
            'rating_produk' => $this->faker->randomFloat(2, 1, 5),
            'id_pengguna' => Pengguna::factory(),
            'gambar_produk' => $this->faker->imageUrl(),
        ];
    }
}
