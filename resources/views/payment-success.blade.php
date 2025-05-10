@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5 text-center">
    <div class="mb-4">
        <svg width="72" height="72" fill="none" viewBox="0 0 24 24" stroke="green" stroke-width="2">
            <circle cx="12" cy="12" r="10" stroke="green" stroke-width="2"/>
            <path stroke="green" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4-4"/>
        </svg>
    </div>

    <h4 class="mb-4">Pembayaranmu sudah <strong>Berhasil</strong></h4>

    <div class="border mx-auto p-4" style="max-width: 400px;">
        <h5 class="text-start mb-3">Total Keranjang</h5>
        <table class="table table-borderless mb-0">
            <tr>
                <td class="text-start">Sub Total</td>
                <td class="text-end">Rp.{{ number_format($data['subtotal'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-start">Pengiriman</td>
                <td class="text-end text-success">
                    @if ($data['shipping_cost'] == 0)
                        Gratis
                    @else
                        Rp.{{ number_format($data['shipping_cost'], 0, ',', '.') }}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-start">Diskon</td>
                <td class="text-end">Rp {{ number_format($data['discount'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-start">Pajak</td>
                <td class="text-end">Rp {{ number_format($data['tax'], 0, ',', '.') }}</td>
            </tr>
            <tr><td colspan="2"><hr class="my-2"></td></tr>
            <tr>
                <td><strong>TOTAL</strong></td>
                <td class="text-end text-primary"><strong>Rp {{ number_format($data['total_price'], 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <a href="{{ route('pembeli.history-order') }}" class="btn btn-history mt-4 px-4 py-2 fw-bold" style="color: #F05A25; background-color: #EEE1D0; border-color: #F05A25;">
        Lihat Riwayat Pembelian
    </a>
</div>
@endsection
