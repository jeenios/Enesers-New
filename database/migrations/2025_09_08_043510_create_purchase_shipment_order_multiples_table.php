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
            $table->string('purchase_shipment_order_id')->nullable();
            $table->string('purchase_shipment_order_multiple')->nullable();
            $table->string('item_id')->nullable();
            $table->string('description')->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->integer('price')->nullable();
            $table->boolean('toggle_discount')->nullable()->default(false);
            $table->string('unit_id')->nullable();
            $table->string('discount_id')->nullable();
            $table->string('tax_id')->nullable();
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
