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
        Schema::create('purchase_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Completed', 'Pending'])->nullable()->default('Completed');
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('business_unit_id')->nullable()->constrained('business_units')->cascadeOnDelete();
            $table->string('project_input')->nullable();
            $table->string('sales_input')->nullable();
            $table->string('tax_calculation')->nullable();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->foreignId('exchange_rate_id')->nullable()->constrained('exchange_rates')->cascadeOnDelete();
            $table->foreignId('sales_pricelist_id')->nullable()->constrained('sales_pricelists')->cascadeOnDelete();

            $table->string('discount_calculation')->nullable();
            $table->decimal('rounding_amount', 15, 2)->nullable()->default(0);

            $table->foreignId('delivery_method_id')->nullable()->constrained('delivery_methods')->cascadeOnDelete();
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->string('payment_term')->nullable();
            $table->string('payment_method')->nullable();

            $table->dateTime('transaction_at')->nullable();
            $table->dateTime('estimate_at')->nullable();
            $table->dateTime('estimate_billing_at')->nullable();
            $table->string('description_billing')->nullable();

            // Address - Shipment
            $table->string('contact_person_name_shipment')->nullable();
            $table->string('contact_person_phone_shipment')->nullable();
            $table->text('address_shipment')->nullable();
            $table->foreignId('currency_shipment_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_shipment', 20)->nullable();

            // Address - Bill
            $table->string('template_bill')->nullable();
            $table->text('address_bill')->nullable();
            $table->foreignId('currency_bill_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_bill', 20)->nullable();

            // Address - Company
            $table->string('template_company')->nullable();
            $table->text('address_company')->nullable();
            $table->foreignId('currency_company_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_company', 20)->nullable();

            // Address - From
            $table->string('template_from')->nullable();
            $table->string('contact_person_name_from')->nullable();
            $table->string('contact_person_phone_from')->nullable();
            $table->text('address_from')->nullable();
            $table->foreignId('currency_from_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_from', 20)->nullable();

            $table->json('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_receipts');
    }
};
