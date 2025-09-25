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
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->enum('state', ['Active', 'Inactive'])->nullable()->default('Active');
            $table->foreignId('currency_id')
                ->nullable()
                ->constrained('currencies')
                ->cascadeOnDelete();
            $table->float('rate')->nullable()->default(0);
            $table->date('effective_at')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
