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
        <form action="{{-- route('review.submit') --}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id_produk }}">

            <div class="mb-3">
                <label class="form-label">Nama produk</label>
                <input type="text" class="form-control" value="{{ $product->nama_produk }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Rating</label>
                <div id="starRating">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa-star fa-lg me-1 rating-star {{ $i <= 4 ? 'fas text-warning' : 'far text-warning' }}" data-value="{{ $i }}"></i>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating" value="4">
            </div>

            <div class="mb-3">
                <label for="review" class="form-label">Review</label>
                <textarea class="form-control" id="review" name="review" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Photos</label>
                <div class="border rounded p-4 text-center" style="cursor: pointer;" onclick="document.getElementById('photo').click()">
                    <i class="fas fa-camera fa-2x text-muted"></i>
                    <p class="text-muted">Upload Photos</p>
                </div>
                <input type="file" id="photo" name="photo" class="d-none" accept="image/*">
            </div>

            <button type="submit" class="btn btn-warning text-white px-4 py-2 fw-bold">
                SUBMIT <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.rating-star').forEach(star => {
        star.addEventListener('click', function () {
            const ratingValue = this.dataset.value;
            document.getElementById('rating').value = ratingValue;
            document.querySelectorAll('.rating-star').forEach(s => {
                s.classList.remove('fas');
                s.classList.add('far');
            });
            for (let i = 0; i < ratingValue; i++) {
                document.querySelectorAll('.rating-star')[i].classList.remove('far');
                document.querySelectorAll('.rating-star')[i].classList.add('fas');
            }
        });
    });
</script>
@endpush
