@extends('layouts.app')
@section('title', 'My Orders — Khati Dairy')
@section('content')
<div class="section-head"><div><h2>My Orders</h2></div></div>
@if($orders->isEmpty())
    <div class="empty-state"><p>No orders yet.</p><a class="btn" href="{{ route('products.index') }}">Start shopping</a></div>
@else
<div class="table-wrap card" style="padding:0">
<table>
<thead><tr><th>Order #</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
<tbody>
@foreach($orders as $o)
<tr>
    <td>{{ $o->order_number }}</td>
    <td class="price">৳{{ number_format($o->total, 2) }}</td>
    <td><span class="badge">{{ $o->status }}</span></td>
    <td class="muted">{{ $o->created_at?->format('d M Y') }}</td>
    <td><a href="{{ route('orders.show', $o) }}">Details</a></td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endif
@endsection
