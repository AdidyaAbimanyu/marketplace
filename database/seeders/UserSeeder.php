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

        $brands = [
            'elektronik' => 'Apple',
            'makeup' => 'Maybelline',
            'pet' => 'Whiskas',
            'sport' => 'Nike',
            'fashion' => 'Zara',
            'perlengkapan rumah' => 'IKEA',
            'ibu & bayi' => 'Pampers',
            'travel' => 'Samsonite',
            'kesehatan' => 'Kalbe',
            'skincare' => 'SK-II',
            'otomotif' => 'Honda',
            'hobi & koleksi' => 'LEGO',
            'perlengkapan sekolah' => 'Faber-Castell',
            'fotografi' => 'Canon',
            'makanan & minuman' => 'Indomie',
        ];

        foreach ($brands as $kategori => $brand) {
            Pengguna::create([
                'nama_pengguna' => $brand,
                'username_pengguna' => strtolower($brand),
                'alamat_pengguna' => 'Jl. Brand ' . $brand,
                'password' => Hash::make('123'),
                'role' => 'penjual',
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            Pengguna::create([
                'nama_pengguna' => 'Pembeli ' . $i,
                'username_pengguna' => 'pembeli_' . $i,
                'alamat_pengguna' => 'Jl. Pembeli ' . $i,
                'password' => Hash::make('123'),
                'role' => 'pembeli',
            ]);
        }
    }
}
