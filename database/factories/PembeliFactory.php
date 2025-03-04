<?php

namespace Database\Factories;

use App\Models\Pembeli;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class PembeliFactory extends Factory
{
    protected $model = Pembeli::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'username_pembeli' => $this->faker->unique()->userName(),
            'alamat' => $this->faker->address(),
            'password' => Hash::make('password123'), // Bisa diubah sesuai kebutuhan
        ];
    }
}
