<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** InventoryItem — stock at farm/shop/online. belongsTo Shop, Product */
class InventoryItem extends Model
{
    protected $fillable = [
        'location_type', 'shop_id', 'product_id', 'product_name',
        'quantity', 'unit', 'low_threshold',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'low_threshold' => 'decimal:2',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->low_threshold;
    }
}
