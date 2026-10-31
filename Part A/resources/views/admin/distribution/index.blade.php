@extends('layouts.admin')
@section('title','Distribution')
@section('content')
<div class="detail-grid">
<form method="POST" action="{{ route('admin.distribution.store') }}" class="card">@csrf
    <h3 style="margin-top:0">Transfer to shop</h3>
    <div class="form-group"><label>Product name</label><input name="product_name" required></div>
    <div class="form-group"><label>Shop</label>
        <select name="shop_id" required>
            @foreach($shops as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach
        </select>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Quantity</label><input type="number" step="0.01" name="quantity" required></div>
        <div class="form-group"><label>Unit</label><input name="unit" value="Liters" required></div>
    </div>
    <div class="form-group"><label>Date</label><input type="date" name="distribution_date" value="{{ date('Y-m-d') }}" required></div>
    <div class="form-group"><label>Remaining farm stock</label><input type="number" step="0.01" name="remaining_farm_stock"></div>
    <div class="form-group"><label>Notes</label><textarea name="notes" rows="2"></textarea></div>
    <button class="btn" type="submit">Record transfer</button>
</form>
<div class="card table-wrap" style="padding:0">
<table>
<thead><tr><th>Date</th><th>Product</th><th>Shop</th><th>Qty</th></tr></thead>
<tbody>
@forelse($records as $r)
<tr>
    <td>{{ $r->distribution_date?->format('d M Y') }}</td>
    <td>{{ $r->product_name }}</td>
    <td>{{ $r->shop->name ?? '—' }}</td>
    <td>{{ $r->quantity }} {{ $r->unit }}</td>
</tr>
@empty
<tr><td colspan="4" class="muted">No distributions.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
