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
            $table->string('stock_transfer_id')
                ->nullable();

            $table->string('purchase_requisition_multiple_id')
                ->nullable();

            $table->string('item_id')
                ->nullable();

            $table->integer('quantity')->default(1);
            $table->string('unit_id')
                ->nullable();

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
