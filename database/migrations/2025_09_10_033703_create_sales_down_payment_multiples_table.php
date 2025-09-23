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
        Schema::create('sales_down_payment_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_down_payment_id')->nullable()->constrained('sales_down_payments')->cascadeOnDelete();
            $table->string('tax_name')->nullable();
            $table->integer('tax_amount')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_down_payment_multiples');
    }
};
