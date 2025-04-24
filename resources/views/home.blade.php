@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="py-5">
        <!-- Hero Section -->
        <div class="container-fluid py-5 position-relative"
            style="min-height: 80vh; background: url('{{ asset('static/images/background.svg') }}') no-repeat center bottom / cover;">
            <div class="container py-4 position-relative">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col-md-6">
                        <p class="text-primary fw-semibold small">THE BEST PLACE TO PLAY</p>
                        <h1 class="fw-bold">Nama barang</h1>
                        <p>Save up to 50%</p>
                        <a href="#" class="btn btn-hero" style="color: #F05A25; border-color: #F05A25;">BUY NOW</a>
                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('static/images/hero.png') }}" alt="Product Image" class="img-fluid"
                            style="max-width: 250px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div id="categories" class="container text-center" data-aos="fade-up">
        <h2 class="fw-bold">Categories</h2>
        <hr style="width: 200px; margin: auto; border-top: 3px solid #D5EDFF;">
        <div class="row row-cols-lg-5 row-cols-md-3 row-cols-2 mt-4 g-3 justify-content-center"
            style="max-width: 1000px; margin: auto;">
            @php
                $categories = [
                    ['name' => 'Elektronik', 'image' => 'elektronik.png', 'bg' => '#F0FDEB'],
                    ['name' => 'Makeup', 'image' => 'makeup.png', 'bg' => '#FFF1EA'],
                    ['name' => 'Pet', 'image' => 'pet.png', 'bg' => '#ECE4FB'],
                    ['name' => 'Sport', 'image' => 'sport.png', 'bg' => '#D5EDFF'],
                    ['name' => 'Fashion', 'image' => 'fashion.png', 'bg' => '#F0FDEB'],
                    ['name' => 'Perlengkapan rumah', 'image' => 'rumah.png', 'bg' => '#FFF1EA'],
                    ['name' => 'Ibu & bayi', 'image' => 'ibudanbayi.png', 'bg' => '#ECE4FB'],
                    ['name' => 'Travel', 'image' => 'travel.png', 'bg' => '#D5EDFF'],
                    ['name' => 'Kesehatan', 'image' => 'kesehatan.png', 'bg' => '#F0FDEB'],
                    ['name' => 'Skincare', 'image' => 'skincare.png', 'bg' => '#FFF1EA'],
                    ['name' => 'Otomotif', 'image' => 'otomotif.png', 'bg' => '#ECE4FB'],
                    ['name' => 'Hobi & Koleksi', 'image' => 'hobidankoleksi.png', 'bg' => '#D5EDFF'],
                    ['name' => 'Perlengkapan Sekolah', 'image' => 'sekolah.png', 'bg' => '#F0FDEB'],
                    ['name' => 'Fotografi', 'image' => 'fotografi.png', 'bg' => '#FFF1EA'],
                    ['name' => 'Makanan & Minuman', 'image' => 'makanandanminuman.png', 'bg' => '#ECE4FB'],
                ];
            @endphp

            @foreach ($categories as $category)
                <div class="col d-flex justify-content-center">
                    <a href="{{ route('search', ['search' => $category['name']]) }}" class="text-decoration-none text-dark">
                        <div class="category-item p-3 mt-5 rounded shadow-sm text-center d-flex flex-column align-items-center justify-content-center"
                            style="background-color: {{ $category['bg'] }}; width: 148px; height: 148px;">
                            <img src="{{ asset('static/images/' . $category['image']) }}" alt="{{ $category['name'] }}"
                                class="img-fluid pt-3" style="max-width: 70px; max-height: 70px;">
                            <p class="mt-2 fw-bold" style="font-size: 12px;">{{ $category['name'] }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="container-fluid py-5 mt-5" style="background-color: #D5EDFF;" data-aos="fade-up">
        <div class="container" style="max-width: 1100px; margin: auto;">
            <!-- Title -->
            <h3 class="text-center fw-bold">Featured Products</h3>
            <hr class="mb-5 pb-5" style="width: 300px; margin: auto; border-top: 3px solid #FCD1B5;">

            <div class="row mt-4 justify-content-center">
                <!-- Left Side: Top Product -->
                @if ($featuredProducts->count())
                    @php
                        $topProduct = $featuredProducts->first();
                        $otherProducts = $featuredProducts->skip(1);
                    @endphp

                    <div class="col-md-4 d-flex" style="min-height: 520px;">
                        <div class="p-3 bg-white rounded shadow-sm w-100 d-flex flex-column justify-content-between features-item"
                            style="position: relative; height: 100%;">

                            <img src="{{ asset('storage/' . $topProduct->gambar_produk) }}"
                                alt="{{ $topProduct->nama_produk }}" class="img-fluid d-block mx-auto">

                            <div class="mt-2 text-center">
                                <p class="text-warning mb-1">★★★★★ ({{ number_format($topProduct->jumlah_review_produk) }})
                                </p>
                                <h5 class="fw-bold">{{ $topProduct->nama_produk }}</h5>
                                <p class="fw-bold" style="color: #3FA9F5">Rp
                                    {{ number_format($topProduct->harga_produk, 0, ',', '.') }}</p>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <a href="#" class="btn text-white w-100" style="background-color: #F05A25">BUY NOW</a>
                                <a href="#" class="btn btn-cart"
                                    style="color: #F05A25; background-color: #EEE1D0; border-color: #F05A25;">
                                    <i class="bi bi-cart"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Other Products -->
                    <div class="col-md-8 d-flex" style="min-height: 520px;">
                        <div class="row g-4 w-100">
                            @foreach ($otherProducts as $product)
                                <div class="col-md-4 d-flex">
                                    <div
                                        class="p-3 bg-white rounded shadow-sm position-relative w-100 d-flex flex-column justify-content-between features-item">

                                        <img src="{{ asset('storage/' . $product->gambar_produk) }}"
                                            alt="{{ $product->nama_produk }}" class="img-fluid d-block mx-auto">

                                        <div class="mt-2 text-center">
                                            <p class="text-warning mb-1">
                                                {{ str_repeat('★', round($product->rating_produk)) }}{{ str_repeat('☆', 5 - round($product->rating_produk)) }}
                                                ({{ number_format($product->jumlah_review_produk) }})
                                            </p>
                                            <h6 class="fw-bold mb-1">{{ $product->nama_produk }}</h6>
                                            <p class="fw-bold mb-0" style="color: #3FA9F5">Rp
                                                {{ number_format($product->harga_produk, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Show all products -->
                <div class="text-end mt-3">
                    <a href="#" class="fw-bold" style="color: #F05A25">Show all product →</a>
                </div>
            </div>
        </div>
    </div>

@endsection
