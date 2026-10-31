@extends('layouts.admin')
@section('title','Sales & Reports')
@section('content')
<div class="stat-grid mb-2">
    <div class="stat-card"><div class="label">Revenue (excl. cancelled)</div><div class="value">৳{{ number_format($total,0) }}</div></div>
    <div class="stat-card"><div class="label">Orders</div><div class="value">{{ $count }}</div></div>
</div>
<div class="detail-grid">
<div class="card">
    <h3 style="margin-top:0">By status</h3>
    <table>
        <thead><tr><th>Status</th><th>Count</th><th>Total</th></tr></thead>
        <tbody>
        @foreach($byStatus as $row)
            <tr><td>{{ $row->status }}</td><td>{{ $row->c }}</td><td>৳{{ number_format($row->t ?? 0,0) }}</td></tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="card">
    <h3 style="margin-top:0">Daily (last 14)</h3>
    <table>
        <thead><tr><th>Date</th><th>Orders</th><th>Revenue</th></tr></thead>
        <tbody>
        @forelse($daily as $row)
            <tr><td>{{ $row->d }}</td><td>{{ $row->c }}</td><td>৳{{ number_format($row->t ?? 0,0) }}</td></tr>
        @empty
            <tr><td colspan="3" class="muted">No sales data yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
</div>
@endsection
