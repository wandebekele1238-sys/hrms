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
        Schema::create(table: 'attendances', callback: function (Blueprint $table):void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date(column: 'date');
            $table->time(column: 'check_in')->nullable();
            $table->time(column: 'check_out')->nullable();
            $table->enum(column: 'status', allowed: ['present', 'absent', 'late', 'half-day'])->default(value:'present');
            $table->text(column: 'notes')->nullable();
            $table->timestamps();
            $table->unique( columns: ['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
