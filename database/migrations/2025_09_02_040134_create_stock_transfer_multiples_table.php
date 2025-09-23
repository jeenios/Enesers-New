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
        Schema::create('stock_transfer_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_transfer_id')
                ->nullable()
                ->constrained('stock_transfers')
                ->cascadeOnDelete();

            $table->foreignId('purchase_requisition_multiple_id')
                ->nullable()
                ->constrained('purchase_requisition_multiples')
                ->nullOnDelete();

            $table->foreignId('item_id')
                ->nullable()
                ->constrained('items')
                ->cascadeOnDelete();

            $table->integer('quantity')->default(1);
            $table->foreignId('unit_id')
                ->nullable()
                ->constrained('units')
                ->cascadeOnDelete();

            $table->string('description')->nullable();

            $table->string('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfer_multiples');
    }
};
