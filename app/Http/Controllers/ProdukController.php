<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function Kategori($kategori)
    {
        $namaKategori = collect([
            'Elektronik',
            'Makeup',
            'Pet',
            'Sport',
            'Fashion',
            'Perlengkapan rumah',
            'Ibu & bayi',
            'Travel',
            'Kesehatan',
            'Skincare',
            'Otomotif',
            'Hobi & Koleksi',
            'Perlengkapan Sekolah',
            'Fotografi',
            'Makanan & Minuman',
        ])->first(function ($nama) use ($kategori) {
            return Str::slug($nama) === $kategori;
        });

        if (!$namaKategori) {
            abort(404); // bisa diganti redirect
        }

        $produk = Produk::where('kategori_produk', $namaKategori)->get();

        return view('show', [
            'produk' => $produk,
            'title' => "Kategori: $namaKategori"
        ]);
    }

    public function Search(Request $request)
    {
        $produk = Produk::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $produk->where(function ($query) use ($search) {
                $query->where('nama_produk', 'like', '%' . $search . '%')
                    ->orWhere('kategori_produk', 'like', '%' . $search . '%');
            });
        }

        $produk = $produk->get();

        return view('show', [
            'produk' => $produk,
            'title' => $request->search ? 'Hasil pencarian: ' . $request->search : 'Semua Produk'
        ]);
    }
}
