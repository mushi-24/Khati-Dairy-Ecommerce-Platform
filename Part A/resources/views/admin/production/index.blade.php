@extends('layouts.admin')
@section('title','Production')
@section('content')
<div class="detail-grid">
<form method="POST" action="{{ route('admin.production.store') }}" class="card">@csrf
    <h3 style="margin-top:0">Record production</h3>
    <div class="form-group"><label>Product name</label><input name="product_name" required placeholder="Milk"></div>
    <div class="form-row">
        <div class="form-group"><label>Quantity</label><input type="number" step="0.01" name="quantity" required></div>
        <div class="form-group"><label>Unit</label><input name="unit" value="Liters" required></div>
    </div>
    <div class="form-group"><label>Date</label><input type="date" name="production_date" value="{{ date('Y-m-d') }}" required></div>
    <div class="form-group"><label>Batch / notes</label><input name="batch_reference"><textarea name="notes" rows="2" class="mt-1"></textarea></div>
    <button class="btn" type="submit">Save record</button>
</form>
<div class="card table-wrap" style="padding:0">
<table>
<thead><tr><th>Date</th><th>Product</th><th>Qty</th><th>Batch</th><th></th></tr></thead>
<tbody>
@forelse($records as $r)
<tr>
    <td>{{ $r->production_date?->format('d M Y') }}</td>
    <td>{{ $r->product_name }}</td>
    <td>{{ $r->quantity }} {{ $r->unit }}</td>
    <td class="muted">{{ $r->batch_reference }}</td>
    <td>
        <form method="POST" action="{{ route('admin.production.destroy', $r) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
            <button class="btn btn-sm btn-outline" type="submit">Delete</button>
        </form>
    </td>
</tr>
@empty
<tr><td colspan="5" class="muted">No production records.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
