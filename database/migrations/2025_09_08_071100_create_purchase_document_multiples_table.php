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
        Schema::create('purchase_document_multiples', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_document_id')->nullable()->constrained('purchase_documents')->cascadeOnDelete();
            $table->string('purchase_order_item_id')->nullable()->constrained('purchase_order_items')->cascadeOnDelete();

            $table->string('item_name')->nullable();
            $table->integer('qty')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('price', 15, 2)->nullable()->default(0);
            $table->decimal('total', 15, 2)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_document_multiples');
    }
};
