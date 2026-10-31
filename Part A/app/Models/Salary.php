<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Salary — monthly payroll. belongsTo Employee */
class Salary extends Model
{
    protected $fillable = [
        'employee_id', 'month', 'basic_salary', 'days_present', 'days_absent',
        'days_late', 'days_leave', 'bonus', 'deduction', 'net_salary',
        'payment_date', 'payment_status', 'note',
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'bonus' => 'decimal:2',
        'deduction' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
