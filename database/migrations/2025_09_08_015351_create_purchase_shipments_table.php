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
        Schema::create('purchase_shipments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Completed', 'Pending'])->nullable()->default('Completed');
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('bussiness_unit_id')->nullable()->constrained('business_units')->cascadeOnDelete();
            $table->string('project_input')->nullable();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete()->nullable();
            $table->foreignId('delivery_method_id')->nullable()->constrained('delivery_methods')->cascadeOnDelete()->nullable();
            $table->string('reference')->nullable();
            $table->string('description')->nullable();
            $table->string('transaction_at')->nullable();
            $table->string('delivery_at')->nullable();

            $table->string('contact_person_name_shipment')->nullable();
            $table->string('contact_person_phone_shipment')->nullable();
            $table->string('address_shipment')->nullable();
            $table->foreignId('currency_shipment_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_shipment', 20)->nullable();

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

            $table->foreignId('purchase_requisition_id')->nullable()->constrained('purchase_requisitions')->cascadeOnDelete();

            $table->json('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_shipments');
    }
};
