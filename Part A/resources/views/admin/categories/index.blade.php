@extends('layouts.admin')
@section('title','Categories')
@section('content')
<div class="detail-grid">
<form method="POST" action="{{ route('admin.categories.store') }}" class="card">@csrf
    <h3 style="margin-top:0">Add category</h3>
    <div class="form-group"><label>Name</label><input name="name" required></div>
    <div class="form-group"><label>Description</label><textarea name="description" rows="2"></textarea></div>
    <button class="btn" type="submit">Create</button>
</form>
<div class="card table-wrap" style="padding:0">
<table>
<thead><tr><th>Name</th><th>Slug</th><th>Active</th><th></th></tr></thead>
<tbody>
@foreach($categories as $c)
<tr>
    <td>{{ $c->name }}</td><td class="muted">{{ $c->slug }}</td>
    <td>{{ $c->is_active ? 'Yes' : 'No' }}</td>
    <td>
        <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
            <button class="btn btn-sm btn-outline" type="submit">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
@endsection
