<article class="product-card">
    <a href="{{ route('products.show', $p) }}" class="thumb">
        <img src="{{ $p->imageUrl() }}" alt="{{ $p->name }}" loading="lazy" width="400" height="400"
             onerror="this.onerror=null;this.src='{{ asset('images/products/milk.jpg') }}'">
    </a>
    <div class="body">
        <div class="meta">{{ $p->category->name ?? 'Dairy' }} · {{ $p->shop->name ?? 'Khati Farm' }}</div>
        <h3><a href="{{ route('products.show', $p) }}">{{ $p->name }}</a></h3>
        <div class="muted">{{ $p->unit }} · {{ $p->stock > 0 ? 'In stock' : 'Out of stock' }}</div>
        <div class="price">৳{{ number_format($p->price, 2) }}</div>
        <div class="actions">
            <form method="POST" action="{{ route('cart.add', $p) }}" style="flex:1">@csrf
                <button class="btn btn-sm btn-block" type="submit" @disabled($p->stock < 1)>Add to cart</button>
            </form>
            <a class="btn btn-sm btn-outline" href="{{ route('products.show', $p) }}">View</a>
        </div>
    </div>
</article>
