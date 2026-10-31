@extends('layouts.admin')
@section('title','Users & Roles')
@section('content')
<div class="detail-grid">
<form method="POST" action="{{ route('admin.users.store') }}" class="card">@csrf
    <h3 style="margin-top:0">Create user</h3>
    <div class="form-group"><label>Name</label><input name="name" required></div>
    <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
    <div class="form-group"><label>Password</label><input type="password" name="password" required minlength="6"></div>
    <div class="form-group"><label>Role</label>
        <select name="role">
            @foreach(['customer','admin','manager','employee','shop_owner'] as $r)
                <option value="{{ $r }}">{{ $r }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group"><label>Phone</label><input name="phone"></div>
    <div class="form-group"><label>Shop ID (optional)</label><input type="number" name="shop_id"></div>
    <label style="display:flex;gap:8px;align-items:center;font-weight:500"><input type="checkbox" name="is_active" value="1" checked style="width:auto"> Active</label>
    <button class="btn mt-2" type="submit">Create</button>
</form>
<div class="card table-wrap" style="padding:0">
<table>
<thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Active</th></tr></thead>
<tbody>
@foreach($users as $u)
<tr>
    <td>{{ $u->name }}</td>
    <td class="muted">{{ $u->email }}</td>
    <td><span class="badge">{{ $u->role }}</span></td>
    <td>{{ $u->is_active ? 'Yes' : 'No' }}</td>
</tr>
@endforeach
</tbody>
</table>
<div style="padding:12px">{{ $users->links() }}</div>
</div>
</div>
@endsection
