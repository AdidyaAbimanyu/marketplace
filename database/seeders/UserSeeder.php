<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Pembeli;
use App\Models\Penjual;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Admin::factory()->create([
            'username' => 'admin',
            'password' => 'admin',
        ]);

        Penjual::factory()->create([
            'nama' => 'Penjual',
            'username' => 'penjual',
            'password' => 'penjual',
        ]);

        Pembeli::factory()->create([
            'nama' => 'Pembeli',
            'alamat' => 'Surakarta',
            'username' => 'pembeli',
            'password' => 'pembeli',
        ]);
    }
}
