@extends('layouts.app')
@section('title', 'Employee Profile')
@section('content')
<div class="section-head">
    <div>
        <h2>Employee Profile</h2>
        <p class="sub">{{ $user->name }} · {{ $user->email }} · role: {{ $user->role }}</p>
    </div>
</div>

@if(!$employee)
    <div class="alert alert-error">
        No employee HR record is linked to this account. Ask admin to create an Employee with <strong>Create login</strong> using this email, or link user_id.
    </div>
@else
<div class="detail-grid">
    <div class="card">
        <h3 style="margin-top:0;color:var(--green)">Personal & job info</h3>
        <table>
            <tr><th>Employee ID</th><td>{{ $employee->employee_id }}</td></tr>
            <tr><th>Name</th><td>{{ $employee->name }}</td></tr>
            <tr><th>Phone</th><td>{{ $employee->phone ?? '—' }}</td></tr>
            <tr><th>Email</th><td>{{ $employee->email ?? '—' }}</td></tr>
            <tr><th>Position</th><td>{{ $employee->position ?? '—' }}</td></tr>
            <tr><th>Department</th><td>{{ $employee->department ?? '—' }}</td></tr>
            <tr><th>Joining date</th><td>{{ $employee->joining_date?->format('d M Y') ?? '—' }}</td></tr>
            <tr><th>Basic salary</th><td class="price">৳{{ number_format($employee->salary, 2) }}</td></tr>
            <tr><th>Status</th><td><span class="badge">{{ $employee->status }}</span></td></tr>
            <tr><th>Address</th><td>{{ $employee->address ?? '—' }}</td></tr>
        </table>
    </div>
    <div>
        <div class="card mb-2">
            <h3 style="margin-top:0;color:var(--green)">Recent attendance</h3>
            <div class="table-wrap">
            <table>
                <thead><tr><th>Date</th><th>Status</th><th>In–Out</th></tr></thead>
                <tbody>
                @forelse($employee->attendances as $a)
                    <tr>
                        <td>{{ $a->date?->format('d M Y') }}</td>
                        <td>{{ $a->status }}</td>
                        <td class="muted">{{ $a->check_in }} – {{ $a->check_out }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="muted">No attendance yet.</td></tr>
                @endforelse
                </tbody>
            </table>
            </div>
        </div>
        <div class="card">
            <h3 style="margin-top:0;color:var(--green)">Salary history</h3>
            <div class="table-wrap">
            <table>
                <thead><tr><th>Month</th><th>Net</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($employee->salaries as $s)
                    <tr>
                        <td>{{ $s->month }}</td>
                        <td class="price">৳{{ number_format($s->net_salary, 2) }}</td>
                        <td>{{ $s->payment_status }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="muted">No salary records yet.</td></tr>
                @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
