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
        Schema::create('item_barcode_generators', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Active', 'Inactive'])->nullable()->default('Active');
            $table->string('description')->nullable();
            $table->foreignId('sales_pricelist_id')->nullable()->constrained('sales_pricelists')->cascadeOnDelete();
            $table->integer('quantity_modifier')->nullable();
            $table->string('price_format')->nullable();
            $table->foreignId('item_id')->nullable()->constrained('items')->cascadeOnDelete();
            $table->integer('description_barcode')->nullable();
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
        Schema::dropIfExists('item_barcode_generators');
    }
};
