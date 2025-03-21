@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container py-5">
        <!-- Hero Section -->
        <div class="container-fluid py-5"
            style="background: url('{{ asset('static/images/background.svg') }}') no-repeat center center / cover; height: ;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="text-primary fw-semibold small">THE BEST PLACE TO PLAY</p>
                        <h1 class="fw-bold">Nama barang</h1>
                        <p>Save up to 50%</p>
                        <a href="#" class="btn btn-outline-danger">BUY NOW</a>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('path-ke-gambar.png') }}" alt="Product Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div id="categories" class="container text-center p-5">
            <h2 class="fw-bold">Categories</h2>
            <div class="row row-cols-lg-5 row-cols-md-3 row-cols-2 mt-4 g-3 justify-content-center">
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
                        <div class="category-item p-3 mt-5 rounded shadow-sm text-center d-flex flex-column align-items-center justify-content-center"
                            style="background-color: {{ $category['bg'] }}; width: 148px; height: 148px;">
                            <img src="{{ asset('static/images/' . $category['image']) }}" alt="{{ $category['name'] }}"
                                class="img-fluid pt-3" style="max-width: 70px; max-height: 70px;">
                            <p class="mt-2 fw-bold" style="font-size: 12px;">{{ $category['name'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
