@extends('layouts.app')
@section('title', $title)
@section('content')
    <div class="container py-5">
        <h5 class="fw-bold mb-4">{{ $title }}</h5>

        @if($produk->count())
            <div class="row g-4">
                @foreach ($produk as $item)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="bg-white rounded shadow-sm p-3 h-100 d-flex flex-column show-item">
                            <img src="{{ asset('storage/produk/' . $item->gambar_produk) }}" class="product-image img-fluid mb-3" alt="{{ $item->nama_produk }}">
                            <div class="d-flex align-items-center mb-2">
                                <div class="text-warning me-2 small">★★★★★</div>
                                <small class="text-muted"></small>
                            </div>
                            <p class="fw-semibold mb-1 small">{{ $item->nama_produk }}</p>
                            <div class="d-flex">
                                <span class="text-muted text-decoration-line-through me-2 small">Rp.{{ number_format($item->harga_coret) }}</span>
                                <span class="text-primary fw-bold small">Rp.{{ number_format($item->harga_produk) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Tidak ditemukan produk.</p>
        @endif
    </div>
@endsection
