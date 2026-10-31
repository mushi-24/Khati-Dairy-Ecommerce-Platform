@extends('layouts.app')
@section('title', 'Order ' . $order->order_number)
@section('content')
<div class="card" style="max-width:640px">
    <h2 style="margin-top:0;color:var(--green)">Order {{ $order->order_number }}</h2>
    <p><span class="badge">{{ $order->status }}</span></p>
    <p class="muted">{{ $order->customer_name }} · {{ $order->customer_phone }}</p>
    <p>{{ $order->shipping_address }}</p>
    <hr style="border:none;border-top:1px solid var(--border);margin:16px 0">
    @foreach($order->items as $item)
        <div class="flex" style="justify-content:space-between;margin-bottom:8px">
            <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
            <span>৳{{ number_format($item->line_total, 2) }}</span>
        </div>
    @endforeach
    <div class="flex mt-2" style="justify-content:space-between"><strong>Total</strong><strong class="price">৳{{ number_format($order->total, 2) }}</strong></div>
    <div class="flex mt-2">
        <a class="btn" href="{{ route('orders.payslip', $order) }}">Payslip / Print</a>
        <a class="btn btn-outline" href="{{ route('orders.payslip', [$order, 'print' => 1]) }}">Print now</a>
        <a class="btn btn-outline" href="{{ route('orders.index') }}">My orders</a>
    </div>
</div>
@endsection
