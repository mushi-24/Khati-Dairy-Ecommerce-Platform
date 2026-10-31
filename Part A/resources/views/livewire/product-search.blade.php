{{-- Enable after: composer require livewire/livewire --}}
{{-- <div>
    <div class="card" style="margin-bottom:16px;display:flex;flex-wrap:wrap;gap:12px;align-items:end">
        <div class="form-group" style="flex:1;min-width:180px;margin:0">
            <label>Search</label>
            <input type="search" wire:model.live.debounce.300ms="query" placeholder="Milk, ghee, yogurt...">
        </div>
        <div class="form-group" style="min-width:160px;margin:0">
            <label>Category</label>
            <select wire:model.live="categoryId">
                <option value="">All</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <label style="display:flex;align-items:center;gap:6px;font-size:13px">
            <input type="checkbox" wire:model.live="inStockOnly"> In stock only
        </label>
        <button type="button" class="btn-outline btn" wire:click="clearFilters">Clear</button>
    </div>

    <div class="grid">
        @forelse($products as $p)
            <div class="card">
                <a href="{{ route("products.show", $p) }}"><strong>{{ $p->name }}</strong></a>
                <div class="muted">{{ $p->category->name ?? "" }} · {{ $p->shop->name ?? "" }}</div>
                <div class="price">৳{{ number_format($p->price, 2) }}</div>
            </div>
        @empty
            <p class="muted">No products match your filters.</p>
        @endforelse
    </div>

    <div style="margin-top:16px">{{ $products->links() }}</div>
</div> --}}
