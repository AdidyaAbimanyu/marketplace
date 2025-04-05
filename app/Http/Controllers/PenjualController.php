<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenjualController extends Controller
{
    public function dashboard()
    {
        $produk = Produk::where('id_pengguna', auth()->id())->get();

        return view('penjual.dashboard', compact('produk'));
    }

    public function add()
    {
        return view('penjual.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric|min:0',
            'stok_produk' => 'required|integer|min:1',
            'gambar_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gambarPath = $request->file('gambar_produk')->store('produk', 'public');

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'kategori_produk' => $request->kategori_produk,
            'harga_produk' => $request->harga_produk,
            'stok_produk' => $request->stok_produk,
            'gambar_produk' => $gambarPath,
            'id_pengguna' => auth()->id(),
        ]);

        return redirect()->route('penjual.dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil dihapus');
    }
}
