<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** OrderItem — line on an order. belongsTo Order, Product */
class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'price', 'quantity', 'line_total',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'line_total' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
