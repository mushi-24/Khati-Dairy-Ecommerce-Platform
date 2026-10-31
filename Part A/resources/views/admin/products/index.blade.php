@extends('layouts.admin')
@section('title','Products')
@section('content')
<div class="flex mb-2" style="justify-content:space-between">
    <form method="GET" class="flex" style="flex:1">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search products…" style="max-width:240px">
        <button class="btn btn-sm" type="submit">Search</button>
    </form>
    <a class="btn btn-sm" href="{{ route('admin.products.create') }}">+ Add product</a>
</div>
<div class="table-wrap card" style="padding:0">
<table>
<thead><tr><th>Name</th><th>Category</th><th>Shop</th><th>Price</th><th>Stock</th><th>Status</th><th></th></tr></thead>
<tbody>
@forelse($products as $p)
<tr>
    <td><strong>{{ $p->name }}</strong></td>
    <td>{{ $p->category->name ?? '—' }}</td>
    <td>{{ $p->shop->name ?? '—' }}</td>
    <td>৳{{ number_format($p->price,2) }}</td>
    <td>{{ $p->stock }}</td>
    <td><span class="badge">{{ $p->status }}</span></td>
    <td class="flex">
        <a class="btn btn-sm btn-outline" href="{{ route('admin.products.edit', $p) }}">Edit</a>
        <form method="POST" action="{{ route('admin.products.destroy', $p) }}" onsubmit="return confirm('Delete product?')">@csrf @method('DELETE')
            <button class="btn btn-sm btn-outline" type="submit">Delete</button>
        </form>
    </td>
</tr>
@empty
<tr><td colspan="7" class="muted">No products. Add one or run DemoCatalogSeeder.</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="mt-2">{{ $products->links() }}</div>
@endsection
