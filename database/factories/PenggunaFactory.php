<?php

namespace Database\Factories;

use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PenggunaFactory extends Factory
{
    protected $model = Pengguna::class;

    public function definition()
    {
        return [
            'nama_pengguna' => $this->faker->name(),
            'username_pengguna' => $this->faker->unique()->userName(),
            'alamat_pengguna' => $this->faker->address(),
            'password' => bcrypt('password'), // Default password
            'role' => $this->faker->randomElement(['admin', 'customer']),
        ];
    }
}
