@extends('layouts.app')

@section('title', 'Dashboard Penjual')

@section('content')
    <main class="container mt-5 pt-5" data-aos="fade-up">
        <div class="card p-3 mt-3" style="border-radius: 10px;">
            <h5 class="mb-3">Daftar Produk Anda</h5>
            <table class="table table-bordered">
                <thead>
                    <tr style="background-color: #f7b17c; color: black;">
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $item)
                        <tr>
                            <td>
                                @if ($item->gambar_produk)
                                    <img src="{{ asset('storage/' . $item->gambar_produk) }}" alt="Gambar Produk"
                                        style="height: 50px;">
                                @else
                                    Tidak ada gambar
                                @endif
                            </td>
                            <td>{{ $item->nama_produk }}</td>
                            <td>{{ $item->stok_produk }}</td>
                            <td>Rp {{ number_format($item->harga_produk, 0, ',', '.') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('penjual.edit', $item->id_produk) }}" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('penjual.delete', $item->id_produk) }}" method="POST"
                                        class="form-delete" data-nama="{{ $item->nama_produk }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Tambah Produk -->
            <div class="d-flex justify-content-end mt-2">
                <a href="{{ route('penjual.add') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-plus-circle"></i> Tambah Produk
                </a>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Konfirmasi Hapus
            document.querySelectorAll('.form-delete').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const nama = this.getAttribute('data-nama');
                    Swal.fire({
                        title: 'Yakin ingin menghapus produk ini?',
                        text: `Produk "${nama}" akan dihapus permanen!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
