@extends('layouts.admin')
@section('title','Orders')
@section('content')
<div class="table-wrap card" style="padding:0">
<table>
<thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
<tbody>
@forelse($orders as $o)
<tr>
    <td>{{ $o->order_number }}</td>
    <td>{{ $o->customer_name }}<div class="muted">{{ $o->customer_phone }}</div></td>
    <td class="price">৳{{ number_format($o->total,2) }}</td>
    <td><span class="badge">{{ $o->status }}</span></td>
    <td class="muted">{{ $o->created_at?->format('d M Y H:i') }}</td>
    <td><a href="{{ route('admin.orders.show', $o) }}">Manage</a></td>
</tr>
@empty
<tr><td colspan="6" class="muted">No orders.</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="mt-2">{{ $orders->links() }}</div>
@endsection
