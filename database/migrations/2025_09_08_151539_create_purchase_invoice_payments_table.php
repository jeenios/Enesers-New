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
        Schema::create('purchase_invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('state', ['Completed', 'Pending'])->nullable()->default('Completed');
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('bussiness_unit_id')->nullable()->constrained('business_units')->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete()->nullable();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('input_type')->nullable();
            $table->string('reference')->nullable();
            $table->string('description')->nullable();
            $table->string('payment_method')->nullable();
            $table->foreignId('exchange_rate_id')->nullable()->constrained('exchange_rates')->cascadeOnDelete();
            $table->string('transaction_at')->nullable();
            $table->string('paid_at')->nullable();

            $table->string('template_bill')->nullable();
            $table->string('address_bill')->nullable();
            $table->foreignId('currency_bill_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_bill', 20)->nullable();

            $table->string('template_company')->nullable();
            $table->string('address_company')->nullable();
            $table->foreignId('currency_company_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('postcode_company', 20)->nullable();

            $table->json('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_invoice_payments');
    }
};
