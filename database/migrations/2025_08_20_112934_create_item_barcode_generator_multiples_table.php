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
        Schema::create('item_barcodegenerator_multiple', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_barcodegenerator_id')
                ->nullable()
                ->constrained('item_barcode_generators')
                ->cascadeOnDelete();

            $table->foreignId('item_id')
                ->nullable()
                ->constrained('items')
                ->cascadeOnDelete();

            $table->string('description_barcode')->nullable();
            $table->integer('quantity_barcode')->nullable();
            $table->integer('price_barcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_barcodegenerator_multiple');
    }
};
