@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <div class="container py-5" style="margin-top: 100px">
        <h4>Keranjang</h4>
        @if ($carts->isNotEmpty())
            <div class="row">
                <div class="col-md-8">
                    <div class="card border p-3">
                        <table class="table align-middle mb-0">
                            <thead style="background-color: #fde3d9;">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                    <tr>
                                        <td class="d-flex align-items-center gap-3">
                                            <img src="{{ secure_asset('storage/' . $cart->produk->gambar_produk) }}"
                                                alt="Product Image" width="50">
                                            <span>{{ $cart->produk->nama_produk }}</span>
                                        </td>
                                        <td>Rp.{{ number_format($cart->produk->harga_produk / 1000, 3) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center border px-2 py-1"
                                                style="width: 130px; height: 40px;">
                                                <a href="{{ route('cart.updateJumlah', ['id' => $cart->id_keranjang, 'aksi' => 'minus']) }}"
                                                    class="btn btn-sm border-0 shadow-none px-2">−</a>
                                                <input type="text" name="jumlah"
                                                    class="form-control border-0 text-center shadow-none px-1"
                                                    value="{{ $cart->jumlah_produk }}" readonly
                                                    style="width: 60px; font-weight: 500; font-size: 16px;">

                                                <a href="{{ route('cart.updateJumlah', ['id' => $cart->id_keranjang, 'aksi' => 'plus']) }}"
                                                    class="btn btn-sm border-0 shadow-none px-2">＋</a>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('cart.destroy', $cart->id_keranjang) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="border p-4">
                        <h5>Total Keranjang</h5>
                        <table class="table borderless">
                            <tr>
                                <td>Sub Total</td>
                                <td class="text-end">Rp.{{ number_format($data['subtotal'], 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Pengiriman</td>
                                <td class="text-end text-success">
                                    {{ $data['shipping_cost'] > 0 ? 'Rp.' . number_format($data['shipping_cost'], 0, ',', '.') : 'Free' }}
                                </td>
                            </tr>
                            <tr>
                                <td>Diskon</td>
                                <td class="text-end text-success">Rp.{{ number_format($data['discount'], 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Pajak</td>
                                <td class="text-end">Rp.{{ number_format($data['tax'], 0, ',', '.') }}</td>
                            </tr>
                            <hr>
                            <tr>
                                <td><strong>TOTAL</strong></td>
                                <td class="text-end text-primary">
                                    <strong>Rp.{{ number_format($data['total_price'], 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                        </table>
                        <a href="{{ route('cart.checkout') }}" class="text-decoration-none mt-5">
                            <button type="submit" id="signUpBtn" class="btn text-white w-100 fw-bold mt-3"
                                style="background-color: #FF5722; color: white;">
                                CHECKOUT →
                            </button>
                        </a>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center mt-5">Kamu belum menambahkan produk</div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tombol plus dan minus
            document.querySelectorAll('button[data-action="plus"], button[data-action="minus"]').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.closest('td').querySelector('.jumlah-input');
                    const delta = this.dataset.action === 'plus' ? 1 : -1;
                    ubahJumlah(delta, input);
                });
            });

            // Ketika user mengetik langsung
            document.querySelectorAll('.jumlah-input').forEach(input => {
                input.addEventListener('input', updateTotalHarga);
            });

            // Fungsi ubah jumlah
            function ubahJumlah(delta, input) {
                let current = parseInt(input.value) || 1;
                const min = parseInt(input.min) || 1;
                const max = parseInt(input.max) || 1000;
                current += delta;
                if (current < min) current = min;
                if (current > max) current = max;
                input.value = current;
                updateTotalHarga();
            }

            // Fungsi hitung ulang total
            function updateTotalHarga() {
                let subtotal = 0;
                document.querySelectorAll('.jumlah-input').forEach(input => {
                    const jumlah = parseInt(input.value) || 0;
                    const harga = parseInt(input.dataset.harga) || 0;
                    subtotal += jumlah * harga;
                });

                const shipping = {{ $data['shipping_cost'] }};
                const discount = {{ $data['discount'] }};
                const tax = subtotal * 0.1;
                const total = subtotal + shipping - discount + tax;

                document.getElementById('subtotal-display').innerText = formatRupiah(subtotal);
                document.querySelectorAll('.d-flex span:nth-child(2)')[2].innerText = formatRupiah(tax);
                document.querySelector('.text-primary').innerText = formatRupiah(total);
            }

            // Format angka ke Rupiah
            function formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }

            // Inisialisasi awal
            updateTotalHarga();
        });
    </script>
@endpush
