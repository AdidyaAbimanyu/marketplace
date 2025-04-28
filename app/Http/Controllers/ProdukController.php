<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Review;
use DB;
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

    public function buyNowCheckout(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id_produk',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        // Cek stok
        if ($produk->stok_produk < $request->jumlah) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $produkId = $request->input('produk_id');
        $jumlah = $request->input('jumlah');

        $produk = Produk::findOrFail($produkId);

        if ($produk->stok_produk < $jumlah) {
            return redirect()->back()->with('error', 'Stok produk tidak cukup.');
        }

        $subtotal = $produk->harga_produk * $jumlah;
        $shippingCost = 0;
        $discount = 0;
        $tax = 0;
        $totalPrice = $subtotal + $shippingCost - $discount + $tax;

        $cartItems = [
            [
                'produk' => $produk,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ]
        ];

        $data = [
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'discount' => $discount,
            'tax' => $tax,
            'total_price' => $totalPrice,
            'is_buy_now' => true, // tambahan flag
        ];

        return view('checkout', compact('cartItems', 'data'));
    }


    public function checkout()
    {
        $cartItems = Keranjang::with('produk')
            ->where('id_pengguna', auth()->id())
            ->get();

        $subtotal = $cartItems->sum(fn($item) => $item->produk->harga_produk * $item->jumlah_produk);

        $shippingCost = 0;
        $discount = 0;
        $tax = 0;
        $totalPrice = $subtotal + $shippingCost - $discount + $tax;

        $data = [
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'discount' => $discount,
            'tax' => $tax,
            'total_price' => $totalPrice,
            'is_buy_now' => false, // checkout biasa
        ];

        return view('checkout', compact('cartItems', 'data'));
    }



    public function paymentProcess(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.id_produk' => 'required|integer|exists:produk,id_produk',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $totalHarga = 0;
            $produkPesanan = [];

            foreach ($request->items as $item) {
                $produk = Produk::where('id_produk', $item['id_produk'])
                    ->where('stok_produk', '>', 0)
                    ->first();

                if (!$produk) {
                    throw new \Exception('Produk tidak ditemukan atau stok habis: ' . $item['id_produk']);
                }

                if ($produk->stok_produk < $item['quantity']) {
                    throw new \Exception('Stok tidak cukup untuk produk: ' . $produk->nama_produk);
                }

                // Hitung subtotal dan update stok
                $subtotal = $produk->harga_produk * $item['quantity'];
                $totalHarga += $subtotal;

                $produk->update(['stok_produk' => $produk->stok_produk - $item['quantity']]);

                // Buat satu baris detail_pesanan untuk produk ini
                DetailPesanan::create([
                    'id_pengguna' => auth()->id(),
                    'id_produk' => $produk->id_produk,
                    'jumlah_produk' => $item['quantity'],
                    'alamat' => $request->address,
                    'nama_produk' => $produk->nama_produk,
                    'status_detail_pesanan' => 'on_delivery',
                    'total_harga' => $subtotal,
                ]);

                // Simpan data untuk tampilan
                $produkPesanan[] = [
                    'nama_produk' => $produk->nama_produk,
                    'jumlah' => $item['quantity'],
                    'harga' => $produk->harga_produk,
                    'subtotal' => $subtotal,
                ];
            }

            // Kosongkan keranjang
            Keranjang::where('id_pengguna', auth()->id())->delete();

            DB::commit();

            $subtotal = $totalHarga;
            $shippingCost = 0;
            $discount = 0;
            $tax = 0;
            $totalPrice = $subtotal + $shippingCost - $discount + $tax;

            $data = [
                'produk' => $produkPesanan,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'tax' => $tax,
                'total_price' => $totalPrice,
            ];

            return view('payment-success', compact('data'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['items' => $e->getMessage()]);
        }
    }

    public function historyOrder()
    {
        $orders = DetailPesanan::where('id_pengguna', auth()->id())
            ->latest()
            ->get();

        return view('history-order', compact('orders'));
    }

    public function formReview($id)
    {
        $product = Produk::findOrFail($id);

        return view('review', compact('product'));
    }

    public function submitReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id_produk',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
            'gambar_review' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar_review')) {
            $fotoPath = $request->file('gambar_review')->store('review', 'public');
        }

        Review::create([
            'id_produk' => $request->product_id,
            'id_pengguna' => auth()->id(),
            'rating_review' => $request->rating,
            'isi_review' => $request->review,
            'gambar_review' => $fotoPath,
        ]);

        return redirect()->route('pembeli.history-order')->with('success', 'Review berhasil dikirim!');

        if ($alreadyReviewed) {
            return redirect()->back()->withErrors(['review' => 'Kamu sudah memberikan ulasan untuk produk ini.']);
        }
    }

    public function storeReview(Request $request, $id)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $review = new Review();
        $review->produk_id = $id;
        $review->pengguna_id = auth()->id();
        $review->rating = $validated['rating'];
        $review->komentar = $validated['review'];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('reviews', 'public');
            $review->foto = $path;
        }

        $review->save();

        return redirect()->route('history-order')->with('success', 'Review berhasil dikirim!');
    }

    public function orderTracking($id)
    {
        $order = DetailPesanan::where('id_detail_pesanan', $id)
            ->where('id_pengguna', auth()->id())
            ->firstOrFail();

        return view('order-tracking', compact('order'));
    }

    public function confirm($id)
    {
        $order = DetailPesanan::findOrFail($id);

        if ($order->status_detail_pesanan == 'on_delivery') {
            $order->status_detail_pesanan = 'delivered';
            $order->save();
        }

        Produk::where('id_produk', $order->id_produk)
            ->increment('jumlah_produk_terjual', $order->jumlah_produk);

        return redirect()->back()->with('success', 'Pesanan telah diterima.');
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
