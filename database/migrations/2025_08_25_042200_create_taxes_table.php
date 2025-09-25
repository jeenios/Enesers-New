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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Active', 'Inactive'])->nullable()->default('Active');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->float('value')->nullable()->default(0);
            $table->string('tax_type')->nullable();
            $table->string('purchase_tax_account')->nullable();
            $table->string('sales_tax_account')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};
