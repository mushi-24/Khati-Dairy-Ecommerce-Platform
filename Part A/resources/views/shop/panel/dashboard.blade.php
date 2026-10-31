@extends('layouts.app')
@section('title', 'Shop Owner Panel')
@section('content')
<div class="section-head">
    <div>
        <h2>Shop Owner Dashboard</h2>
        <p class="sub">Manage your products and view related orders
            @if(!$shopId)<span class="badge" style="background:#FEE2E2;color:#991B1B">No shop_id on account — ask admin to assign</span>@endif
        </p>
    </div>
    <a class="btn btn-sm" href="{{ route('admin.products.create') }}">Add product (admin form)</a>
</div>
<div class="stat-grid mb-2" style="display:grid;gap:14px;grid-template-columns:repeat(auto-fill,minmax(140px,1fr))">
    <div class="card"><div class="muted">Products</div><div class="price" style="font-size:1.3rem">{{ $stats['products'] }}</div></div>
    <div class="card"><div class="muted">Orders</div><div class="price" style="font-size:1.3rem">{{ $stats['orders'] }}</div></div>
    <div class="card"><div class="muted">Sales</div><div class="price" style="font-size:1.3rem">৳{{ number_format($stats['sales'],0) }}</div></div>
</div>
<div class="detail-grid">
<div class="card table-wrap" style="padding:0">
    <h3 style="padding:16px 16px 0;margin:0;color:var(--green)">Your products</h3>
    <table>
        <thead><tr><th>Name</th><th>Stock</th><th>Price</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($products as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ $p->stock }}</td>
                <td>৳{{ number_format($p->price,2) }}</td>
                <td>{{ $p->status }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="muted">No products for this shop.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="padding:12px">{{ $products->links() }}</div>
</div>
<div class="card table-wrap" style="padding:0">
    <h3 style="padding:16px 16px 0;margin:0;color:var(--green)">Orders</h3>
    <table>
        <thead><tr><th>#</th><th>Customer</th><th>Total</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($orders as $o)
            <tr>
                <td>{{ $o->order_number }}</td>
                <td>{{ $o->customer_name }}</td>
                <td>৳{{ number_format($o->total,2) }}</td>
                <td>{{ $o->status }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="muted">No shop orders yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
</div>
@endsection
