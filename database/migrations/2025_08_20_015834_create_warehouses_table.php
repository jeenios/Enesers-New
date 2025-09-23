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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Active', 'Inactive'])->nullable()->default('Active');
            $table->string('name')->nullable();
            $table->foreignId('warehouse_category_id')->nullable()->constrained('warehouse_categories')->cascadeOnDelete();
            $table->boolean('warehouse_allow')->default(true)->nullable();
            $table->text('description')->nullable();
            $table->string('address_type')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('address')->nullable();
            $table->string('country_code')->nullable();
            $table->string('postcode')->nullable();
            $table->string('sales_account')->nullable();
            $table->string('sales_return_account')->nullable();
            $table->string('sales_discount_account')->nullable();
            $table->string('sales_commission_account')->nullable();
            $table->string('sales_gross_account')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
