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
        Schema::create('purchase_down_payment_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_down_payment_id')->nullable()->constrained('purchase_down_payments')->cascadeOnDelete();
            $table->string('tax')->nullable();
            $table->string('amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_down_payment_multiples');
    }
};
