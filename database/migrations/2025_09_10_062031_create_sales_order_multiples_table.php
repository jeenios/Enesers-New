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
        Schema::create('sales_order_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')->nullable()->constrained('sales_orders')->cascadeOnDelete();

            $table->string('input_type')->nullable();
            $table->string('value_type')->nullable();
            $table->string('description_type')->nullable();
            $table->foreignId('tax_type_id')
                ->nullable()
                ->constrained('taxes')
                ->cascadeOnDelete();
            $table->string('estimated_type')->nullable();

            $table->string('type')->nullable()->default('line_item');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_multiples');
    }
};
