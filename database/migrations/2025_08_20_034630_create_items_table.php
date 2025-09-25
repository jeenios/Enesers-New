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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Active', 'Inactive'])->nullable()->default('Active');
            $table->boolean('toggle')->nullable()->default(false);
            $table->string('barcode')->nullable();
            $table->string('name')->nullable();
            $table->string('general_description')->nullable();
            $table->string('purchase_description')->nullable();
            $table->string('sales_description')->nullable();
            $table->string('barcode_description')->nullable();
            $table->string('item_type')->nullable();
            $table->foreignId('unit_id')->nullable()->constrained('units')->cascadeOnDelete();
            $table->string('initial_buy')->nullable();
            $table->string('purchase_tax')->nullable(); // ini belum tau
            $table->string('sales_tax')->nullable(); // ini belum tau
            $table->string('item_category_id')->nullable();
            $table->string('weight')->nullable();
            $table->string('volume')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->boolean('sales_item')->default(false)->nullable();
            $table->boolean('purchase_item')->default(false)->nullable();
            $table->string('inventory_document')->nullable();
            $table->string('purchase_document')->nullable();
            $table->string('sales_document')->nullable();
            $table->string('accumulated_minimum_quantity')->nullable();
            $table->string('accumulated_max_quantity')->nullable();
            $table->string('default_minimum_quantity')->nullable();
            $table->string('default_max_quantity')->nullable();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses')->cascadeOnDelete();
            $table->integer('minimum_quantity')->nullable();
            $table->integer('maximum_quantity')->nullable();
            $table->string('sales_account')->nullable();
            $table->string('sales_return_account')->nullable();
            $table->string('sales_discount_account')->nullable();
            $table->string('sales_commision_account')->nullable();
            $table->string('sales_gross_account')->nullable();
            $table->string('purchase_account')->nullable();
            $table->string('purchase_return_account')->nullable();
            $table->string('inventory_account')->nullable();
            $table->string('cos_account')->nullable();
            $table->string('adjustment_increase_account')->nullable();
            $table->string('adjustment_decrease_account')->nullable();
            $table->string('inventory_usage_account')->nullable();
            $table->string('beginning_inventory_account')->nullable();
            $table->string('ending_inventory_account')->nullable();
            $table->string('purchase_alocation_account')->nullable();
            $table->string('work_inprogress_account')->nullable();
            $table->string('byproduct_account')->nullable();
            $table->json('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
