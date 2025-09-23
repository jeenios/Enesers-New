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
        Schema::create('sales_events', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->boolean('state', ['Active', 'Inactive'])->nullable()->default('Active');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->cascadeOnDelete();
            $table->foreignId('commission_id')->nullable()->constrained('commissions')->cascadeOnDelete();
            $table->string('rule_type')->nullable();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('warehouse_category_id')->nullable()->constrained('warehouse_categories')->cascadeOnDelete();
            $table->foreignId('item_id')->nullable()->constrained('items')->cascadeOnDelete();
            $table->foreignId('item_category_id')->nullable()->constrained('item_categories')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_events');
    }
};
