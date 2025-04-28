@extends('layouts.app')

@section('content')
<div class="container py-5 text-center" style="margin-top: 100px">
    <div class="mb-4">
        <svg width="72" height="72" fill="none" viewBox="0 0 24 24" stroke="green" stroke-width="2">
            <circle cx="12" cy="12" r="10" stroke="green" stroke-width="2"/>
            <path stroke="green" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4-4"/>
        </svg>
    </div>

    <h4 class="mb-4">Your Payment has been <strong>Successfull</strong></h4>

    <div class="border mx-auto p-4" style="max-width: 400px;">
        <h5 class="text-start mb-3">Cart Totals</h5>
        <table class="table table-borderless mb-0">
            <tr>
                <td class="text-start">Sub Total</td>
                <td class="text-end">Rp.{{ number_format($data['subtotal'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-start">Shipping</td>
                <td class="text-end text-success">
                    @if ($data['shipping_cost'] == 0)
                        Free
                    @else
                        Rp.{{ number_format($data['shipping_cost'], 0, ',', '.') }}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-start">Discount</td>
                <td class="text-end">Rp.{{ number_format($data['discount'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-start">Tax</td>
                <td class="text-end">Rp.{{ number_format($data['tax'], 0, ',', '.') }}</td>
            </tr>
            <tr><td colspan="2"><hr class="my-2"></td></tr>
            <tr>
                <td><strong>TOTAL</strong></td>
                <td class="text-end text-primary"><strong>Rp.{{ number_format($data['total_price'], 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <a href="{{ route('pembeli.history-order') }}" class="btn btn-outline-warning mt-4 px-4 py-2 fw-bold">
        Lihat History Order
    </a>
</div>
@endsection
