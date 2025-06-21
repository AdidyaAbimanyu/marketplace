@extends('layouts.app')

@section('title', 'Dashboard Penjual')

@section('content')
    <main class="container mt-5 pt-5" data-aos="fade-up">
        <div class="card p-3 mt-3" style="border-radius: 10px;">
            <h5 class="mb-3">Daftar Produk Anda</h5>
            <table class="table table-bordered align-middle" style="object-fit: cover;">
                <thead>
                    <tr>
                        <th class="text-center">Product</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produk as $item)
                        <tr>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <img src="{{ secure_asset('public/' . $item->gambar_produk) }}" alt="{{ $item->nama_produk }}"
                                        width="50" height="50" class="rounded shadow-sm" style="object-fit: cover;">
                                    <div class="text-start">
                                        <strong>{{ $item->nama_produk }}</strong><br>
                                        <small class="text-muted">{{ $item->deskripsi_produk }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>Rp.{{ number_format($item->harga_produk, 0, ',', '.') }}</td>
                            <td>{{ $item->stok_produk }}</td>
                            <td class="text-center">
                                <div class="p-2 border rounded d-inline-flex gap-1">
                                    <a href="{{ route('penjual.edit', $item->id_produk) }}" class="btn btn-edit"
                                        style="color: #3FA9F5; background-color: #D5EDFF; border: 1px solid #3FA9F5;">
                                        Edit
                                    </a>
                                    <form action="{{ route('penjual.delete', $item->id_produk) }}" method="POST"
                                        class="form-delete" data-nama="{{ $item->nama_produk }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete"
                                            style="color: #CE6A6C; background-color: #FFE2E3; border: 1px solid #CE6A6C;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Tambah Produk -->
            <div class="d-flex justify-content-end mt-2">
                <a href="{{ route('penjual.add') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-plus-circle"></i> Tambah Produk
                </a>
            </div>
        </div>

        <!-- Grafik Batang -->
        <div class="mb-4 text-center mt-5">
            <div class="card p-3" style="border-radius: 10px;">
                <h5 class="mb-3">Grafik Penjualan Bulan Ini</h5>
                <canvas id="produkTerjualChart" height="200"></canvas>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        const ctxRole = document.getElementById('produkTerjualChart');
        if (ctxRole) {
            new Chart(ctxRole, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($produkTerjualData->keys()) !!},
                    datasets: [{
                        label: 'Jumlah Produk Terjual',
                        data: {!! json_encode($produkTerjualData->values()) !!},
                        backgroundColor: '#3FA9F5',
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

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
