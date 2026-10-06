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
        Schema::create(table:'positions', callback: function (Blueprint $table): void {
            $table->id();
            $table->foreignId(column:'department_id')->constrained()->cascadeOnDelete();
            $table->string(column: 'title');
            $table->decimal(column:'min_salary', total: 10, places: 2);
            $table->decimal(column:'max_salary', total: 10, places: 2);
            $table->text(column:'description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
