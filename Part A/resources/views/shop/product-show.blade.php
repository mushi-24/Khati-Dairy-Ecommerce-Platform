@extends('layouts.app')
@section('title', $product->name . ' — Khati Dairy')
@section('content')
<div class="detail-grid">
    <div class="detail-image">
        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" onerror="this.onerror=null;this.src='{{ asset('images/products/milk.jpg') }}'">
    </div>
    <div>
        <div class="meta muted">{{ $product->category->name ?? 'Dairy' }}
            @if($product->shop) · <a href="{{ route('products.index', ['shop' => $product->shop_id]) }}">{{ $product->shop->name }}</a>@endif
        </div>
        <h1 style="margin:8px 0 12px;color:var(--green);font-size:1.75rem">{{ $product->name }}</h1>
        <div class="price" style="font-size:1.5rem;margin-bottom:12px">৳{{ number_format($product->price, 2) }}</div>
        <p class="muted">{{ $product->unit }} ·
            @if($product->stock > 0)
                <span class="badge">In stock ({{ $product->stock }})</span>
            @else
                <span class="badge" style="background:#FEE2E2;color:#991B1B">Out of stock</span>
            @endif
        </p>
        <p style="margin:16px 0">{{ $product->description ?? 'Farm fresh dairy product from Khati Dairy network.' }}</p>

        @if($product->stock > 0)
        <form method="POST" action="{{ route('cart.add', $product) }}" class="flex" style="align-items:end">
            @csrf
            <div class="form-group" style="margin:0;max-width:100px">
                <label for="qty">Qty</label>
                <input id="qty" type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}">
            </div>
            <button class="btn" type="submit">Add to cart</button>
            <a class="btn btn-outline" href="{{ route('cart.index') }}">View cart</a>
        </form>
        @else
            <p class="alert alert-info">This product is currently unavailable.</p>
        @endif
    </div>
</div>
@endsection
