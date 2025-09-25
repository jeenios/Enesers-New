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
        Schema::create('purchase_requisition_templates', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Active', 'Inactive'])->nullable()->default('Active');
            $table->string('description')->nullable();
            $table->string('warehouse_id')->nullable();
            $table->string('transaction_at')->nullable();
            $table->string('item_id')->nullable();
            $table->integer('description_barcode')->nullable();
            $table->integer('quantity_barcode')->nullable();
            $table->string('unit_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisition_templates');
    }
};
