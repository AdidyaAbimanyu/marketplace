@extends('layouts.app')

@section('title', 'Order History')

@section('content')
    <div class="container py-5" style="margin-top: 100px">
        <h4 class="mb-4">Order History</h4>

        @forelse ($orders as $order)
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Order #{{ $order->id_detail_pesanan }}</h5>
                    <p class="card-text mb-2">
                        @if ($order->status_detail_pesanan == 'placed')
                            <strong>Status:</strong> Diterima <br>
                        @elseif ($order->status_detail_pesanan == 'packed')
                            <strong>Status:</strong> Dikemas <br>
                        @elseif ($order->status_detail_pesanan == 'shipping')
                            <strong>Status:</strong> Sedang Dikirim <br>
                        @elseif ($order->status_detail_pesanan == 'delivered')
                            <strong>Status:</strong> Terkirim <br>
                        @else
                            <strong>Status:</strong> Menunggu Pembayaran <br>
                        @endif
                        <strong>Nama:</strong> {{ $order->nama_produk }} <br>
                        <strong>Alamat:</strong> {{ $order->alamat }} <br>
                        <strong>Total:</strong> Rp {{ number_format($order->total_harga, 0, ',', '.') }} <br>
                        <strong>Jumlah:</strong> {{ $order->jumlah_produk }} produk<br>
                        <strong>Tanggal Pembelian:</strong> {{ $order->created_at->format('d M Y H:i') }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('pembeli.order-tracking', ['id' => $order->id_detail_pesanan]) }}"
                            class="btn btn-sm btn-outline-primary btn-detail" style="color: #F05A25; border: 1px solid #F05A25;">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">Kamu belum order.</div>
        @endforelse
    </div>
@endsection
