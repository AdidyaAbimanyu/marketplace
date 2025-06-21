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
        $produk = auth()->user()->produk;

        $produkTerjualData = Produk::where('id_pengguna', auth()->id())
            ->pluck('jumlah_produk_terjual', 'nama_produk');

        return view('penjual.dashboard', compact('produk', 'produkTerjualData'));
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
            'deskripsi_produk' => 'nullable|string',
            'gambar_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gambarFile = $request->file('gambar_produk');
        $namaFile = uniqid() . '.' . $gambarFile->getClientOriginalExtension();
        $gambarFile->move(public_path('produk'), $namaFile);

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'kategori_produk' => $request->kategori_produk,
            'harga_produk' => $request->harga_produk,
            'stok_produk' => $request->stok_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'gambar_produk' => $namaFile,
            'id_pengguna' => auth()->id(),
        ]);

        return redirect()->route('penjual.dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('penjual.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_produk' => 'required|string',
            'harga_produk' => 'required|numeric',
            'deskripsi_produk' => 'nullable|string',
            'stok_produk' => 'required|integer|min:1',
            'gambar_produk' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar_produk')) {
            if ($produk->gambar_produk && file_exists(public_path('produk/' . $produk->gambar_produk))) {
                unlink(public_path('produk/' . $produk->gambar_produk));
            }

            $gambarFile = $request->file('gambar_produk');
            $namaFile = uniqid() . '.' . $gambarFile->getClientOriginalExtension();
            $gambarFile->move(public_path('produk'), $namaFile);

            $validated['gambar_produk'] = $namaFile;
        }

        $produk->update($validated);

        return redirect()->route('penjual.dashboard')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('penjual.dashboard')->with('success', 'Produk berhasil dihapus');
    }
}
