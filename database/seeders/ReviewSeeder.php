<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Produk;
use App\Models\Pengguna;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $pembelis = Pengguna::where('role', 'pembeli')->pluck('id_pengguna')->toArray();
        $produks = Produk::all();

        foreach ($produks as $produk) {
            $totalRating = 0;

            for ($i = 0; $i < 5; $i++) {
                $rating = rand(3, 5);
                $totalRating += $rating;

                Review::create([
                    'isi_review' => "Review ke-" . ($i + 1) . " untuk produk " . $produk->nama_produk,
                    'rating_review' => $rating,
                    'id_produk' => $produk->id_produk,
                    'gambar_review' => 'review/default.png',
                    'id_pengguna' => $pembelis[array_rand($pembelis)],
                ]);
            }

            $produk->update([
                'jumlah_review_produk' => 5,
                'rating_produk' => round($totalRating / 5, 1)
            ]);
        }
    }
}
