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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('state', ['Completed', 'Pending'])->nullable()->default('Completed');
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('bussiness_unit_id')->nullable()->constrained('business_units')->cascadeOnDelete();
            $table->string('project_input')->nullable();
            $table->string('sales_input')->nullable();
            $table->string('tax_calculation')->nullable();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete()->nullable();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->foreignId('exchange_rate_id')->nullable()->constrained('exchange_rates')->cascadeOnDelete();
            $table->foreignId('sales_pricelist_id')->nullable()->constrained('sales_pricelists')->cascadeOnDelete();
            $table->string('discount_calculation')->nullable();
            $table->string('rounding_amount')->nullable();
            $table->foreignId('delivery_method_id')
                ->nullable()
                ->constrained('delivery_methods')
                ->cascadeOnDelete();
            $table->string('reference')->nullable();
            $table->string('description')->nullable();
            $table->string('payment_term')->nullable();
            $table->string('transaction_at');
            $table->string('estimate_at');
            $table->string('estimate_billing_at');
            $table->string('description_billing')->nullable();

            $table->foreignId('item_category_id')->nullable()->constrained('item_categories')->cascadeOnDelete();
            $table->string('description_item')->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->foreignId('unit_id')->nullable()->constrained('units')->cascadeOnDelete();
            $table->integer('price')->nullable();
            $table->boolean('toggle_discount')->nullable()->default(false);
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->cascadeOnDelete();
            $table->foreignId('tax_id')->nullable()->constrained('taxes')->cascadeOnDelete();

            $table->string('contact_person_name_shipment')->nullable();
            $table->string('contact_person_phone_shipment')->nullable();
            $table->string('address_shipment')->nullable();
            $table->foreignId('currency_shipment_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_shipment', 20)->nullable();

            $table->string('template_bill')->nullable();
            $table->string('address_bill')->nullable();
            $table->foreignId('currency_bill_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_bill', 20)->nullable();

            $table->string('template_company')->nullable();
            $table->string('address_company')->nullable();
            $table->foreignId('currency_company_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_company', 20)->nullable();

            $table->string('template_from')->nullable();
            $table->string('contact_person_name_from')->nullable();
            $table->string('contact_person_phone_from')->nullable();
            $table->string('address_from')->nullable();
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
        Schema::dropIfExists('sales_orders');
    }
};
