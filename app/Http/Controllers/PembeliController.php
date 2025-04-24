<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\ItemPesanan;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembeliController extends Controller
{
    public function home()
    {
        // Produk terbaik (misal berdasarkan kolom best_buy atau sales tertinggi)
        $bestProduct = Produk::first(); // atau 'best_buy' jika pakai flag boolean

        // Produk lainnya (exclude best product jika ingin berbeda)
        $otherProducts = Produk::where('id_produk', '!=', $bestProduct?->id_produk)->latest()->take(6)->get();

        // return [
        //     'bestProduct' => $bestProduct,
        //     'otherProducts' => $otherProducts,
        // ];
        return view('home', compact(['bestProduct', 'otherProducts']));
    }

    public function cart()
    {
        $carts = Keranjang::with('produk')
                    ->where('id_pengguna', auth()->id())
                    ->get();
        
        return view('pembeli.cart', compact('carts'));
    }

    public function addToCart(Request $request)
    {
        // 1) Validate incoming data
        $data = $request->validate([
            'product_id' => 'required|exists:produk,id_produk',
            'quantity'   => 'required|integer|min:1',
        ]);

        // 2) Fetch product
        $product = Produk::findOrFail($data['product_id']);

        // 3) Identify current user
        $userId = auth()->id();
        $qty    = $data['quantity'];

        // 4) See if this user already has that product in their Keranjang
        $cartItem = Keranjang::where('id_pengguna', $userId)
                             ->where('id_produk', $product->id_produk)
                             ->first();

        if ($cartItem) {
            // update existing
            $cartItem->jumlah_produk += $qty;
            $cartItem->total_harga    = $cartItem->jumlah_produk * $product->harga_produk;
            $cartItem->save();
        } else {
            // create new
            Keranjang::create([
                'nama_produk'   => $product->nama_produk,
                'jumlah_produk' => $qty,
                'harga_produk'  => $product->harga_produk,
                'total_harga'   => $qty * $product->harga_produk,
                'id_pengguna'   => $userId,
                'id_produk'     => $product->id_produk,
            ]);
        }

        return redirect()->back()
                         ->with('success', 'Product added to cart successfully!');
    }

    public function buyNowCheckout(Request $request)
    {
        // 1) Validate incoming data
        $request->validate([
            'product_id' => 'required|exists:produk,id_produk',
            'quantity'   => 'required|integer|min:1',
        ]);

        // 2) Fetch product
        $product = Produk::findOrFail($request->product_id);

        // 3) Calculate total price
        $totalPrice = $product->harga_produk * $request->quantity;

        return view('pembeli.checkout', compact('product', 'totalPrice'));
    }

    public function checkout()
    {
        $cartItems = Keranjang::with('produk')
                              ->where('id_pengguna', auth()->id())
                              ->get();

        $subtotal = Keranjang::where('id_pengguna', auth()->id())
                              ->sum('total_harga');

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
        ];

        return view('pembeli.checkout', compact('cartItems', 'data'));
    }

    public function products(Request $request)
    {
        $products = Produk::with(['reviews', 'latestReviews'])
                    ->where('stok_produk', '>', 0)
                    ->get();

        foreach ($products as $product) {
            if ($product->reviews->isNotEmpty()) {
                $avg = $product->reviews->avg('rating');
                $product->setAttribute('average_rating', round($avg, 1));
            } else {
                $product->setAttribute('average_rating', 5); // Default to 5
            }
        }

        return view('pembeli.products', compact(['products']));
    }

    public function productDetail($id)
    {
        $product = Produk::with('latestReviews')->findOrFail($id);

        return view('pembeli.product', compact('product'));
    }

    public function formReview($id)
{
    $product = Produk::findOrFail($id);

    return view('pembeli.review', compact('product'));
}

public function submitReview(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:produk,id_produk',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $fotoPath = null;

    if ($request->hasFile('photo')) {
        $fotoPath = $request->file('photo')->store('reviews', 'public');
    }

    Review::create([
        'produk_id' => $request->product_id,
        'pengguna_id' => auth()->id(),
        'rating' => $request->rating,
        'komentar' => $request->review,
        'foto' => $fotoPath,
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

    return redirect()->route('pembeli.history-order')->with('success', 'Review berhasil dikirim!');
}


    public function orderTracking($id)
    {
        $order = DetailPesanan::with('items', 'items.produk')
            ->where('id_detail_pesanan', $id)
            ->where('id_pengguna', auth()->id())
            ->firstOrFail();

        return view('pembeli.order-tracking', compact('order'));
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

            // Hitung total harga
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

                $totalHarga += $produk->harga_produk * $item['quantity'];
            }

            $detailPesanan = DetailPesanan::create([
                'id_pengguna' => auth()->id(),
                'status_detail_pesanan' => 'order_placed',
                'total_harga' => $totalHarga,
                'address' => $request->input('address'),
            ]);

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

                // Kurangi stok
                $new_stok_produk = $produk->stok_produk - $item['quantity'];
                
                Produk::where('id_produk', $item['id_produk'])
                    ->update(['stok_produk' => $new_stok_produk]);

                // Buat item pesanan
                ItemPesanan::create([
                    'id_detail_pesanan' => $detailPesanan->id_detail_pesanan,
                    'id_produk' => $produk->id_produk,
                    'nama_produk' => $produk->nama_produk,
                    'quantity' => $item['quantity'],
                    'harga_produk' => $produk->harga_produk,
                    'subtotal' => $produk->harga_produk * $item['quantity'],
                ]);
            }

            Keranjang::where('id_pengguna', auth()->id())
                ->delete();

            DB::commit();

            $subtotal = $totalHarga;

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
                ];

            return view('pembeli.payment-success', compact('data'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['items' => $e->getMessage()]);
        }
    }

    public function historyOrder()
    {
        $orders = DetailPesanan::with('items', 'items.produk')
            ->where('id_pengguna', auth()->id())
            ->latest()
            ->get();

        return view('pembeli.history-order', compact('orders'));
    }
}
