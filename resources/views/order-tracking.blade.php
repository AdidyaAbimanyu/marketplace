@extends('layouts.app')

@section('content')
    <div class="container py-5" style="margin-top: 100px">
        <div class="bg-light p-4 rounded">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <small class="text-muted">No. Order/Resi:</small><br>
                    <span class="text-primary fw-bold">#{{ $order->id_detail_pesanan }}</span>
                </div>
                <div class="text-end">
                    <small class="text-muted">Total:</small><br>
                    <span class="fs-4 text-danger fw-bold">Rp.{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="d-flex justify-content-between text-center mb-4">
                @php
                    $status = $order->status_detail_pesanan;
                    $steps = ['order_placed', 'packaging', 'on_delivery', 'delivered'];
                    $currentStep = array_search($status, $steps);
                @endphp

                @foreach ($steps as $index => $step)
                    <div class="flex-fill">
                        <div
                            class="progress-step
                        {{ $index < $currentStep ? 'completed' : '' }}
                        {{ $index === $currentStep ? 'current' : '' }}">
                        </div>
                        <i
                            class="
                        fs-4 d-block
                        {{ $step == 'order_placed' ? 'bi bi-card-list' : '' }}
                        {{ $step == 'packaging' ? 'bi bi-box' : '' }}
                        {{ $step == 'on_delivery' ? 'bi bi-truck' : '' }}
                        {{ $step == 'delivered' ? 'bi bi-handshake' : '' }}
                        {{ $index < $currentStep ? 'text-success' : ($index === $currentStep ? 'text-warning' : 'text-muted') }}">
                        </i>
                        <small>
                            {{ ucwords(str_replace('_', ' ', $step)) }}
                        </small>
                    </div>
                @endforeach
            </div>

            <!-- Order Items -->
            <h5 class="mt-5 mb-3">Order Items</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $order->nama_produk }}</td>
                        <td>{{ $order->jumlah_produk }}</td>
                        <td>Rp.{{ number_format($order->harga_produk, 0, ',', '.') }}</td>
                        <td>Rp.{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Alamat -->
            <h6 class="mt-4">Alamat Pengiriman:</h6>
            <p>{{ $order->alamat }}</p>
        </div>
    </div>

    <style>
        .progress-step {
            height: 6px;
            background: #f0f0f0;
            margin-bottom: 8px;
            position: relative;
        }

        .progress-step.completed::before {
            content: '';
            width: 100%;
            height: 100%;
            background: orange;
            position: absolute;
        }

        .progress-step.current::before {
            content: '';
            width: 50%;
            height: 100%;
            background: orange;
            position: absolute;
        }
    </style>
@endsection
