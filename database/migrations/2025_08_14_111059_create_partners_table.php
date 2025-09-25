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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Active', 'Inactive'])->default('Active');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->boolean('customer')->nullable()->default(false);
            $table->string('customer_payment_term')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->boolean('vendor')->nullable()->default(false);
            $table->string('vendor_payment_term')->nullable();
            $table->foreignId('partner_category_id')->nullable()->constrained('partner_categories')->cascadeOnDelete();
            $table->string('sales_pricelist_id')->nullable();
            $table->boolean('tax')->nullable()->default(false);
            $table->string('tax_name')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('receivable_account')->nullable();
            $table->string('payable_account')->nullable();
            $table->json('image')->nullable();
            $table->json('contact')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
