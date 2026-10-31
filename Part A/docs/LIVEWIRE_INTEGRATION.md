# Laravel Livewire Integration — Khati Dairy

## 1. What is Livewire?

**Livewire** is a Laravel full-stack framework for building dynamic UIs with PHP — without writing a separate SPA (React/Vue). Components re-render over AJAX while staying server-driven, which fits the proposal stack: **Laravel + Blade + PHP**.

Official docs: https://livewire.laravel.com

## 2. Why use Livewire in this project?

| Feature | Without Livewire | With Livewire |
|---------|------------------|---------------|
| Product search/filter | Full page reload | Instant filter, no full refresh |
| Cart quantity +/- | Form POST + redirect | Inline update, badge updates |
| Admin order status | Form submit | Dropdown change → live table |
| Attendance mark | Full page | One-click present/absent |
| Low-stock alerts | Static | Live polling optional |

Proposal tech stack remains **Laravel/Blade** — Livewire is an optional enhancement layer, not a stack change.

## 3. Installation (on your machine)

```bash
cd khati-dairy-laravel
composer require livewire/livewire
php artisan livewire:publish --config   # optional
```

Include assets in `resources/views/layouts/app.blade.php` (Laravel 11+ auto-discovers; for classic layout):

```blade
<!DOCTYPE html>
<html>
<head>
    ...
    @livewireStyles
</head>
<body>
    ...
    @livewireScripts
</body>
</html>
```

## 4. Recommended components for Khati Dairy

### 4.1 ProductSearch (customer catalog)

```bash
php artisan make:livewire ProductSearch
```

**Responsibilities:**
- `wire:model.live.debounce.300ms="query"` — search name
- Filters: category_id, shop_id, in_stock
- Query: `Product::with(["category","shop"])->when(...)->paginate(12)`

Skeleton (already provided under `app/Livewire/ProductSearch.php`):

```php
// public string $query = "";
// public ?int $categoryId = null;
// render() returns filtered products
```

### 4.2 CartBadge

- Listens to browser event / session cart count
- Shows item count in header without page reload after "Add to cart"

### 4.3 AdminOrderStatus

- Dropdown per order row: `wire:change="updateStatus(\$orderId, \$status)"`
- Uses Order model + RBAC (admin/manager only)

### 4.4 AttendanceQuickMark

- Employee/manager marks present for today
- Respects UNIQUE(employee_id, date)

## 5. Security notes

1. **Authorize inside Livewire methods** — same as controllers:
   ```php
   abort_unless(auth()->user()?->isAdmin() || auth()->user()?->isManager(), 403);
   ```
2. Validate all public property updates with `$rules` or `#[Validate]`.
3. Do not trust client-sent IDs without ownership checks (shop_owner may only touch own shop_id products).
4. CSRF is handled by Livewire automatically.

## 6. Eloquent + Livewire pattern

```php
public function render()
{
    return view("livewire.product-search", [
        "products" => Product::query()
            ->with(["category", "shop"])  // eager load — avoid N+1
            ->when($this->query, fn ($q) => $q->where("name", "like", "%{$this->query}%"))
            ->when($this->categoryId, fn ($q) => $q->where("category_id", $this->categoryId))
            ->where("status", "active")
            ->paginate(12),
        "categories" => Category::where("is_active", true)->orderBy("name")->get(),
    ]);
}
```

## 7. Integration roadmap (optional phases)

| Phase | Component | Priority |
|-------|-----------|----------|
| 1 | ProductSearch on /products | High |
| 2 | Cart quantity + header badge | High |
| 3 | Admin order status dropdown | Medium |
| 4 | Inventory low-stock live table | Medium |
| 5 | Attendance quick mark | Low |

Core project works **without** Livewire (classic Blade forms). Add Livewire when you need richer UX.

## 8. Compatibility

- Livewire v3 requires PHP 8.1+ and Laravel 10+
- Works with MySQL and SQLite used by this project
- Does not replace auth/RBAC — complements Blade views

See also: `docs/DATABASE_SCHEMA.md` for relationship names to use inside Livewire queries.
