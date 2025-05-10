@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <div class="container py-5" style="margin-top: 100px">
        <h4>Keranjang</h4>
        @if ($carts->isNotEmpty())
            <div class="row">
                <div class="col-md-8">
                    <div class="card border p-3">
                        <table class="table align-middle mb-0">
                            <thead style="background-color: #fde3d9;">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                    <tr>
                                        <td class="d-flex align-items-center gap-3">
                                            <img src="{{ asset('storage/' . $cart->produk->gambar_produk) }}"
                                                alt="Product Image" width="50">
                                            <span>{{ $cart->produk->nama_produk }}</span>
                                        </td>
                                        <td>Rp.{{ number_format($cart->produk->harga_produk / 1000, 3) }}</td>
                                        <td>
                                            <div class="input-group" style="max-width: 120px;">
                                                <button class="btn btn-outline-secondary btn-minus" type="button"
                                                    data-id="{{ $cart->id }}">−</button>
                                                <input type="text" class="form-control text-center qty-input"
                                                    value="{{ $cart->jumlah_produk }}" readonly>
                                                <button class="btn btn-outline-secondary btn-plus" type="button"
                                                    data-id="{{ $cart->id }}">+</button>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('cart.destroy', $cart->id_keranjang) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Ringkasan Cart --}}
                <div class="col-md-4">
                    <div class="card border p-4">
                        <h6 class="fw-bold mb-3">Total Keranjang</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pengiriman</span>
                            <span class="text-black">Rp {{ number_format($data['shipping_cost'], 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Diskon</span>
                            <span class="text-black">Rp {{ number_format($data['discount'], 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pajak</span>
                            <span class="text-black">Rp {{ number_format($data['tax'], 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold mt-3">
                            <span>TOTAL</span>
                            <span class="text-primary">Rp {{ number_format($data['total_price'], 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('cart.checkout') }}" class="text-decoration-none mt-5">
                            <button type="submit" id="signUpBtn" class="btn w-100"
                                style="background-color: #FF5722; color: white;">
                                CHECKOUT →
                            </button>
                        </a>
                    </div>
                </div>
        @else
            <div class="alert alert-info text-center mt-5">Kamu belum menambahkan produk</div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.btn-plus').forEach(btn => {
            btn.addEventListener('click', function() {
                let input = this.parentElement.querySelector('.qty-input');
                let newQty = parseInt(input.value) + 1;
                input.value = newQty;
            });
        });

        document.querySelectorAll('.btn-minus').forEach(btn => {
            btn.addEventListener('click', function() {
                let input = this.parentElement.querySelector('.qty-input');
                let newQty = parseInt(input.value) > 1 ? parseInt(input.value) - 1 : 1;
                input.value = newQty;
            });
        });
    </script>
@endpush
