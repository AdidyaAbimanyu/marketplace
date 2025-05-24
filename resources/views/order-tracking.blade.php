@extends('layouts.app')

@section('content')
    <div class="container py-5" style="margin-top: 100px">
        <div class="bg-light p-5 rounded shadow-sm">

            <!-- Order Info -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <small class="text-muted">No. Order/Resi:</small><br>
                    <span class="text-primary fw-bold fs-5">#{{ $order->id_detail_pesanan }}</span>
                </div>
                <div class="text-end">
                    <small class="text-muted">Total:</small><br>
                    <span class="fs-4 text-danger fw-bold">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            @php
                $status = $order->status_detail_pesanan;
                $steps = ['Waiting for Approve', 'placed', 'packed', 'shipping', 'delivered'];
                $currentStep = array_search($status, $steps);
            @endphp

            <div class="position-relative mb-5" style="height: 50px;">
                <div class="progress-track"></div>
                <div class="progress-fill" style="width: {{ ($currentStep / (count($steps) - 1)) * 100 }}%;"></div>

                <div class="d-flex justify-content-between position-relative" style="z-index:2;">
                    @foreach ($steps as $index => $step)
                        <div class="text-center flex-fill position-relative">
                            <div class="step-icon {{ $index <= $currentStep ? 'completed' : '' }}">
                                <i
                                    class="
                        {{ $step == 'Waiting for Approve' ? 'bi bi-clock' : '' }}
                        {{ $step == 'placed' ? 'bi bi-card-list' : '' }}
                        {{ $step == 'packed' ? 'bi bi-box-seam' : '' }}
                        {{ $step == 'shipping' ? 'bi bi-truck' : '' }}
                        {{ $step == 'delivered' ? 'bi bi-handshake' : '' }}
                    "></i>
                            </div>
                            <div class="step-label {{ $index <= $currentStep ? 'completed' : 'pending' }}">
                                {{ $step == 'Waiting for Approve' ? 'Menunggu Pembayaran' : '' }}
                                {{ $step == 'placed' ? 'Pesanan Diterima' : '' }}
                                {{ $step == 'packed' ? 'Dikemas' : '' }}
                                {{ $step == 'shipping' ? 'Sedang Dalam Perjalanan' : '' }}
                                {{ $step == 'delivered' ? 'Diterima' : '' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <h5 class="mb-3">Order Items</h5>
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Jumalh</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->nama_produk }}</td>
                            <td>{{ $order->jumlah_produk }}</td>
                            <td>Rp {{ number_format($order->harga_produk, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Shipping Address -->
            <h6 class="mt-4">Alamat Pengiriman:</h6>
            <p class="text-muted">{{ $order->alamat }}</p>

            <!-- Button Area -->
            <div class="d-flex justify-content-end mt-4">
                @if ($order->status_detail_pesanan == 'on_delivery')
                    <form action="{{ route('orders.confirm', $order->id_detail_pesanan) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            Pesanan Diterima
                        </button>
                    </form>
                @elseif ($order->status_detail_pesanan == 'delivered')
                    <a href="{{ route('review', $order->id_produk) }}" class="btn btn-primary">
                        Berikan Ulasan
                    </a>
                @endif
            </div>

        </div>
    </div>
@endsection
