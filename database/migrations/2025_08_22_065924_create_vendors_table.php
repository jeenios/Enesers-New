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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Active', 'Inactive'])->nullable()->default('Active');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('payment_term_id')->nullable();
            $table->string('vendor_category')->nullable();
            $table->boolean('tax')->nullable()->default(false);
            $table->string('tax_name')->nullable();
            $table->string('tax_number')->nullable();
            $table->json('address')->nullable();
            $table->json('contact')->nullable();
            $table->string('payable_account')->nullable();
            $table->json('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
