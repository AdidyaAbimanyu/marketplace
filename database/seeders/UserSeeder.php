<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin, Penjual, Pembeli
        DB::table('pengguna')->insert([
            [
                'nama_pengguna' => 'Admin',
                'username_pengguna' => 'admin',
                'alamat_pengguna' => 'Jl. Admin No. 123',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pengguna' => 'Penjual',
                'username_pengguna' => 'penjual',
                'alamat_pengguna' => 'Jl. Penjual No. 123',
                'password' => Hash::make('123'),
                'role' => 'penjual',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pengguna' => 'Pembeli',
                'username_pengguna' => 'pembeli',
                'alamat_pengguna' => 'Jl. Pembeli No. 123',
                'password' => Hash::make('123'),
                'role' => 'pembeli',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Brand Users (1 brand per kategori)
        $brands = [
            ['nama' => 'Apple', 'kategori' => 'elektronik'],
            ['nama' => 'Maybelline', 'kategori' => 'makeup'],
            ['nama' => 'Whiskas', 'kategori' => 'pet'],
            ['nama' => 'Nike', 'kategori' => 'sport'],
            ['nama' => 'Zara', 'kategori' => 'fashion'],
            ['nama' => 'IKEA', 'kategori' => 'perlengkapan rumah'],
            ['nama' => 'MamyPoko', 'kategori' => 'ibu & bayi'],
            ['nama' => 'Traveloka', 'kategori' => 'travel'],
            ['nama' => 'Herbalife', 'kategori' => 'kesehatan'],
            ['nama' => 'SK-II', 'kategori' => 'skincare'],
            ['nama' => 'Toyota', 'kategori' => 'otomotif'],
            ['nama' => 'Funko', 'kategori' => 'hobi & koleksi'],
            ['nama' => 'Faber-Castell', 'kategori' => 'perlengkapan sekolah'],
            ['nama' => 'Canon', 'kategori' => 'fotografi'],
            ['nama' => 'Indomie', 'kategori' => 'makanan & minuman'],
        ];

        foreach ($brands as $brand) {
            Pengguna::create([
                'nama_pengguna' => $brand['nama'],
                'username_pengguna' => strtolower($brand['nama']),
                'alamat_pengguna' => 'Alamat ' . $brand['nama'],
                'password' => Hash::make('123'),
                'role' => 'penjual',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
