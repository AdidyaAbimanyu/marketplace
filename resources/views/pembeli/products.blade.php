@extends('layouts.app')

@section('content')
<div class="container py-5" style="background-color: #E9F6FF;" style="margin-top: 100px">
    <h5 class="mb-4" style="margin-top: 50px">Product</h5>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        @foreach($products as $product)
        <div class="col">
            <a href="{{ route('pembeli.product', $product->id_produk) }}" class="text-decoration-none text-dark">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <img src="{{ asset('storage/'.$product->gambar_produk) }}" class="card-img-top mx-auto p-4" style="height: 220px; width: auto;" alt="{{ $product->nama_produk }}">
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="text-warning">
                                @for ($i = 0; $i < floor($product->average_rating ?? 5); $i++)
                                    ★
                                @endfor
                                @for ($i = floor($product->average_rating ?? 5); $i < 5; $i++)
                                    ☆
                                @endfor
                            </span>
                            <span class="text-muted">({{ $product->reviews->count() }} review)</span>
                        </div>
                        <h6 class="card-title">{{ $product->nama_produk }}</h6>
                        <p class="card-text mb-0">
                            <span class="text-primary fw-bold">Rp.{{ number_format($product->harga_produk, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
