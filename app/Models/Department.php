<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Employee;

class Department extends Model
{

    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;
protected $fillable = ['name','description', 'color', 'manager_id'];
   public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    } 
    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }
    public function employees(): HasMany
    {
        return $this->hasMany(User::class);
    }
    
}
