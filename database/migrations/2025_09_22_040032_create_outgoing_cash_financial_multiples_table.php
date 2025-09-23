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
        Schema::create('outgoing_cash_financial_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outgoing_cash_financial_id')->nullable()->constrained('outgoing_cash_financials')->cascadeOnDelete();
            $table->foreignId('financial_reason_id')->nullable()->constrained('financial_reasons')->cascadeOnDelete();
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
        Schema::dropIfExists('outgoing_cash_financial_multiples');
    }
};
