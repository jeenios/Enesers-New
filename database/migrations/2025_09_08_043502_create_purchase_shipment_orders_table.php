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
        Schema::create('purchase_shipment_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Completed', 'Pending'])->nullable()->default('Completed');
            $table->string('company_id')->nullable();
            $table->string('bussiness_unit_id')->nullable();
            $table->string('project_input')->nullable();
            $table->string('item_type')->nullable();
            $table->string('tax_calculation')->nullable();
            $table->string('warehouse_id')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('currency_id')->nullable();
            $table->string('exchange_rate_id')->nullable();
            $table->string('discount_calculation')->nullable();
            $table->string('rounding_amount')->nullable();
            $table->string('delivery_method_id')->nullable();
            $table->string('reference')->nullable();
            $table->string('description')->nullable();
            $table->string('payment_term_id')->nullable();
            $table->string('transaction_at')->nullable();
            $table->string('delivery_at')->nullable();

            $table->string('contact_person_name_shipment')->nullable();
            $table->string('contact_person_phone_shipment')->nullable();
            $table->string('address_shipment')->nullable();
            $table->string('currency_shipment_id')->nullable();
            $table->string('postcode_shipment', 20)->nullable();

            $table->string('template_bill')->nullable();
            $table->string('address_bill')->nullable();
            $table->string('currency_bill_id')->nullable();
            $table->string('postcode_bill', 20)->nullable();

            $table->string('template_company')->nullable();
            $table->string('address_company')->nullable();
            $table->string('currency_company_id')->nullable();
            $table->string('postcode_company', 20)->nullable();

            $table->string('template_from')->nullable();
            $table->string('contact_person_name_from')->nullable();
            $table->string('contact_person_phone_from')->nullable();
            $table->string('address_from')->nullable();
            $table->string('currency_from_id')->nullable();
            $table->string('postcode_from', 20)->nullable();

            $table->string('purchase_requisition_id')->nullable()->constrained('purchase_requisitions')->cascadeOnDelete();

            $table->json('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_shipment_orders');
    }
};
