@extends('layouts.app')
@section('title', 'Products — Khati Dairy')
@section('content')
<div class="section-head">
    <div>
        <h2>All Products</h2>
        <p class="sub">Search and filter fresh dairy items · Prices in ৳</p>
    </div>
</div>

<form class="filter-bar" method="GET" action="{{ route('products.index') }}">
    <div class="form-group">
        <label for="search">Search</label>
        <input id="search" type="search" name="search" value="{{ request('search') }}" placeholder="Milk, ghee, yogurt…">
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select id="category" name="category">
            <option value="">All categories</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(request('category')==$c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="shop">Shop</label>
        <select id="shop" name="shop">
            <option value="">All shops</option>
            @foreach($shops as $s)
                <option value="{{ $s->id }}" @selected(request('shop')==$s->id)>{{ $s->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="sort">Sort</label>
        <select id="sort" name="sort">
            <option value="newest" @selected(request('sort')=='newest')>Newest</option>
            <option value="price_asc" @selected(request('sort')=='price_asc')>Price: Low to High</option>
            <option value="price_desc" @selected(request('sort')=='price_desc')>Price: High to Low</option>
            <option value="name" @selected(request('sort')=='name')>Name A–Z</option>
        </select>
    </div>
    <button class="btn" type="submit">Apply</button>
</form>

@if($products->isEmpty())
    <div class="empty-state">
        <p>No products found. Try different filters or add products from the admin panel.</p>
        <a class="btn btn-outline" href="{{ route('products.index') }}">Clear filters</a>
    </div>
@else
    <div class="grid">
        @foreach($products as $p)
            @include('shop.partials.product-card', ['p' => $p])
        @endforeach
    </div>
    <div class="mt-2">{{ $products->links() }}</div>
@endif
@endsection
