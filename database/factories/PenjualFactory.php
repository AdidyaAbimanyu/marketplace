<?php

namespace Database\Factories;

use App\Models\Penjual;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class PenjualFactory extends Factory
{
    protected $model = Penjual::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'password' => Hash::make('password123'), // Bisa diubah sesuai kebutuhan
        ];
    }
}
