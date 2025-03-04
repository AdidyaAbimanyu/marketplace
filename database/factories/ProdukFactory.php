<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Penjual;
use App\Models\Produk;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition(): array
    {
        return [
            'nama_produk' => $this->faker->word(),
            'stok_produk' => $this->faker->numberBetween(1, 100),
            'harga_produk' => $this->faker->numberBetween(10000, 500000),
            'review_produk' => $this->faker->sentence(),
            'rating_produk' => $this->faker->randomFloat(1, 1, 5),
            'gambar_produk' => $this->faker->imageUrl(),
            'id_penjual' => Penjual::factory(), // Buat penjual otomatis
        ];
    }
}
