@extends('layouts.app')
@section('title', 'Checkout — Khati Dairy')
@section('content')
<div class="section-head"><div><h2>Checkout</h2><p class="sub">Cash on Delivery · Secure order placement</p></div></div>
<div class="detail-grid">
    <form method="POST" action="{{ route('checkout.place') }}" class="card">
        @csrf
        <div class="form-group">
            <label for="customer_name">Full name *</label>
            <input id="customer_name" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="customer_phone">Phone *</label>
                <input id="customer_phone" name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone) }}" required>
            </div>
            <div class="form-group">
                <label for="customer_email">Email</label>
                <input id="customer_email" type="email" name="customer_email" value="{{ old('customer_email', auth()->user()->email) }}">
            </div>
        </div>
        <div class="form-group">
            <label for="shipping_address">Delivery address *</label>
            <textarea id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea>
        </div>
        <div class="form-group">
            <label for="notes">Delivery notes (optional)</label>
            <textarea id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
        </div>
        <div class="form-group">
            <label>Payment method</label>
            <select name="payment_method" required>
                <option value="cod" selected>Cash on Delivery (COD)</option>
            </select>
            <p class="muted mt-1">Online payment gateway is not integrated yet.</p>
        </div>
        <button class="btn btn-block" type="submit">Place order</button>
    </form>
    <div class="card">
        <h3 style="margin-top:0;color:var(--green)">Order summary</h3>
        @php $sum = 0; @endphp
        @foreach($cart as $item)
            @php $line = $item['price'] * $item['quantity']; $sum += $line; @endphp
            <div class="flex" style="justify-content:space-between;margin-bottom:8px">
                <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                <span>৳{{ number_format($line, 2) }}</span>
            </div>
        @endforeach
        <hr style="border:none;border-top:1px solid var(--border);margin:12px 0">
        <div class="flex" style="justify-content:space-between"><span>Subtotal</span><span>৳{{ number_format($sum, 2) }}</span></div>
        <div class="flex" style="justify-content:space-between"><span>Delivery</span><span>৳50.00</span></div>
        <div class="flex mt-1" style="justify-content:space-between"><strong>Total</strong><strong class="price">৳{{ number_format($sum + 50, 2) }}</strong></div>
    </div>
</div>
@endsection
