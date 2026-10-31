@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="stat-grid mb-2">
@foreach($stats as $k => $v)
    <div class="stat-card">
        <div class="label">{{ str_replace('_', ' ', $k) }}</div>
        <div class="value">{{ is_numeric($v) && $k === 'sales' ? '৳'.number_format($v, 0) : $v }}</div>
    </div>
@endforeach
</div>
<div class="card">
    <h3 style="margin-top:0;color:var(--green)">Recent orders</h3>
    <div class="table-wrap">
    <table>
        <thead><tr><th>#</th><th>Customer</th><th>Total</th><th>Status</th><th></th></tr></thead>
        <tbody>
        @forelse($recentOrders as $o)
            <tr>
                <td>{{ $o->order_number }}</td>
                <td>{{ $o->customer_name }}</td>
                <td class="price">৳{{ number_format($o->total, 2) }}</td>
                <td><span class="badge">{{ $o->status }}</span></td>
                <td><a href="{{ route('admin.orders.show', $o) }}">View</a></td>
            </tr>
        @empty
            <tr><td colspan="5" class="muted">No orders yet.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
@endsection
