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
        Schema::create('cash_advance_multiples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_advance_id')->nullable()->constrained('cash_advances')->cascadeOnDelete();
            $table->foreignId('cash_advance_reason_id')->nullable()->constrained('cash_advance_reasons')->cascadeOnDelete();
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
        Schema::dropIfExists('cash_advance_multiples');
    }
};
