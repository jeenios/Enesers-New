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
        Schema::create('purchase_requisition_template_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_requisitiontemplate_id')
                ->nullable()
                ->constrained('purchase_requisition_templates')
                ->cascadeOnDelete();
            $table->foreignId('item_id')
                ->nullable()
                ->constrained('items')
                ->cascadeOnDelete();
            $table->string('description_barcode')->nullable();
            $table->integer('quantity_barcode')->nullable();
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
        Schema::dropIfExists('purchase_requisition_template_multiples');
    }
};
