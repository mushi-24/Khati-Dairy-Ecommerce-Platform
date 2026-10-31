@extends('layouts.admin')
@section('title','Inventory')
@section('content')
<div class="detail-grid">
<form method="POST" action="{{ route('admin.inventory.store') }}" class="card">@csrf
    <h3 style="margin-top:0">Add / update stock row</h3>
    <div class="form-group"><label>Location</label>
        <select name="location_type"><option value="farm">farm</option><option value="shop">shop</option><option value="online">online</option></select>
    </div>
    <div class="form-group"><label>Product name</label><input name="product_name" required></div>
    <div class="form-group"><label>Shop (if shop location)</label>
        <select name="shop_id"><option value="">—</option>@foreach($shops ?? [] as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach</select>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Quantity</label><input type="number" step="0.01" name="quantity" required></div>
        <div class="form-group"><label>Unit</label><input name="unit" value="Liters" required></div>
    </div>
    <div class="form-group"><label>Low threshold</label><input type="number" step="0.01" name="low_threshold" value="10"></div>
    <button class="btn" type="submit">Save</button>
</form>
<div class="card table-wrap" style="padding:0">
<table>
<thead><tr><th>Location</th><th>Product</th><th>Qty</th><th>Low?</th></tr></thead>
<tbody>
@forelse($items as $i)
<tr>
    <td>{{ $i->location_type }} {{ $i->shop->name ?? '' }}</td>
    <td>{{ $i->product_name }}</td>
    <td>{{ $i->quantity }} {{ $i->unit }}</td>
    <td>@if($i->isLowStock())<span class="badge" style="background:#FEE2E2;color:#991B1B">Low</span>@else OK @endif</td>
</tr>
@empty
<tr><td colspan="4" class="muted">No inventory rows.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
