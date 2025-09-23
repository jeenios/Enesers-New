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
        Schema::create('item_salespriceentry_multiple', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_salespriceentry_id')
                ->constrained('item_sales_price_entries')
                ->cascadeOnDelete();
            $table->foreignId('item_id')
                ->nullable()
                ->constrained('items')
                ->cascadeOnDelete();
            $table->string('description_barcode')->nullable();
            $table->integer('quantity_barcode')->nullable();
            $table->integer('price_barcode')->nullable();
            $table->foreignId('unit_id')
                ->nullable()
                ->constrained('units')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_sales_price_entry_multiples');
    }
};
