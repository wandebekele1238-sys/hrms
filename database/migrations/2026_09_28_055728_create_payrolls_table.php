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
        
        Schema::create(table: 'payrolls',callback: function (Blueprint $table):void {
            $table->id();
            $table->foreignId(column: 'user_id')->constrained()->cascadeOnDelete();
            $table->string(column: 'month');
            $table->integer(column: 'year');
            $table->decimal(column: 'basic_salary',total: 10, places: 2);
            $table->decimal(column: 'allowances',total:  10, places: 2)->default(0);
            $table->decimal(column: 'deductions',total:  10, places: 2)->default(0);
            $table->decimal(column: 'bonus',total:  10, places: 2)->default(0);
            $table->decimal(column: 'net_salary',total:  10, places: 2);
            $table->enum(column: 'status', allowed: ['draft', 'processed', 'paid'])->default(value:'draft');
            $table->date(column: 'paid_at')->nullable();
            $table->timestamps();
            $table->unique(columns: ['user_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
