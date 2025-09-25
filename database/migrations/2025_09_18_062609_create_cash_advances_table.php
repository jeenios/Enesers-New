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
        Schema::create('cash_advances', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Completed', 'Pending'])->nullable()->default('Completed');
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete()->nullable();
            $table->string('warehouse_type')->nullable();
            $table->foreignId('business_unit_id')->nullable()->constrained('business_units')->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects')->cascadeOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->cascadeOnDelete();
            $table->string('purpose')->nullable();
            $table->string('reference')->nullable();
            $table->string('description')->nullable();
            $table->string('required_at')->nullable();
            $table->string('due_at')->nullable();
            $table->string('transaction_at')->nullable();
            $table->json('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_advances');
    }
};
