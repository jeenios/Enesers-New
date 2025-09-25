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
        Schema::create('outgoing_financial_payment_multiples', function (Blueprint $table) {
            $table->id();
            $table->string('outgoing_financial_payment_id')->nullable()->constrained('outgoing_financial_payments')->cascadeOnDelete();
            $table->string('financial_reason_id')->nullable()->constrained('financial_reasons')->cascadeOnDelete();
            $table->string('amount')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_financial_payment_multiples');
    }
};
