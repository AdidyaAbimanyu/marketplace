@extends('layouts.app')

@section('content')
<div class="container py-5" style="margin-top: 100px">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            <img src="{{ asset('storage/'.$product->gambar_produk) }}" class="img-fluid" alt="{{ $product->nama_produk }}">
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <h2>{{ $product->nama_produk }}</h2>
            <p class="text-muted">{{ $product->deskripsi_singkat }}</p>
            <div class="d-flex align-items-center mb-2">
                <span class="text-warning me-2">
                    @for ($i = 0; $i < floor($product->average_rating ?? 5); $i++) ★ @endfor
                    @for ($i = floor($product->average_rating ?? 5); $i < 5; $i++) ☆ @endfor
                </span>
                <span>({{ $product->reviews->count() }} reviews)</span>
                <span class="ms-3 text-success">{{ $product->stok }} Available</span>
            </div>
            <h4 class="text-primary fw-bold">Rp.{{ number_format($product->harga_produk, 0, ',', '.') }}</h4>
            <p>{{ $product->deskripsi_lengkap }}</p>
            <div class="mb-3">
                <span class="badge bg-secondary">{{ $product->kategori }}</span>
            </div>
            <div class="input-group mb-3" style="max-width: 150px;">
                <button class="btn btn-outline-secondary" type="button">-</button>
                <input type="text" class="form-control text-center" value="1">
                <button class="btn btn-outline-secondary" type="button">+</button>
            </div>
            <div class="d-flex gap-2">
                <!-- Buy Now Form -->
                <form action="{{ route('pembeli.checkout') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id_produk }}">
                    <input type="hidden" name="quantity" id="checkout-quantity" value="1">
                    <button type="submit" class="btn btn-primary">BUY NOW</button>
                </form>

                <!-- Add to Cart Form -->
                <form action="{{ route('pembeli.addToCart') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id_produk }}">
                    <input type="hidden" name="quantity" id="cart-quantity" value="1">
                    <button type="submit" class="btn btn-outline-danger">ADD TO CART</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs my-5" id="productTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="review-tab" data-bs-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Review</a>
        </li>
    </ul>

    <div class="tab-content mb-5" id="productTabContent">
        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
            <p>{{ $product->deskripsi_produk }}</p>
        </div>
        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
            @forelse ($product->reviews as $review)
            <div class="mb-4">
                <div class="text-warning">
                    @for ($i = 0; $i < $review->rating; $i++) ★ @endfor
                    @for ($i = $review->rating; $i < 5; $i++) ☆ @endfor
                </div>
                <strong>
                    {{ isset($review->pengguna->nama_pengguna) ? substr($review->pengguna->nama_pengguna, 0, 3) . str_repeat('*', max(strlen($review->pengguna->nama_pengguna) - 4, 1)) . substr($review->pengguna->nama_pengguna, -1) : 'Anonymous' }}
                </strong>        
                <p>{{ $review->komentar }}</p>
            </div>
            @empty
            <p>No reviews yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1) SweetAlert for success flash
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        @endif

        // 2) Your existing increment/decrement logic...
        const decrementBtn = document.querySelector(".input-group button:first-child");
        const incrementBtn = document.querySelector(".input-group button:last-child");
        const quantityInput = document.querySelector(".input-group input");
        const cartQty = document.getElementById("cart-quantity");
        const checkoutQty = document.getElementById("checkout-quantity");

        function updateHiddenInputs(val) {
            cartQty.value = val;
            checkoutQty.value = val;
        }

        decrementBtn.addEventListener("click", () => {
            let currentVal = parseInt(quantityInput.value) || 1;
            if (currentVal > 1) {
                currentVal--;
                quantityInput.value = currentVal;
                updateHiddenInputs(currentVal);
            }
        });

        incrementBtn.addEventListener("click", () => {
            let currentVal = parseInt(quantityInput.value) || 1;
            currentVal++;
            quantityInput.value = currentVal;
            updateHiddenInputs(currentVal);
        });

        quantityInput.addEventListener("input", () => {
            let currentVal = parseInt(quantityInput.value) || 1;
            updateHiddenInputs(currentVal);
        });
    });
</script>
@endpush
