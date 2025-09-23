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
        Schema::create('purchase_shipment_order_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_shipment_order_id')->nullable()->constrained('purchase_shipment_orders')->cascadeOnDelete();
            $table->foreignId('purchase_shipment_order_multiple')
                ->nullable()
                ->constrained('purchase_requisition_multiples')
                ->nullOnDelete();
            $table->foreignId('item_id')->nullable()->constrained('items')->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->integer('price')->nullable();
            $table->boolean('toggle_discount')->nullable()->default(false);
            $table->foreignId('unit_id')->nullable()->constrained('units')->cascadeOnDelete();
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->cascadeOnDelete();
            $table->foreignId('tax_id')
                ->nullable()
                ->constrained('taxes')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_shipment_order_multiples');
    }
};
