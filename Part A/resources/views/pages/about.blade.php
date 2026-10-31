@extends('layouts.app')
@section('title', 'About Us — Khati Dairy')
@section('content')
<div class="card" style="max-width:720px;margin:0 auto;padding:28px">
    <h1 style="color:var(--green);margin-top:0">About Khati Dairy</h1>
    <p><strong>Pure Taste. Fresh Every Day.</strong></p>
    <p>Khati Dairy Online Dairy E-Commerce System connects customers with farm-fresh dairy products while helping administrators manage production, inventory, multi-shop sellers, employees, and orders from one platform.</p>
    <p>Customers can browse milk, yogurt, cheese, butter, ghee, cream, paneer, and dairy sweets, place Cash on Delivery orders, and track status. Farms and shops use the admin tools for production, distribution, and stock control.</p>
    <a class="btn mt-2" href="{{ route('products.index') }}">Shop products</a>
</div>
@endsection
