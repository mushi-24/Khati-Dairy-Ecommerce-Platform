@extends('layouts.admin')
@section('title','Salaries')
@section('content')
<div class="detail-grid">
<form method="POST" action="{{ route('admin.salary.store') }}" class="card">@csrf
    <h3 style="margin-top:0">Record salary</h3>
    <div class="form-group"><label>Employee</label>
        <select name="employee_id" required>
            @foreach($employees as $e)<option value="{{ $e->id }}">{{ $e->name }} (৳{{ number_format($e->salary,0) }})</option>@endforeach
        </select>
    </div>
    <div class="form-group"><label>Month (YYYY-MM)</label><input name="month" value="{{ date('Y-m') }}" required></div>
    <div class="form-group"><label>Basic salary</label><input type="number" step="0.01" name="basic_salary" required></div>
    <div class="form-row">
        <div class="form-group"><label>Bonus</label><input type="number" step="0.01" name="bonus" value="0"></div>
        <div class="form-group"><label>Deduction</label><input type="number" step="0.01" name="deduction" value="0"></div>
    </div>
    <div class="form-group"><label>Net salary</label><input type="number" step="0.01" name="net_salary" required></div>
    <div class="form-group"><label>Payment status</label>
        <select name="payment_status"><option value="pending">pending</option><option value="paid">paid</option></select>
    </div>
    <button class="btn" type="submit">Save</button>
</form>
<div class="card table-wrap" style="padding:0">
<table>
<thead><tr><th>Month</th><th>Employee</th><th>Net</th><th>Status</th></tr></thead>
<tbody>
@forelse($salaries as $r)
<tr>
    <td>{{ $r->month }}</td>
    <td>{{ $r->employee->name ?? '—' }}</td>
    <td class="price">৳{{ number_format($r->net_salary,2) }}</td>
    <td>{{ $r->payment_status }}</td>
</tr>
@empty
<tr><td colspan="4" class="muted">No salary records.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
