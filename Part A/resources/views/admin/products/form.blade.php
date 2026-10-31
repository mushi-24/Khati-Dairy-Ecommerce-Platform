@extends('layouts.admin')
@section('title', $product->exists ? 'Edit product' : 'New product')
@section('content')
<form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
      enctype="multipart/form-data" class="card" style="max-width:680px">
    @csrf
    @if($product->exists) @method('PUT') @endif
    <div class="form-group"><label>Name *</label><input name="name" value="{{ old('name', $product->name) }}" required></div>
    <div class="form-row">
        <div class="form-group"><label>Category *</label>
            <select name="category_id" required>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id)==$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Shop</label>
            <select name="shop_id">
                <option value="">—</option>
                @foreach($shops as $s)
                    <option value="{{ $s->id }}" @selected(old('shop_id', $product->shop_id)==$s->id)>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="4" placeholder="Full product description…">{{ old('description', $product->description) }}</textarea>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Price (৳) *</label><input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? 0) }}" required></div>
        <div class="form-group"><label>Unit *</label><input name="unit" value="{{ old('unit', $product->unit ?? '1 unit') }}" required></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Stock *</label><input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required></div>
        <div class="form-group"><label>Status *</label>
            <select name="status">
                @foreach(['active','inactive','out_of_stock'] as $st)
                    <option value="{{ $st }}" @selected(old('status', $product->status ?? 'active')==$st)>{{ $st }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>Product image (upload new)</label>
        <input type="file" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif">
        <p class="muted">JPG/PNG/WebP, max 4MB. Uploading replaces the current image.</p>
    </div>
    @if($product->exists)
        <div class="form-group">
            <label>Current image preview</label>
            <img src="{{ $product->imageUrl() }}" alt="" style="max-width:180px;border-radius:12px;border:1px solid var(--border);display:block"
                 onerror="this.onerror=null;this.src='{{ asset('images/products/milk.jpg') }}'">
            <p class="muted mt-1">DB path: {{ $product->image ?: '—' }}</p>
        </div>
    @endif
    <div class="form-group">
        <label>Or image path (optional)</label>
        <input name="image" value="{{ old('image', $product->image) }}" placeholder="images/products/milk.jpg">
    </div>

    <div class="flex">
        <button class="btn" type="submit">Save product</button>
        <a class="btn btn-outline" href="{{ route('admin.products.index') }}">Cancel</a>
    </div>
</form>
@endsection
