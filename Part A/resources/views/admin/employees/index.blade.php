@extends('layouts.admin')
@section('title','Employees')
@section('content')
<div class="detail-grid">
<form method="POST" action="{{ route('admin.employees.store') }}" class="card">@csrf
    <h3 style="margin-top:0">Add employee + login</h3>
    <div class="form-group"><label>Employee ID *</label><input name="employee_id" required placeholder="KD-EMP-001"></div>
    <div class="form-group"><label>Full name *</label><input name="name" required></div>
    <div class="form-row">
        <div class="form-group"><label>Phone</label><input name="phone"></div>
        <div class="form-group"><label>Email (HR record)</label><input type="email" name="email"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Position</label><input name="position" placeholder="Farm worker"></div>
        <div class="form-group"><label>Department</label><input name="department" placeholder="Production"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Joining date</label><input type="date" name="joining_date"></div>
        <div class="form-group"><label>Basic salary (৳) *</label><input type="number" step="0.01" name="salary" value="15000" required></div>
    </div>
    <div class="form-group"><label>Status</label>
        <select name="status"><option value="active">active</option><option value="inactive">inactive</option><option value="on_leave">on_leave</option></select>
    </div>
    <div class="form-group"><label>Address</label><textarea name="address" rows="2"></textarea></div>

    <hr style="border:none;border-top:1px solid var(--border);margin:16px 0">
    <label style="display:flex;gap:8px;align-items:center;font-weight:700;margin-bottom:12px">
        <input type="checkbox" name="create_login" value="1" checked style="width:auto"> Create login account (employee can open profile)
    </label>
    <div class="form-group"><label>Login email *</label><input type="email" name="login_email" placeholder="employee@khatidairy.com"></div>
    <div class="form-group"><label>Login password *</label><input type="password" name="login_password" minlength="6" placeholder="min 6 characters"></div>
    <p class="muted">Employee will login at /login with this email & password, then open My Profile.</p>

    <button class="btn" type="submit">Save employee</button>
</form>

<div class="card table-wrap" style="padding:0">
<table>
<thead><tr><th>ID</th><th>Name</th><th>Position</th><th>Salary</th><th>Login</th><th>Status</th><th></th></tr></thead>
<tbody>
@forelse($employees as $e)
<tr>
    <td>{{ $e->employee_id }}</td>
    <td>{{ $e->name }}</td>
    <td>{{ $e->position }}</td>
    <td>৳{{ number_format($e->salary,0) }}</td>
    <td class="muted">{{ $e->user->email ?? 'No login' }}</td>
    <td>{{ $e->status }}</td>
    <td>
        <form method="POST" action="{{ route('admin.employees.destroy', $e) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
            <button class="btn btn-sm btn-outline" type="submit">Delete</button>
        </form>
    </td>
</tr>
@empty
<tr><td colspan="7" class="muted">No employees yet.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
