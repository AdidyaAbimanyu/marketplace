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

        <!-- Progress Bar -->
        @php
            $status = $order->status_detail_pesanan;
            $steps = ['order_placed', 'packaging', 'on_delivery', 'delivered'];
            $currentStep = array_search($status, $steps);
        @endphp

        <div class="position-relative mb-5">
            <div class="progress-track"></div>
            <div class="progress-fill" style="width: {{ ($currentStep / (count($steps) - 1)) * 100 }}%;"></div>

            <div class="d-flex justify-content-between position-relative" style="z-index:2;">
                @foreach ($steps as $index => $step)
                    <div class="text-center flex-fill position-relative">
                        <div class="step-icon {{ $index <= $currentStep ? 'completed' : '' }}">
                            <i class="
                                {{ $step == 'order_placed' ? 'bi bi-card-list' : '' }}
                                {{ $step == 'packaging' ? 'bi bi-box-seam' : '' }}
                                {{ $step == 'on_delivery' ? 'bi bi-truck' : '' }}
                                {{ $step == 'delivered' ? 'bi bi-check-circle' : '' }}
                            "></i>
                        </div>
                        <div class="mt-2">
                            <small class="{{ $index <= $currentStep ? 'text-dark fw-semibold' : 'text-muted' }}">
                                {{ ucwords(str_replace('_', ' ', $step)) }}
                            </small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Items -->
        <h5 class="mb-3">Order Items</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-light">
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
                        <td>Rp{{ number_format($order->harga_produk, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h6 class="mt-4">Alamat Pengiriman:</h6>
        <p class="text-muted">{{ $order->alamat }}</p>

    </div>
</div>

<style>
    .progress-track {
        position: absolute;
        top: 30px;
        left: 0;
        right: 0;
        height: 6px;
        background: #ddd;
        border-radius: 10px;
    }

    .progress-fill {
        position: absolute;
        top: 30px;
        left: 0;
        height: 6px;
        background: orange;
        border-radius: 10px;
        transition: width 0.4s ease;
    }

    .step-icon {
        width: 50px;
        height: 50px;
        background: #ccc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 20px;
        color: white;
        position: relative;
        top: -15px;
    }

    .step-icon.completed {
        background: orange;
        box-shadow: 0 0 10px rgba(255, 165, 0, 0.5);
    }

    .table td, .table th {
        vertical-align: middle;
    }
</style>
