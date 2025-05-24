<nav class="navbar navbar-expand-lg shadow-sm fixed-top" style="background-color: #D5EDFF; padding: 10px;">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('static/images/icon.png') }}" alt="SPOT" width="80" height="80">
        </a>

        <form action="{{ route('search') }}" method="GET" class="d-flex mx-auto" role="search" style="width: 50%;">
            <input class="form-control me-2 border border-warning" type="search" placeholder="Cari apapun..."
                aria-label="Search" name="search">
            <button class="btn text-white" type="submit"
                style="background-color: #FF5722; border-radius: 5px;">Cari</button>
        </form>

        <div class="d-flex align-items-center">
            @if (Auth::check())
                @if (Auth::user()->role == 'admin')
                    <button class="me-3 position-relative btn btn-link p-0" data-bs-toggle="modal"
                        data-bs-target="#approveModal">
                        <img src="{{ asset('static/images/bell.png') }}" alt="Cart" width="30">
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $waitingCount ?? 0 }}
                        </span>
                    </button>
                @endif

                <a href="{{ route('cart.index') }}" class="me-3 position-relative">
                    <img src="{{ asset('static/images/cart.png') }}" alt="Cart" width="30">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $cartCount ?? 0 }}
                    </span>
                </a>

                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('static/images/profile.png') }}" alt="User" width="30">
                        <i class="bi bi-caret-down-fill text-dark"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        @if (Auth::user()->role == 'penjual')
                            <li><a class="dropdown-item" href="{{ route('penjual.dashboard') }}">Dashboard Penjual</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @elseif(Auth::user()->role == 'admin')
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @elseif(Auth::user()->role == 'pembeli')
                            <li><a class="dropdown-item" href="{{ route('pembeli.history-order') }}">Riwayat
                                    Pembelian</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('auth') }}" class="btn btn-login"
                    style="color: #F05A25; background-color: #EEE1D0; border-color: #F05A25;">Login</a>
            @endif
        </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Daftar Pesanan Menunggu Persetujuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                @if (isset($pesananMenunggu) && $pesananMenunggu->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesananMenunggu as $pesanan)
                                <tr id="pesanan-{{ $pesanan->id_detail_pesanan }}">
                                    <td>{{ $pesanan->id_detail_pesanan }}</td>
                                    <td>{{ $pesanan->nama_produk }}</td>
                                    <td>{{ $pesanan->jumlah_produk }}</td>
                                    <td>{{ $pesanan->alamat }}</td>
                                    <td>
                                        @if ($pesanan->status_detail_pesanan == 'waiting_to_approve')
                                            <span class="badge bg-warning">Menunggu Pembayaran</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-sm approve-btn"
                                            data-id="{{ $pesanan->id_detail_pesanan }}">Approve</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Tidak ada pesanan yang menunggu persetujuan.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Yakin ingin approve pesanan ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Approve!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang memproses approve pesanan',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/approvement/approve/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        console.log('Response headers:', response.headers);

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            throw new Error('Response bukan JSON');
                        }

                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);

                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message || 'Pesanan berhasil di-approve!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Hapus row dari table
                        const row = document.getElementById(`pesanan-${id}`);
                        if (row) {
                            row.remove();
                        }

                        // Update badge count
                        const badge = document.querySelector('.position-absolute.badge');
                        if (badge) {
                            let count = parseInt(badge.textContent) - 1;
                            badge.textContent = count > 0 ? count : 0;
                            if (count <= 0) {
                                badge.style.display = 'none';
                            }
                        }

                        // Check if table is empty
                        const remainingRows = document.querySelectorAll('#approveModal tbody tr');
                        if (remainingRows.length === 0) {
                            const modalBody = document.querySelector('#approveModal .modal-body');
                            modalBody.innerHTML = '<p>Tidak ada pesanan yang menunggu persetujuan.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);

                        Swal.fire({
                            title: 'Error!',
                            text: `Terjadi kesalahan: ${error.message}`,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            });
        });
    });
});
</script>
@endpush
