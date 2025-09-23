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
        Schema::create('purchase_invoice_payment_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_invoice_payment_id')
                ->nullable()
                ->constrained('purchase_invoice_payments')
                ->cascadeOnDelete();

            $table->foreignId('purchase_invoice_id')
                ->nullable()
                ->constrained('purchase_invoices')
                ->nullOnDelete();
            $table->foreignId('item_id')
                ->nullable()
                ->constrained('items')
                ->cascadeOnDelete();
            $table->string('description_invoice')->nullable();
            $table->decimal('amount_invoice', 15, 2)->nullable();
            $table->decimal('discount_invoice', 15, 2)->nullable();

            $table->string('financial_reason')->nullable();
            $table->string('description_financial')->nullable();
            $table->decimal('amount_financial', 15, 2)->nullable();

            $table->foreignId('warehouse_id')
                ->nullable()
                ->constrained('warehouses')
                ->cascadeOnDelete();
            $table->foreignId('business_unit_id')
                ->nullable()
                ->constrained('business_units')
                ->cascadeOnDelete();
            $table->foreignId('project_id')
                ->nullable()
                ->constrained('projects')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_invoice_payment_multiples');
    }
};
