@extends('layouts.admin')
@section('title','Shops')
@section('content')
<div class="detail-grid">
<form method="POST" action="{{ route('admin.shops.store') }}" class="card">@csrf
    <h3 style="margin-top:0">Add shop</h3>
    <div class="form-group"><label>Name</label><input name="name" required></div>
    <div class="form-group"><label>City</label><input name="city"></div>
    <div class="form-group"><label>Phone</label><input name="phone"></div>
    <div class="form-group"><label>Description</label><textarea name="description" rows="2"></textarea></div>
    <div class="form-group"><label>Status</label>
        <select name="status"><option value="active">active</option><option value="pending">pending</option><option value="suspended">suspended</option></select>
    </div>
    <button class="btn" type="submit">Create shop</button>
</form>
<div class="card table-wrap" style="padding:0">
<table>
<thead><tr><th>Name</th><th>City</th><th>Status</th></tr></thead>
<tbody>
@foreach($shops as $s)
<tr><td>{{ $s->name }}</td><td>{{ $s->city }}</td><td><span class="badge">{{ $s->status }}</span></td></tr>
@endforeach
</tbody>
</table>
</div>
</div>
@endsection
