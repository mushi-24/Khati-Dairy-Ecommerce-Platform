<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Attendance — daily presence. belongsTo Employee */
class Attendance extends Model
{
    protected $fillable = [
        'employee_id', 'date', 'status', 'check_in', 'check_out', 'note',
    ];

    protected $casts = ['date' => 'date'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
