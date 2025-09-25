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
        Schema::create('work_list_multiples', function (Blueprint $table) {
            $table->id();
            $table->string('work_list_id')->nullable()->constrained('work_lists')->cascadeOnDelete();
            $table->string('item_id')->nullable()->constrained('items')->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->string('unit_id')->nullable()->constrained('units')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_list_multiples');
    }
};
