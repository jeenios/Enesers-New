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
        Schema::create('manufacture_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Completed', 'Pending'])->nullable()->default('Pending');
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->foreignId('item_category_id')->nullable()->constrained('item_categories')->cascadeOnDelete();
            $table->string('manufacture_quantity');
            $table->foreignId('unit_id')->nullable()->constrained('units')->cascadeOnDelete();
            $table->foreignId('bill_of_material_id')
                ->nullable()
                ->constrained('bill_of_materials')
                ->cascadeOnDelete();
            $table->foreignId('project_category_id')->nullable()->constrained('project_categories')->cascadeOnDelete();
            $table->foreignId('partner_id')->nullable()->constrained('partners')->cascadeOnDelete()->nullable();
            $table->foreignId('bussiness_unit_id')->nullable()->constrained('business_units')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->string('transaction_at')->nullable();
            $table->string('due_at')->nullable();
            $table->json('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacture_orders');
    }
};
