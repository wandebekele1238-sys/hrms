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
        Schema::create(table: 'performance_reviews', callback:  function (Blueprint $table):void {
            $table->id();
            $table->foreignId(column: 'user_id')->constrained()->cascadeOnDelete();
            $table->foreignId(column: 'reviewer_id')->constrained(table: 'users');
            $table->string(column: 'review_period');
            $table->integer(column: 'quality_of_work')->comment('1-10');
            $table->integer(column: 'productivity')->comment('1-10');
            $table->integer(column: 'communication')->comment('1-10');
            $table->integer(column: 'teamwork')->comment('1-10');
            $table->integer(column: 'leadership')->comment('1-10');
            $table->decimal(column: 'overall_rating', total: 3, places: 2);
            $table->text(column: 'strengths')->nullable();
            $table->text(column: 'areas_for_improvement')->nullable();
            $table->text(column: 'goals')->nullable();
            $table->text(column: 'comments')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
