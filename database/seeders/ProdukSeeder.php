<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua pengguna brand penjual (kecuali admin/penjual/pembeli biasa)
        $brandUsers = Pengguna::where('role', 'penjual')
            ->whereNotIn('username_pengguna', ['penjual', 'admin', 'pembeli'])
            ->get();

        foreach ($brandUsers as $pengguna) {
            for ($i = 1; $i <= 10; $i++) {
                Produk::create([
                    'nama_produk' => $pengguna->nama_pengguna . " Produk " . $i,
                    'kategori_produk' => $this->getKategoriFromBrand($pengguna->nama_pengguna),
                    'deskripsi_produk' => "Deskripsi produk $i dari brand " . $pengguna->nama_pengguna,
                    'stok_produk' => rand(5, 50),
                    'harga_produk' => rand(10000, 1000000),
                    'review_produk' => rand(10, 1000),
                    'rating_produk' => rand(1, 5),
                    'id_pengguna' => $pengguna->id_pengguna,
                    'gambar_produk' => 'default.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function getKategoriFromBrand(string $brand): string
    {
        return match (strtolower($brand)) {
            'apple' => 'elektronik',
            'maybelline' => 'makeup',
            'whiskas' => 'pet',
            'nike' => 'sport',
            'zara' => 'fashion',
            'ikea' => 'perlengkapan rumah',
            'mamypoko' => 'ibu & bayi',
            'traveloka' => 'travel',
            'herbalife' => 'kesehatan',
            'sk-ii' => 'skincare',
            'toyota' => 'otomotif',
            'funko' => 'hobi & koleksi',
            'faber-castell' => 'perlengkapan sekolah',
            'canon' => 'fotografi',
            'indomie' => 'makanan & minuman',
            default => 'lainnya',
        };
    }
}
