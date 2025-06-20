<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Review;
use DB;
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

        $produk->orderByDesc('rating_produk')
            ->orderByDesc('jumlah_produk_terjual');

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

    public function cart()
    {
        $carts = auth()->user()->keranjang()->with('produk')->get();

        $subtotal = $carts->sum(fn($item) => $item->produk->harga_produk * $item->jumlah_produk);

        $shippingCost = 10000;
        $discount = 0;
        $taxRate = 0.1;
        $tax = $subtotal * $taxRate;
        $totalPrice = $subtotal + $shippingCost - $discount + $tax;

        $data = [
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'discount' => $discount,
            'tax' => $tax,
            'total_price' => $totalPrice,
        ];

        return view('cart', compact('carts', 'data'));
    }

    public function updateJumlah($id, $aksi)
    {
        $cart = Keranjang::findOrFail($id);

        if ($cart->id_pengguna != auth()->id()) {
            abort(403);
        }

        if ($aksi === 'plus') {
            $cart->jumlah_produk += 1;
        } elseif ($aksi === 'minus') {
            if ($cart->jumlah_produk > 1) {
                $cart->jumlah_produk -= 1;
            }
        }

        $cart->save();

        return redirect()->route('cart.index');
    }

    public function add(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Harap login terlebih dahulu');
        }

        $produkId = $request->input('produk_id');
        $jumlah = $request->input('jumlah');
        $userId = auth()->user()->id_pengguna;

        $produk = Produk::find($produkId);

        if (!$produk) {
            return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan');
        }

        $keranjang = Keranjang::where('id_produk', $produkId)
            ->where('id_pengguna', $userId)
            ->first();

        if ($keranjang) {
            $keranjang->jumlah_produk += $jumlah;
            $keranjang->total_harga = $keranjang->jumlah_produk * $produk->harga_produk;  // Update total harga
            $keranjang->save();
        } else {
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
    public function buynow(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Harap login terlebih dahulu');
        }

        $id_produk = $request->input('produk_id');

        $jumlah = $request->input('jumlah', 1);

        $produk = Produk::findOrFail($id_produk);

        session([
            'checkout' => [
                'id_produk' => $produk->id_produk,
                'nama_produk' => $produk->nama_produk,
                'harga_produk' => $produk->harga_produk,
                'jumlah' => $jumlah,
                'total' => $produk->harga_produk * $jumlah,
            ]
        ]);
        return redirect()->route('cart.checkout', ['from' => 'buynow']);
    }

    public function checkout(Request $request)
    {
        $isBuyNow = $request->query('from') === 'buynow';

        $sessionCheckout = session('checkout');

        if ($isBuyNow && $sessionCheckout) {
            $produk = Produk::find($sessionCheckout['id_produk']);

            if (!$produk) {
                return redirect()->route('home')->with('error', 'Produk tidak ditemukan.');
            }

            $item = (object) [
                'produk' => $produk,
                'jumlah_produk' => $sessionCheckout['jumlah'],
                'total_harga' => $sessionCheckout['total'],
                'id_produk' => $sessionCheckout['id_produk'],
            ];

            $cartItems = collect([$item]);
            $subtotal = $sessionCheckout['total'];
        } else {
            $cartItems = Keranjang::with('produk')
                ->where('id_pengguna', auth()->id())
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('home')->with('error', 'Keranjang kosong dan tidak ada data checkout.');
            }

            $subtotal = $cartItems->sum(fn($item) => $item->produk->harga_produk * $item->jumlah_produk);
        }

        $shippingCost = 10000;
        $discount = 0;
        $taxRate = 0.1;
        $tax = $subtotal * $taxRate;
        $totalPrice = $subtotal + $shippingCost - $discount + $tax;

        $data = [
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'discount' => $discount,
            'tax' => $tax,
            'total_price' => $totalPrice,
        ];

        return view('checkout', compact('cartItems', 'data'));
    }

    public function fakePayment(Request $request)
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
                    ->where('stok_produk', '>=', $item['quantity'])
                    ->first();

                if (!$produk) {
                    throw new \Exception('Produk tidak ditemukan atau stok tidak mencukupi.');
                }

                $subtotal = $produk->harga_produk * $item['quantity'];
                $totalHarga += $subtotal;

                $produk->update(['stok_produk' => $produk->stok_produk - $item['quantity']]);

                $produkPesanan[] = [
                    'id_produk' => $produk->id_produk,
                    'nama_produk' => $produk->nama_produk,
                    'jumlah' => $item['quantity'],
                    'harga' => $produk->harga_produk,
                    'subtotal' => $subtotal,
                ];
            }

            $shippingCost = 10000;
            $discount = 0;
            $taxRate = 0.1;
            $tax = $totalHarga * $taxRate;
            $grandTotal = $totalHarga + $shippingCost - $discount + $tax;

            foreach ($produkPesanan as $index => $item) {
                DetailPesanan::create([
                    'id_pengguna' => auth()->id(),
                    'id_produk' => $item['id_produk'],
                    'jumlah_produk' => $item['jumlah'],
                    'alamat' => $request->address,
                    'nama_produk' => $item['nama_produk'],
                    'status_detail_pesanan' => 'waiting_to_approve',
                    'total_harga' => $index === 0 ? $grandTotal : 0, // hanya baris pertama yg menyimpan total harga
                ]);
            }

            Keranjang::where('id_pengguna', auth()->id())->delete();

            DB::commit();

            $data = [
                'produk' => $produkPesanan,
                'subtotal' => $totalHarga,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'tax' => $tax,
                'total_price' => $grandTotal,
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

        // Cek apakah user sudah pernah review produk ini
        $alreadyReviewed = Review::where('id_produk', $request->product_id)
            ->where('id_pengguna', auth()->id())
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->back()->withErrors(['review' => 'Kamu sudah memberikan ulasan untuk produk ini.']);
        }

        $fotoPath = null;
        if ($request->hasFile('gambar_review')) {
            $file = $request->file('gambar_review');
            $namaFile = 'review/' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('review'), $namaFile);
            $fotoPath = $namaFile;
        }

        Review::create([
            'id_produk' => $request->product_id,
            'id_pengguna' => auth()->id(),
            'rating_review' => $request->rating,
            'isi_review' => $request->review,
            'gambar_review' => $fotoPath,
        ]);

        return redirect()->route('pembeli.history-order')->with('success', 'Review berhasil dikirim!');
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
            $photo = $request->file('photo');
            $namaFile = 'review/' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('reviews'), $namaFile);
            $review->foto = $namaFile;
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

        if ($order->status_detail_pesanan == 'shipping') {
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

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang');
    }
}
