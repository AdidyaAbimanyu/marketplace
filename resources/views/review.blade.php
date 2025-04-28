@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container py-5" style="margin-top: 100px">
        <h5 class="mb-4">Review</h5>

        <div class="p-4 border rounded bg-white" style="max-width: 600px;">
            <form action="{{ route('submit.review') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id_produk }}">

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" value="{{ $product->nama_produk }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Rating</label>
                    <div id="starRating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="far fa-star fa-lg me-1 rating-star text-warning" data-value="{{ $i }}"></i>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating" value="5">
                </div>

                <div class="mb-3">
                    <label for="review" class="form-label">Review</label>
                    <textarea class="form-control" id="review" name="review" rows="4" required></textarea>
                </div>

                <!-- Upload Gambar -->
                <div class="mb-4">
                    <label for="gambar_produk" class="form-label d-block">Foto Produk</label>
                    <div class="border p-4 text-center" style="border-radius: 8px;">
                        <label for="gambar_produk" style="cursor: pointer;">
                            <img src="https://cdn-icons-png.flaticon.com/512/1829/1829135.png" alt="Upload"
                                style="width: 40px;">
                            <p class="mt-2 text-muted">Upload Foto</p>
                        </label>
                        <input type="file" name="gambar_produk" id="gambar_produk" class="d-none" accept="image/*"
                            required>

                        <!-- PREVIEW -->
                        <div class="mt-3">
                            <img id="preview-image" src="#" alt="Preview Gambar" class="img-fluid d-none"
                                style="max-height: 200px; border-radius: 8px;">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning text-white px-4 py-2 fw-bold">
                    SUBMIT <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <!-- Optional: Animasi Hover -->
    <style>
        .rating-star {
            transition: transform 0.2s ease;
            cursor: pointer;
        }

        .rating-star:hover {
            transform: scale(1.2);
        }
    </style>
@endpush

@push('scripts')
    <script>
        const stars = document.querySelectorAll('.rating-star');
        const ratingInput = document.getElementById('rating');

        let selectedRating = ratingInput.value;

        function highlightStars(rating) {
            stars.forEach(star => {
                if (star.dataset.value <= rating) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                }
            });
        }

        // Inisialisasi bintang awal
        highlightStars(selectedRating);

        stars.forEach(star => {
            star.addEventListener('click', function() {
                selectedRating = this.dataset.value;
                ratingInput.value = selectedRating;
                highlightStars(selectedRating);
            });

            star.addEventListener('mouseover', function() {
                highlightStars(this.dataset.value);
            });

            star.addEventListener('mouseout', function() {
                highlightStars(selectedRating);
            });
        });

        const fileInput = document.getElementById('gambar_produk');
        const previewImg = document.getElementById('preview-image');

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                previewImg.src = '#';
                previewImg.classList.add('d-none');
            }
        });
    </script>
@endpush
