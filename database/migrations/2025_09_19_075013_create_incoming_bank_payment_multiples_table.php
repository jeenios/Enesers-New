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
        Schema::create('incoming_bank_payment_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_bank_payment_id')->nullable()->constrained('incoming_bank_payments')->cascadeOnDelete();
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
        Schema::dropIfExists('incoming_bank_payment_multiples');
    }
};
