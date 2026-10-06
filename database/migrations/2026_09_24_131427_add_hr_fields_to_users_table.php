<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(table: 'users',callback: function (Blueprint $table): void {
            $table->foreignId(column:'department_id')->nullable()->constrained('departments');
            $table->foreignId(column:'position_id')->nullable()->constrained('positions');
            $table->string(column:'employee_id')->unique()->nullable();
            $table->string(column:'phone')->nullable();
            $table->foreignId(column:'branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->date(column:'date_of_birth')->nullable();
            $table->date(column:'hire_date')->nullable();
            $table->enum(column:'employment_type', allowed:['full-time', 'part-time', 'contract', 'intern'])->default(value:'full-time');
            $table->enum(column:'status', allowed:['active', 'inactive', 'on-leave', 'terminated'])->default(value:'active');
            $table->decimal(column:'salary', total: 10, places: 2)->nullable();
            $table->text(column:'address')->nullable();
            $table->string(column:'emergency_contact_name')->nullable();
            $table->string(column:'emergency_contact_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {Schema::table(table: 'users',callback: function (Blueprint $table): void {
            $table->dropForeign(index:['department_id']);
             $table->dropForeign(index:['position_id']);
             $table->dropColumn(column: [
            'department_id',
            'position_id',
           'employee_id',
           'phone',
            'date_of_birth',
            'hire_date',
            'employment_type',
            'status', 
            'salary',
            'address',
            'emergency_contact_name',
            'emergency_contact_phone',
            ]);
        });
    }
};
