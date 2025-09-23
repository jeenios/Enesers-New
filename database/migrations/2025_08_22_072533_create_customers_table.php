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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Active', 'Inactive'])->nullable()->default('Active');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->boolean('customer')->default(false);
            $table->foreignId('payment_term_id')->nullable()->constrained('payment_terms')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('customer_category')->nullable();
            $table->foreignId('sales_pricelist_id')->nullable()->constrained('sales_pricelists')->cascadeOnDelete();
            $table->integer('credit_limit');
            $table->integer('grace_period');
            $table->boolean('tax')->nullable()->default(false);
            $table->string('tax_name')->nullable();
            $table->string('tax_number')->nullable();
            $table->json('address')->nullable();
            $table->json('contact')->nullable();
            $table->string('receivable_account')->nullable();
            $table->json('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
