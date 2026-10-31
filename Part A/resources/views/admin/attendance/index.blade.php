@extends('layouts.admin')
@section('title','Attendance')
@section('content')
<div class="detail-grid">
<form method="POST" action="{{ route('admin.attendance.store') }}" class="card">@csrf
    <h3 style="margin-top:0">Mark attendance</h3>
    <div class="form-group"><label>Employee</label>
        <select name="employee_id" required>
            @foreach($employees as $e)<option value="{{ $e->id }}">{{ $e->employee_id }} — {{ $e->name }}</option>@endforeach
        </select>
    </div>
    <div class="form-group"><label>Date</label><input type="date" name="date" value="{{ date('Y-m-d') }}" required></div>
    <div class="form-group"><label>Status</label>
        <select name="status">
            @foreach(['present','absent','late','leave'] as $st)<option value="{{ $st }}">{{ $st }}</option>@endforeach
        </select>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Check-in</label><input type="time" name="check_in"></div>
        <div class="form-group"><label>Check-out</label><input type="time" name="check_out"></div>
    </div>
    <div class="form-group"><label>Note</label><input name="note"></div>
    <button class="btn" type="submit">Save</button>
</form>
<div class="card table-wrap" style="padding:0">
<table>
<thead><tr><th>Date</th><th>Employee</th><th>Status</th><th>In/Out</th></tr></thead>
<tbody>
@forelse($records as $r)
<tr>
    <td>{{ $r->date?->format('d M Y') }}</td>
    <td>{{ $r->employee->name ?? '—' }}</td>
    <td><span class="badge">{{ $r->status }}</span></td>
    <td class="muted">{{ $r->check_in }} — {{ $r->check_out }}</td>
</tr>
@empty
<tr><td colspan="4" class="muted">No attendance records.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
