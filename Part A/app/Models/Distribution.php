<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Distribution — farm → shop transfer. belongsTo Shop, User (recorder) */
class Distribution extends Model
{
    protected $fillable = [
        'product_name', 'shop_id', 'quantity', 'unit', 'distribution_date',
        'remaining_farm_stock', 'notes', 'recorded_by',
    ];

    protected $casts = [
        'distribution_date' => 'date',
        'quantity' => 'decimal:2',
        'remaining_farm_stock' => 'decimal:2',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
