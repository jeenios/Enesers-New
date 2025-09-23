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
        Schema::create('stock_adjustment_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_adjustment_id')->nullable()->constrained('stock_adjustments')->cascadeOnDelete();
            $table->foreignId('item_id')->nullable()->constrained('items')->cascadeOnDelete();
            $table->integer('quantity')->nullable()->default(1);
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete();
            $table->string('buy_price_type')->nullable();
            $table->string('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_adjustment_multiples');
    }
};
