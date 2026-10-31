<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payslip {{ $order->order_number }} — Khati Dairy</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 720px; margin: 24px auto; padding: 0 16px; color: #1a1a1a; }
        h1 { color: #1B4332; margin-bottom: 4px; }
        .muted { color: #5C6B66; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin: 16px 0; }
        th, td { text-align: left; padding: 10px 8px; border-bottom: 1px solid #E4EBE6; font-size: 14px; }
        th { font-size: 12px; text-transform: uppercase; color: #5C6B66; }
        .total { font-size: 1.2rem; font-weight: 800; color: #1B4332; }
        .actions { display: flex; gap: 10px; margin: 20px 0; flex-wrap: wrap; }
        .btn { background: #1B4332; color: #fff; border: none; padding: 10px 16px; border-radius: 10px; cursor: pointer; font-weight: 700; text-decoration: none; display: inline-block; }
        .btn-outline { background: #fff; color: #1B4332; border: 1.5px solid #1B4332; }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print actions">
        <button class="btn" type="button" onclick="window.print()">🖨 Print / Save as PDF</button>
        <a class="btn btn-outline" href="{{ route('orders.show', $order) }}">← Back to order</a>
    </div>

    <h1>Khati Dairy</h1>
    <p class="muted">Pure Taste. Fresh Every Day. · Order Payslip / Invoice</p>
    <hr>

    <p><strong>Order:</strong> {{ $order->order_number }}</p>
    <p><strong>Date:</strong> {{ $order->created_at?->format('d M Y, h:i A') }}</p>
    <p><strong>Status:</strong> {{ strtoupper($order->status) }}</p>
    <p><strong>Payment:</strong> {{ strtoupper($order->payment_method) }} (Cash on Delivery)</p>

    <h3>Customer</h3>
    <p>{{ $order->customer_name }}<br>
       {{ $order->customer_phone }}<br>
       {{ $order->customer_email }}<br>
       {{ $order->shipping_address }}</p>

    <h3>Items</h3>
    <table>
        <thead>
            <tr><th>Product</th><th>Qty</th><th>Price</th><th>Line total</th></tr>
        </thead>
        <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>৳{{ number_format($item->price, 2) }}</td>
                <td>৳{{ number_format($item->line_total, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p>Subtotal: ৳{{ number_format($order->subtotal, 2) }}</p>
    <p>Delivery: ৳{{ number_format($order->delivery_fee, 2) }}</p>
    <p class="total">Total payable: ৳{{ number_format($order->total, 2) }}</p>

    @if($order->notes)
        <p class="muted">Notes: {{ $order->notes }}</p>
    @endif

    <p class="muted" style="margin-top:32px">Thank you for ordering from Khati Dairy.</p>

    <div class="no-print actions">
        <button class="btn" type="button" onclick="window.print()">🖨 Print / Save as PDF</button>
    </div>
    <script>
        // Optional: auto-open print dialog when ?print=1
        if (new URLSearchParams(location.search).get('print') === '1') {
            window.addEventListener('load', () => setTimeout(() => window.print(), 300));
        }
    </script>
</body>
</html>
