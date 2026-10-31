<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Khati Dairy — Pure Taste. Fresh Every Day. Online dairy products from trusted farms and shops in Bangladesh.">
    <title>@yield('title', 'Khati Dairy')</title>
    <link rel="stylesheet" href="{{ asset('css/khati.css') }}">
    @stack('head')
</head>
<body>
@php
    $cartCount = collect(session('cart', []))->sum('quantity');
@endphp

<div class="topbar">
    <div class="wrap">
        <span>🥛 Express chilled dairy · Cash on Delivery available</span>
        <span>Helpline: +880 1711-234567</span>
    </div>
</div>

<header class="site-header">
    <div class="wrap header-row">
        <a class="logo" href="{{ route('home') }}">
            <span class="logo-mark">KD</span>
            <span>
                Khati Dairy
                <span>Pure Taste. Fresh Every Day.</span>
            </span>
        </a>

        <nav class="nav-main" aria-label="Main">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
            <a href="{{ route('products.index', ['category' => '']) }}">Categories</a>
            <a href="{{ route('pages.about') }}">About</a>
            <a href="{{ route('pages.contact') }}">Contact</a>
        </nav>

        <div class="nav-actions">
            <a class="icon-btn hide-mobile" href="{{ route('products.index') }}" title="Search">🔍</a>
            <a class="icon-btn" href="{{ route('cart.index') }}" title="Cart">
                🛒 <span class="hide-mobile">Cart</span>
                @if($cartCount > 0)<span class="badge-count">{{ $cartCount }}</span>@endif
            </a>
            @auth
                <a class="icon-btn hide-mobile" href="{{ route('profile.edit') }}">Account</a>
                <a class="icon-btn hide-mobile" href="{{ route('orders.index') }}">Orders</a>
                @if(auth()->user()->canAccessAdminPanel())
                    <a class="btn btn-sm hide-mobile" href="{{ route('admin.dashboard') }}">Admin</a>
                @endif
                @if(in_array(auth()->user()->role, ['employee','admin','manager']))
                    <a class="icon-btn hide-mobile" href="{{ route('employee.profile') }}">My Profile</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display:inline">@csrf
                    <button type="submit" class="icon-btn">Logout</button>
                </form>
            @else
                <a class="btn btn-sm hide-mobile" href="{{ route('login') }}">Login</a>
                <a class="btn btn-sm btn-outline hide-mobile" href="{{ route('register') }}">Sign up</a>
            @endauth
            <button type="button" class="menu-toggle" id="menuToggle" aria-label="Open menu">☰</button>
        </div>
    </div>
    <div class="wrap mobile-nav" id="mobileNav">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('products.index') }}">Products</a>
        <a href="{{ route('pages.about') }}">About</a>
        <a href="{{ route('pages.contact') }}">Contact</a>
        <a href="{{ route('cart.index') }}">Cart ({{ $cartCount }})</a>
        @auth
            <a href="{{ route('profile.edit') }}">Edit account</a>
            <a href="{{ route('orders.index') }}">My Orders</a>
            @if(auth()->user()->canAccessAdminPanel())
                <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
            @endif
            @if(in_array(auth()->user()->role, ['employee','admin','manager']))
                <a href="{{ route('employee.profile') }}">Employee Profile</a>
            @endif
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Sign up</a>
        @endauth
    </div>
</header>

<main class="wrap page">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if(isset($errors) && $errors->any())
        <div class="alert alert-error">
            <ul style="margin:0;padding-left:18px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif
    @yield('content')
</main>

<footer class="site-footer">
    <div class="wrap">
        <div class="footer-grid">
            <div>
                <h4>Khati Dairy</h4>
                <p style="font-size:13px;opacity:.85;margin:0 0 8px">Pure Taste. Fresh Every Day.</p>
                <p style="font-size:13px;opacity:.75;margin:0">Online dairy shopping with farm production, multi-shop sellers, and order tracking.</p>
            </div>
            <div>
                <h4>Shop</h4>
                <a href="{{ route('products.index') }}">All products</a>
                <a href="{{ route('cart.index') }}">Cart</a>
                <a href="{{ route('register') }}">Create account</a>
            </div>
            <div>
                <h4>Company</h4>
                <a href="{{ route('pages.about') }}">About us</a>
                <a href="{{ route('pages.contact') }}">Contact</a>
                <a href="{{ route('pages.faq') }}">FAQ</a>
            </div>
            <div>
                <h4>Legal</h4>
                <a href="{{ route('pages.privacy') }}">Privacy Policy</a>
                <a href="{{ route('pages.terms') }}">Terms & Conditions</a>
            </div>
        </div>
        <div class="footer-bottom">
            © {{ date('Y') }} Khati Dairy · BAUST CSE 3200 · Prices in Bangladeshi Taka (৳)
        </div>
    </div>
</footer>

<script>
document.getElementById('menuToggle')?.addEventListener('click', function () {
    document.getElementById('mobileNav').classList.toggle('open');
});
</script>
@stack('scripts')
</body>
</html>
