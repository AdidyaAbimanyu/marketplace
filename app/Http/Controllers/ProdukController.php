<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function search(Request $request)
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
