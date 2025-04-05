@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <div class="container mt-4 pt-5">
        <div class="card p-4 mx-auto" style="border-radius: 10px; max-width: 600px;">
            <h4 class="mb-4 fw-bold">Tambah Produk</h4>

            <form action="{{ route('penjual.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama Produk -->
                <div class="mb-3">
                    <label for="nama_produk" class="form-label">Nama Produk:</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" required>
                </div>

                <!-- Kategori Produk -->
                <div class="mb-3">
                    <label for="kategori_produk" class="form-label">Kategori Produk:</label>
                    <select name="kategori_produk" id="kategori_produk" class="form-select" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @php
                            $categories = [
                                'Elektronik',
                                'Makeup',
                                'Pet',
                                'Sport',
                                'Fashion',
                                'Perlengkapan rumah',
                                'Ibu & bayi',
                                'Travel',
                                'Kesehatan',
                                'Skincare',
                                'Otomotif',
                                'Hobi & Koleksi',
                                'Perlengkapan Sekolah',
                                'Fotografi',
                                'Makanan & Minuman',
                            ];
                        @endphp
                        @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Harga Produk -->
                <div class="mb-3">
                    <label for="harga_produk" class="form-label">Harga:</label>
                    <input type="number" name="harga_produk" id="harga_produk" class="form-control" required>
                </div>

                <!-- Stok Produk -->
                <div class="mb-3">
                    <label class="form-label">Stok:</label>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="adjustStock(-1)">−</button>
                        <input type="number" name="stok_produk" id="stok_produk" class="form-control text-center"
                            value="1" min="1" style="width: 80px;" required>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="adjustStock(1)">+</button>
                    </div>
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

                <!-- Tombol Submit -->
                <div class="text-center">
                    <button type="submit" class="btn btn-orange px-4 py-2"
                        style="background-color: #f97316; color: white; font-weight: bold; border-radius: 5px; display: inline-flex; align-items: center; gap: 8px;">
                        SUBMIT
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function adjustStock(change) {
            const input = document.getElementById('stok_produk');
            let value = parseInt(input.value);
            value += change;
            if (value < 1) value = 1;
            input.value = value;
        }

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
