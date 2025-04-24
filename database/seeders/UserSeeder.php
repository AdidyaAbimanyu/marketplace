<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
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
        ];

        foreach ($users as $user) {
            DB::table('pengguna')->updateOrInsert(
                ['username_pengguna' => $user['username_pengguna']],
                $user
            );
        }
    }
}
