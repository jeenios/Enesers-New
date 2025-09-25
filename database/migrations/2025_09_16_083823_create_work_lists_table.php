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
        Schema::create('work_lists', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('state', ['Completed', 'Pending'])->nullable()->default('Completed');
            $table->string('permintaan')->nullable();
            $table->foreignId('hospital_id')->nullable()->constrained('hospitals')->cascadeOnDelete();
            $table->date('tgl_instalasi')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->foreignId('item_category_id')->nullable()->constrained('item_categories')->cascadeOnDelete();
            $table->string('no_seri')->nullable();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('partner_id')->nullable()->constrained('partners')->cascadeOnDelete();
            $table->string('penanggung_jawab')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->json('kondisi_alat')->nullable();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_lists');
    }
};
