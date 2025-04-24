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
                <strong>Status:</strong> {{ ucfirst($order->status_detail_pesanan) }} <br>
                <strong>Address:</strong> {{ $order->address }} <br>
                <strong>Total:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }} <br>
                <strong>Order Date:</strong> {{ $order->created_at->format('d M Y H:i') }}
            </p>

            <ul class="list-group mb-3">
                @foreach ($order->items as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $item->nama_produk }}</strong><br>
                            Jumlah: {{ $item->quantity }}<br>
                            Harga: Rp{{ number_format($item->harga_produk, 0, ',', '.') }}
                        </div>
                        <div>
                            @if (!\App\Models\Review::where('produk_id', $item->produk->id_produk)->where('pengguna_id', auth()->id())->exists())
                                <a href="{{ route('review.form', $item->produk->id_produk) }}" class="btn btn-sm btn-outline-warning">
                                    Beri Ulasan
                                </a>
                            @else
                                <span class="badge bg-success">Sudah diulas</span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('pembeli.order-tracking', $order->id_detail_pesanan) }}" class="btn btn-sm btn-outline-primary">
                    Detail
                </a>
            </div>
        </div>
    </div>
    @empty
        <div class="alert alert-info text-center">You have no orders yet.</div>
    @endforelse
</div>
@endsection
