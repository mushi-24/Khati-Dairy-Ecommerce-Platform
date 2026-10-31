<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Product — sellable dairy item.
 * belongsTo Category, Shop | hasMany OrderItem, InventoryItem
 */
class Product extends Model
{
    protected $fillable = [
        'category_id', 'shop_id', 'name', 'slug', 'description',
        'price', 'unit', 'stock', 'image', 'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventoryItems(): HasMany
    {
        return $this->hasMany(InventoryItem::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'active' && $this->stock > 0;
    }

    /**
     * Public URL for product image (works with public/images and storage/app/public).
     */
    public function imageUrl(): string
    {
        $fallback = asset('images/products/milk.jpg');
        $path = $this->image;
        if (!$path) {
            return $fallback;
        }
        $path = ltrim($path, '/');

        // storage/products/xxx → public/storage/products/xxx (after storage:link)
        if (str_starts_with($path, 'storage/')) {
            $relative = substr($path, strlen('storage/'));
            if (is_file(storage_path('app/public/'.$relative))) {
                return asset('storage/'.$relative);
            }
            // also try public/storage
            if (is_file(public_path('storage/'.$relative))) {
                return asset('storage/'.$relative);
            }
        }

        if (is_file(public_path($path))) {
            return asset($path);
        }

        // images/products basename fallback
        $base = basename($path);
        if (is_file(public_path('images/products/'.$base))) {
            return asset('images/products/'.$base);
        }

        return $fallback;
    }
}
