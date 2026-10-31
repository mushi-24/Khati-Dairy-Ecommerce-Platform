@extends('layouts.app')
@section('title', 'Khati Dairy — Pure Taste. Fresh Every Day.')
@section('content')

<section class="hero">
    <div class="hero-bg" style="background-image:url('{{ asset('images/products/hero-farm.jpg') }}')"></div>
    <div class="hero-content">
        <span class="hero-pill">100% Pure · Grass-Fed · Farm Fresh</span>
        <h1>Fresh Dairy.<br>Delivered to Your Door.</h1>
        <p>Discover fresh milk, creamy yogurt, premium cheese, pure ghee, butter, and delicious dairy products from trusted dairy farms and local shops.</p>
        <div class="hero-actions">
            <a class="btn btn-gold" href="{{ route('products.index') }}">Shop Now →</a>
            <a class="btn btn-outline" style="border-color:#fff;color:#fff!important" href="{{ route('products.index') }}">Explore Products</a>
        </div>
    </div>
</section>

@if(isset($categories) && $categories->isNotEmpty())
<section class="section">
    <div class="section-head">
        <div>
            <h2>Popular Categories</h2>
            <p class="sub">Browse by dairy type</p>
        </div>
        <a href="{{ route('products.index') }}">View all →</a>
    </div>
    <div class="grid">
        @foreach($categories as $c)
            <a class="card" href="{{ route('products.index', ['category' => $c->id]) }}" style="text-align:center;padding:24px 16px">
                <div style="font-size:2rem;margin-bottom:8px">🥛</div>
                <strong style="color:var(--green)">{{ $c->name }}</strong>
                <div class="muted mt-1">{{ \Illuminate\Support\Str::limit($c->description ?? 'Dairy products', 50) }}</div>
            </a>
        @endforeach
    </div>
</section>
@endif

<section class="section">
    <div class="section-head">
        <div>
            <h2>Featured Products</h2>
            <p class="sub">Fresh picks from our catalog</p>
        </div>
        <a href="{{ route('products.index') }}">View all →</a>
    </div>
    @if($products->isEmpty())
        <div class="empty-state">
            <p>No products yet. After admin login, add categories, shops, and products — or run the demo seeder.</p>
            <a class="btn" href="{{ route('login') }}">Admin login</a>
        </div>
    @else
        <div class="grid">
            @foreach($products as $p)
                @include('shop.partials.product-card', ['p' => $p])
            @endforeach
        </div>
    @endif
</section>

@if(isset($shops) && $shops->isNotEmpty())
<section class="section">
    <div class="section-head">
        <div>
            <h2>Trusted Dairy Shops</h2>
            <p class="sub">Multi-vendor sellers on one platform</p>
        </div>
    </div>
    <div class="grid">
        @foreach($shops as $s)
            <div class="card">
                <strong style="color:var(--green)">{{ $s->name }}</strong>
                <div class="muted mt-1">{{ \Illuminate\Support\Str::limit($s->description ?? '', 90) }}</div>
                <span class="badge mt-2">{{ $s->city ?? 'Bangladesh' }}</span>
            </div>
        @endforeach
    </div>
</section>
@endif

<section class="section">
    <div class="section-head">
        <div>
            <h2>Why Choose Khati Dairy?</h2>
            <p class="sub">Built for convenient dairy shopping and farm operations</p>
        </div>
    </div>
    <div class="feature-grid">
        <div class="feature-card">
            <div class="icon">🌿</div>
            <h3>Farm Fresh</h3>
            <p>Dairy products sourced with production tracking from farm to shop.</p>
        </div>
        <div class="feature-card">
            <div class="icon">🛒</div>
            <h3>Easy Ordering</h3>
            <p>Browse, add to cart, and place COD orders from your phone or desktop.</p>
        </div>
        <div class="feature-card">
            <div class="icon">🏪</div>
            <h3>Multi-Shop</h3>
            <p>Buy from multiple participating dairy shops on one platform.</p>
        </div>
        <div class="feature-card">
            <div class="icon">📦</div>
            <h3>Order Tracking</h3>
            <p>Follow order status from pending to delivered.</p>
        </div>
    </div>
</section>

<section class="card" style="background:linear-gradient(135deg,var(--green),var(--green-2));color:#fff;text-align:center;padding:36px 24px">
    <h2 style="margin:0 0 8px;color:#fff">Start your morning with pure dairy</h2>
    <p style="opacity:.9;margin:0 0 16px">Create an account and order fresh products with Cash on Delivery.</p>
    <a class="btn btn-gold" href="{{ route('register') }}">Create free account</a>
</section>

@endsection
