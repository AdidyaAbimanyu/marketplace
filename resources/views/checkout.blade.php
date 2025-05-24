@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container py-5" style="margin-top: 100px">
        <h4>Checkout</h4>
        <form action="{{ route('pembeli.payment-process') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Cart List -->
                <div class="col-md-8">
                    <div class="border p-3">
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" name="address" id="address" rows="9" placeholder="Masukkan alamat lengkap"
                                name="alamat" required></textarea>
                        </div>
                        <h5 class="mt-4">Produk</h5>
                        <ul class="list-group">
                            @foreach ($cartItems as $index => $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item->produk->nama_produk ?? 'Produk tidak ditemukan' }} (x
                                    {{ $item->jumlah_produk }})
                                    <span class="badge bg-primary rounded-pill">Rp.
                                        {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                                </li>

                                <input type="hidden" name="items[{{ $index }}][id_produk]"
                                    value="{{ $item->id_produk }}">
                                <input type="hidden" name="items[{{ $index }}][quantity]"
                                    value="{{ $item->jumlah_produk }}">
                            @endforeach
                        </ul>
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
                        <!-- Pilihan metode pembayaran palsu -->
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Pilih Metode Pembayaran</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Metode Pembayaran --</option>
                                <option value="transfer_bank">Transfer Bank</option>
                                <option value="cod">Cash on Delivery</option>
                                <option value="e_wallet">QRIS</option>
                            </select>
                        </div>
                        <button type="submit" class="btn text-white w-100 fw-bold mt-3" style="background-color: #F05A25">
                            PEMBAYARAN →</i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'Oke'
            });
        </script>
    @endif
@endpush
