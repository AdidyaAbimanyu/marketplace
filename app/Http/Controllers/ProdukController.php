<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Auth;

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

    public function detail($id)
    {
        $produk = Produk::with(['pengguna', 'review.pengguna'])->findOrFail($id);
        return view('detail', [
            'title' => $produk->nama_produk,
            'produk' => $produk,
        ]);
    }

    public function index()
    {
        $carts = auth()->user()->keranjang()->with('produk')->get();

        // Gunakan jumlah_produk, bukan jumlah
        $total = $carts->sum(fn($item) => $item->produk->harga_produk * $item->jumlah_produk);
        $cartCount = $carts->count();

        return view('cart', compact('carts', 'total', 'cartCount'));
    }

    public function add(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Harap login terlebih dahulu');
        }

        $produkId = $request->input('produk_id');
        $jumlah = $request->input('jumlah');  // Mengambil jumlah dari form
        $userId = auth()->user()->id_pengguna;  // Menggunakan ID pengguna yang sedang login

        // Cari produk berdasarkan produk_id
        $produk = Produk::find($produkId);

        // Pastikan produk ditemukan
        if (!$produk) {
            return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan');
        }

        // Cari produk di keranjang yang sudah ada untuk pengguna ini
        $keranjang = Keranjang::where('id_produk', $produkId)
            ->where('id_pengguna', $userId)
            ->first();

        if ($keranjang) {
            // Jika produk sudah ada di keranjang, update jumlahnya
            $keranjang->jumlah_produk += $jumlah;
            $keranjang->total_harga = $keranjang->jumlah_produk * $produk->harga_produk;  // Update total harga
            $keranjang->save();
        } else {
            // Jika produk belum ada di keranjang, buat entri baru
            Keranjang::create([
                'id_produk' => $produkId,
                'id_pengguna' => $userId,
                'nama_produk' => $produk->nama_produk,
                'harga_produk' => $produk->harga_produk,
                'jumlah_produk' => $jumlah,
                'total_harga' => $jumlah * $produk->harga_produk,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function destroy($cartId)
    {
        $cart = Keranjang::find($cartId);
        if ($cart) {
            $cart->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart');
    }
}
