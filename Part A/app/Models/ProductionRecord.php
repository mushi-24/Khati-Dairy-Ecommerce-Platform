<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** ProductionRecord — farm output batch. belongsTo User (recorded_by) */
class ProductionRecord extends Model
{
    protected $fillable = [
        'product_name', 'quantity', 'unit', 'production_date',
        'batch_reference', 'notes', 'recorded_by',
    ];

    protected $casts = [
        'production_date' => 'date',
        'quantity' => 'decimal:2',
    ];

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
