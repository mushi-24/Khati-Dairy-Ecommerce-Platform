@extends('layouts.app')
@section('title', 'Shopping Cart — Khati Dairy')
@section('content')
<div class="section-head"><div><h2>Shopping Cart</h2></div></div>

@if(empty($cart))
    <div class="empty-state">
        <p>Your cart is empty. Browse products and add items.</p>
        <a class="btn" href="{{ route('products.index') }}">Browse products</a>
    </div>
@else
<form method="POST" action="{{ route('cart.update') }}">@csrf
<div class="table-wrap card" style="padding:0;overflow:hidden">
<table>
    <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Line total</th><th></th></tr></thead>
    <tbody>
    @php $sum = 0; @endphp
    @foreach($cart as $id => $item)
        @php $line = $item['price'] * $item['quantity']; $sum += $line; @endphp
        <tr>
            <td><strong>{{ $item['name'] }}</strong></td>
            <td>৳{{ number_format($item['price'], 2) }}</td>
            <td><input type="number" name="qty[{{ $id }}]" value="{{ $item['quantity'] }}" min="0" style="width:72px"></td>
            <td class="price">৳{{ number_format($line, 2) }}</td>
            <td>
                <button form="rm-{{ $id }}" type="submit" class="btn btn-sm btn-outline">Remove</button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
@foreach($cart as $id => $item)
<form id="rm-{{ $id }}" method="POST" action="{{ route('cart.remove', $id) }}">@csrf @method('DELETE')</form>
@endforeach

<div class="card mt-2" style="max-width:360px;margin-left:auto">
    <div class="flex" style="justify-content:space-between"><span class="muted">Subtotal</span><strong>৳{{ number_format($sum, 2) }}</strong></div>
    <div class="flex mt-1" style="justify-content:space-between"><span class="muted">Delivery (est.)</span><span>৳50.00</span></div>
    <hr style="border:none;border-top:1px solid var(--border);margin:12px 0">
    <div class="flex" style="justify-content:space-between"><strong>Estimated total</strong><strong class="price">৳{{ number_format($sum + 50, 2) }}</strong></div>
    <div class="flex mt-2">
        <button class="btn btn-outline" type="submit">Update cart</button>
        @auth
            <a class="btn" href="{{ route('checkout') }}">Checkout</a>
        @else
            <a class="btn" href="{{ route('login') }}">Login to checkout</a>
        @endauth
    </div>
    <p class="muted mt-1">Payment: Cash on Delivery only. Online payment coming soon.</p>
</div>
</form>
@endif
@endsection
