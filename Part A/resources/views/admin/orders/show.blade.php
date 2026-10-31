@extends('layouts.admin')
@section('title','Order '.$order->order_number)
@section('content')
<div class="detail-grid">
<div class="card">
    <h3 style="margin-top:0">{{ $order->order_number }}</h3>
    <p><span class="badge">{{ $order->status }}</span></p>
    <p>{{ $order->customer_name }} · {{ $order->customer_phone }}</p>
    <p class="muted">{{ $order->customer_email }}</p>
    <p>{{ $order->shipping_address }}</p>
    <p class="muted">Payment: {{ strtoupper($order->payment_method) }}</p>
    <hr style="border:none;border-top:1px solid var(--border);margin:12px 0">
    @foreach($order->items as $item)
    <div class="flex" style="justify-content:space-between"><span>{{ $item->product_name }} × {{ $item->quantity }}</span><span>৳{{ number_format($item->line_total,2) }}</span></div>
    @endforeach
    <div class="flex mt-2" style="justify-content:space-between"><strong>Total</strong><strong class="price">৳{{ number_format($order->total,2) }}</strong></div>
</div>
<form method="POST" action="{{ route('admin.orders.status', $order) }}" class="card">@csrf @method('PATCH')
    <h3 style="margin-top:0">Update status</h3>
    <div class="form-group">
        <label>Status</label>
        <select name="status">
            @foreach(\App\Models\Order::statuses() as $key => $label)
                <option value="{{ $key }}" @selected($order->status==$key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn" type="submit">Save status</button>
</form>
</div>
@endsection
