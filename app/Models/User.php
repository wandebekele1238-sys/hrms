<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Branch;
use Spatie\Permission\Traits\HasRoles;
        
class User extends Authenticatable
{
/** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected $fillable = ['name', 'email', 'password','branch_id', 'department_id', 'position_id',
 'employee_id', 'phone', 'date_of_birth', 'hire_date', 'employment_type', 'status', 'salary', 'address', 
 'emergency_contact_name', 'emergency_contact_phone'];

 protected $hidden = ['password', 'remember_token'];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'salary' =>  'decimal:2'
        ];
    }

    public function department(): BelongsTo
    {
         return $this->belongsTo(Department::class);
    }
    public function position(): BelongsTo
    {
         return $this->belongsTo(Position:: class);
    }
    public function branch(): BelongsTo
    {
         return $this->belongsTo(Branch:: class);
    }
    public function attendances(): HasMany
    {
         return $this->hasMany(Attendance::class);
    }
    public function leaverequests(): HasMany
    {
         return $this->hasMany(LeaveRequest:: class);
    }
    public function payrolls(): HasMany
    {
         return $this->hasMany(Payroll:: class);
    }
    public function leaveBalances(): HasMany
   {
    return $this->hasMany(LeaveBalance::class);
  
    }
    public function performanceReviews(): HasMany
    {
         return $this->hasMany(PerformanceReview:: class);
    }

    protected static function boot(): void
{
    parent::boot();

    static::creating(function ($employee) {
        if (empty($employee->employee_id)) {
            $lastEmployee = static::orderBy('id', 'desc')->first();

            $nextNumber = 1;

            if ($lastEmployee && $lastEmployee->employee_id) {
                if (preg_match('/^EMP-(\d+)$/', $lastEmployee->employee_id, $matches)) {
                    $nextNumber = ((int) $matches[1]) + 1;
                }
            }

            $employee->employee_id = 'EMP-' . str_pad(
                $nextNumber,
                6,
                '0',
                STR_PAD_LEFT
            );
        }
    });
}
}
