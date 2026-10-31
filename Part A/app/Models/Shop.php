<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Shop — multi-vendor dairy seller.
 * belongsTo User (owner) | hasMany Product, Order, Distribution, InventoryItem, members
 */
class Shop extends Model
{
    protected $fillable = [
        'name', 'slug', 'owner_id', 'phone', 'email', 'address', 'city',
        'description', 'image', 'is_verified', 'status',
    ];

    protected $casts = ['is_verified' => 'boolean'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function distributions(): HasMany
    {
        return $this->hasMany(Distribution::class);
    }

    public function inventoryItems(): HasMany
    {
        return $this->hasMany(InventoryItem::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
