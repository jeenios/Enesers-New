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
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('state', ['Completed', 'Pending'])->nullable()->default('Completed');
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('bussiness_unit_id')->nullable()->constrained('business_units')->cascadeOnDelete();
            $table->string('project_input')->nullable();
            $table->boolean('toggle_stock')->nullable()->default(false);
            $table->enum('transaction_type', ['Delivery', 'Return'])->default('Delivery')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('partner_id')->nullable()->constrained('partners')->cascadeOnDelete();
            $table->foreignId('sales_price_list_id')->nullable()->constrained('sales_pricelists')->cascadeOnDelete();
            $table->string('reference')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('destination_warehouse_id')->nullable()->constrained('warehouses')->cascadeOnDelete();
            $table->string('contact_person_name_warehouse')->nullable();
            $table->string('contact_person_phone_warehouse')->nullable();
            $table->string('address_warehouse')->nullable();
            $table->foreignId('currency_warehouse_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_warehouse', 20)->nullable();
            $table->string('contact_person_name_destination')->nullable();
            $table->string('contact_person_phone_destination')->nullable();
            $table->string('address_destination')->nullable();
            $table->foreignId('currency_destination_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_destination', 20)->nullable();
            $table->string('template_company')->nullable();
            $table->string('address_company')->nullable();
            $table->foreignId('currency_company_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_company', 20)->nullable();
            $table->string('transaction_at')->nullable();
            $table->string('delivered_at')->nullable();
            $table->json('image')->nullable();
            $table->foreignId('purchase_requisition_id')->nullable()->constrained('purchase_requisitions')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfers');
    }
};
