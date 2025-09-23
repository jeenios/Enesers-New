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
        Schema::create('purchase_shipment_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_shipment_id')->nullable()->constrained('purchase_shipments')->cascadeOnDelete();
            $table->foreignId('purchase_shipment_multiple_id')
                ->nullable()
                ->constrained('purchase_shipment_multiples')
                ->nullOnDelete();
            $table->foreignId('item_id')->nullable()->constrained('items')->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->foreignId('unit_id')->nullable()->constrained('units')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_shipment_multiples');
    }
};
