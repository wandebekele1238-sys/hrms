<?php

namespace App\Models;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Position extends Model
{
    protected $fillable= ['title', 'department_id', 'min_salary', 'max_salary', 'description'];

      protected $casts = [
            'min_salary' => 'decimal:2',
            'max_salary' => 'decimal:2',
        ];
    


    /** @use HasFactory<\Database\Factories\PositionFactory> */
    use HasFactory;
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function employees(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
