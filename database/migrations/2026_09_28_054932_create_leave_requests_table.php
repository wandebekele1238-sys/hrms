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
        Schema::create(table: 'leave_requests',callback: function (Blueprint $table):void {
            $table->id();
            $table->foreignId(column: 'user_id')->constrained()->cascadeOnDelete();
            $table->foreignId(column: 'leave_type_id')->constrained();
            $table->date(column: 'start_date');
            $table->date(column: 'end_date');
            $table->integer(column: 'days');
            $table->text(column: 'reason');
            $table->enum(column: 'status', allowed: ['pending', 'approved', 'rejected'])->default(value:'pending');
            $table->foreignId(column: 'approved_by')->nullable()->constrained(table: 'users');
            $table->timestamp(column: 'approved_at')->nullable();
            $table->text(column: 'rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
