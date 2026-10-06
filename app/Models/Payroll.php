<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable =['user_id', 'month', 'year', 'basic_salary', 'allowances', 'deductions', 'bonus', 'net_salary','status', 'paid_at'];
    /** @use HasFactory<\Database\Factories\PayslipFactory> */
    use HasFactory;

    protected $casts = [
            'basic_salary' => 'decimal:2',
            'allowances' => 'decimal:2',
            'deductions' => 'decimal:2',
            'bonus' => 'decimal:2',
            'net_salary' => 'decimal:2',
            'paid_at' => 'date',
        ];
   
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
