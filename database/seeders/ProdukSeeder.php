<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\Pengguna;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $brandKategoriMap = [
            'Apple' => 'elektronik',
            'Maybelline' => 'makeup',
            'Whiskas' => 'pet',
            'Nike' => 'sport',
            'Zara' => 'fashion',
            'IKEA' => 'perlengkapan rumah',
            'Pampers' => 'ibu & bayi',
            'Samsonite' => 'travel',
            'Kalbe' => 'kesehatan',
            'SK-II' => 'skincare',
            'Honda' => 'otomotif',
            'LEGO' => 'hobi & koleksi',
            'Faber-Castell' => 'perlengkapan sekolah',
            'Canon' => 'fotografi',
            'Indomie' => 'makanan & minuman',
        ];

        foreach ($brandKategoriMap as $brand => $kategori) {
            $penjual = Pengguna::where('nama_pengguna', $brand)->first();

            if ($penjual) {
                for ($i = 1; $i <= 10; $i++) {
                    Produk::create([
                        'nama_produk' => "Produk $i dari $brand",
                        'kategori_produk' => $kategori,
                        'deskripsi_produk' => "Deskripsi produk $i kategori $kategori",
                        'jumlah_produk_terjual' => 0,
                        'jumlah_review_produk' => 0,
                        'rating_produk' => 0.0,
                        'stok_produk' => 10,
                        'harga_produk' => 100000,
                        'id_pengguna' => $penjual->id_pengguna,
                        'gambar_produk' => 'produk/default.png',
                    ]);
                }
            }
        }
    }
}
