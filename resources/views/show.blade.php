@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="container py-5">
        <h5 class="fw-bold mb-4">{{ $title }}</h5>

        @if ($produk->count())
            <div class="row g-4">
                @foreach ($produk as $item)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <a href="{{ route('detail', $item->id_produk) }}" class="text-decoration-none text-dark">
                            <div class="bg-white rounded shadow-sm p-3 h-100 d-flex flex-column show-item">
                                <img src="{{ asset('storage/' . $item->gambar_produk) }}" class="product-image img-fluid mb-3"
                                    alt="{{ $item->nama_produk }}">
                                <div class="d-flex align-items-center mb-2">
                                    <p class="text-warning mb-1">
                                        {{ str_repeat('★', round($item->rating_produk)) }}{{ str_repeat('☆', 5 - round($item->rating_produk)) }}
                                        ({{ number_format($item->jumlah_review_produk) }})
                                    </p>
                                </div>
                                <p class="fw-semibold mb-1 small">{{ $item->nama_produk }}</p>
                                <div class="d-flex">
                                    <span
                                        class="text-primary fw-bold small">Rp.{{ number_format($item->harga_produk, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Tidak ditemukan produk.</p>
        @endif
    </div>
@endsection
