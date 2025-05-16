@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
    <div class="container py-4 mt-5 pt-5">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="row border rounded-4 p-4 shadow-sm">
                    <div class="col-md-5 border-end pe-4 d-flex justify-content-center align-items-center">
                        @if ($produk->gambar_produk)
                            <img src="{{ asset('storage/' . $produk->gambar_produk) }}" class="img-fluid rounded"
                                alt="{{ $produk->nama_produk }}">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" class="img-fluid rounded" alt="No Product Image">
                        @endif
                    </div>

                    <div class="col-md-7 ps-4">
                        <div class="d-flex align-items-center mb-2">
                            <div class="d-flex align-items-center text-warning">
                                @for ($i = 0; $i < floor($produk->rating_produk); $i++)
                                    <i class="bi bi-star-fill me-1"></i>
                                @endfor
                                @for ($i = floor($produk->rating_produk); $i < 5; $i++)
                                    <i class="bi bi-star me-1"></i>
                                @endfor
                                <span class="text-dark ms-1">({{ number_format($produk->jumlah_review_produk) }})</span>
                            </div>

                            <div class="border-start ps-3 ms-3 text-success">
                                {{ number_format($produk->stok_produk) }}<span class="fw-bold"> Available</span>
                            </div>
                        </div>

                        <h5 class="text-uppercase text-muted">{{ $produk->nama_produk }}</h5>

                        <h4 class="text-primary mt-2">Rp{{ number_format($produk->harga_produk, 0, ',', '.') }}</h4>

                        <p><strong>{{ $produk->brand ?? $produk->pengguna->nama_pengguna }}</strong></p>

                        <div class="d-flex flex-column gap-3">
                            <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center gap-3">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id_produk }}">
                                {{-- Kontrol jumlah --}}
                                <div class="d-flex align-items-center border px-2 py-1" style="width: 130px; height: 40px;">
                                    <button type="button" class="btn btn-sm border-0 shadow-none px-2"
                                        onclick="ubahJumlah(-1)">−</button>
                                    <input type="number" name="jumlah" id="jumlahInput"
                                        class="form-control border-0 text-center shadow-none px-1" value="1"
                                        min="1" max="{{ $produk->stok_produk }}"
                                        style="width: 60px; font-weight: 500; font-size: 16px;">
                                    <button type="button" class="btn btn-sm border-0 shadow-none px-2"
                                        onclick="ubahJumlah(1)">＋</button>
                                </div>
                                <button type="submit" class="btn btn-cart px-4 py-2"
                                    style="color: #F05A25; border: 1px solid #F05A25;">
                                    Tambah ke Keranjang
                                </button>
                            </form>

                            <form action="{{ route('buynow') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                                <input type="hidden" name="jumlah" value="1">
                                <button type="submit" class="btn text-white px-4 py-2" style="background-color: #F05A25;">
                                    Beli Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center" data-aos="fade-up">
            <div class="col-lg-10">
                <div class="card border rounded-4 shadow-sm p-4">
                    <ul class="nav nav-tabs mb-3 border-0 custom-tabs justify-content-center" id="produkTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc"
                                type="button" role="tab">
                                Deskripsi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review"
                                type="button" role="tab">
                                Ulasan
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="produkTabContent">
                        <div class="tab-pane fade show active" id="desc" role="tabpanel">
                            <h6><strong>Deskripsi barang</strong></h6>
                            <p>{{ $produk->deskripsi_produk }}</p>
                        </div>
                        <div class="tab-pane fade" id="review" role="tabpanel">
                            @forelse($produk->review as $review)
                                <div class="mb-3 border-bottom pb-2">
                                    <div class="text-warning mb-1">
                                        @for ($i = 0; $i < $review->rating_review; $i++)
                                            ★
                                        @endfor
                                        @for ($i = $review->rating_review; $i < 5; $i++)
                                            ☆
                                        @endfor
                                    </div>
                                    <strong>{{ Str::limit($review->pengguna->nama_pengguna, 5, '**') }}</strong>
                                    <p class="mb-0">{{ $review->isi_review }}</p>
                                    <img src="{{ asset('storage/' . $review->gambar_review) }}" alt="Review Image"
                                        width="50" height="50" class="rounded shadow-sm" style="object-fit: cover;">
                                </div>
                            @empty
                                <p>Belum ada ulasan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function ubahJumlah(delta) {
            const input = document.getElementById('jumlahInput');
            let current = parseInt(input.value) || 1;
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || 1;

            current += delta;
            if (current < min) current = min;
            if (current > max) current = max;

            input.value = current;
        }
    </script>
@endpush
