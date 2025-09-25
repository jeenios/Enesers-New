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
            $table->string('purchase_requisitiontemplate_id')
                ->nullable();
            $table->string('item_id')
                ->nullable();
            $table->string('description_barcode')->nullable();
            $table->integer('quantity_barcode')->nullable();
            $table->string('unit_id')
                ->nullable();
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
