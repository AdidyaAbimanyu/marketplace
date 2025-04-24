@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<div class="container py-5" style="margin-top: 100px">
    <h4>Cart</h4>
    <div class="row">
        <!-- Cart List -->
        <div class="col-md-8">
            <div class="border p-3">
                <table class="table table-borderless align-middle">
                    <thead class="bg-warning-subtle">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th style="width: 150px;">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carts as $cart)
                        <tr class="border-top">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/'.$cart->produk->gambar_produk) }}"
                                         alt="{{ $cart->produk->nama_produk }}"
                                         style="width: 60px; height: auto;"
                                         class="me-3">
                                    <span>{{ $cart->produk->nama_produk }}</span>
                                </div>
                            </td>
                            <td>
                                Rp.<span class="unit-price">{{ number_format($cart->harga_produk, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary btn-decrement" type="button">−</button>
                                    <input type="text"
                                           class="form-control text-center quantity-input"
                                           value="{{ $cart->jumlah_produk }}"
                                           data-price="{{ $cart->harga_produk }}"
                                           data-cart-id="{{ $cart->id }}">
                                    <button class="btn btn-outline-secondary btn-increment" type="button">+</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="col-md-4">
            <div class="border p-4">
                <h5>Cart Totals</h5>
                <table class="table borderless">
                    <tr>
                        <td>Sub Total</td>
                        <td class="text-end">Rp.<span id="subTotalDisplay">0</span></td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td class="text-end text-success" id="shippingDisplay">Free</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td class="text-end text-success">Rp.<span id="discountDisplay">0</span></td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td class="text-end">Rp.<span id="taxDisplay">0</span></td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td><strong>TOTAL</strong></td>
                        <td class="text-end text-primary">Rp.<span id="totalDisplay">0</span></td>
                    </tr>
                </table>
                <a href="{{ route('pembeli.checkout') }}" class="btn btn-warning w-100 fw-bold mt-3">
                    CHECKOUT <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const decButtons  = document.querySelectorAll('.btn-decrement');
    const incButtons  = document.querySelectorAll('.btn-increment');
    const qtyInputs   = document.querySelectorAll('.quantity-input');

    // Summary elements
    const subTotalDisplay = document.getElementById('subTotalDisplay');
    const discountDisplay = document.getElementById('discountDisplay');
    const taxDisplay      = document.getElementById('taxDisplay');
    const totalDisplay    = document.getElementById('totalDisplay');
    const shippingDisplay = document.getElementById('shippingDisplay');

    const SHIPPING = 0;
    const DISCOUNT = 0;
    const TAX = 0;

    function recalcSummary() {
        let subTotal = 0;

        qtyInputs.forEach(input => {
            const price = parseFloat(input.dataset.price) || 0;
            const qty   = parseInt(input.value) || 0;
            subTotal += price * qty;
        });

        const total = subTotal + SHIPPING + TAX - DISCOUNT;

        // Format number with thousands separator
        function format(value) {
            return value.toLocaleString('id-ID');
        }

        subTotalDisplay.textContent = format(subTotal);
        discountDisplay.textContent = format(DISCOUNT);
        taxDisplay.textContent      = format(TAX);
        totalDisplay.textContent    = format(total);
        shippingDisplay.textContent = SHIPPING === 0 ? 'Free' : 'Rp.' + format(SHIPPING);
    }

    // Attach handlers
    decButtons.forEach((btn, i) => {
        btn.addEventListener('click', () => {
            let input = qtyInputs[i];
            let val   = parseInt(input.value) || 1;
            if (val > 1) input.value = val - 1;
            recalcSummary();
        });
    });

    incButtons.forEach((btn, i) => {
        btn.addEventListener('click', () => {
            let input = qtyInputs[i];
            let val   = parseInt(input.value) || 1;
            input.value = val + 1;
            recalcSummary();
        });
    });

    qtyInputs.forEach(input => {
        input.addEventListener('input', () => {
            // ensure only positive integers
            input.value = Math.max(1, parseInt(input.value) || 1);
            recalcSummary();
        });
    });

    // initial calculation on page load
    recalcSummary();
});
</script>
@endpush
@endsection
