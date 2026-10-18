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
        Schema::create('banom_officers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banom_id')->constrained('banoms')->cascadeOnDelete();
            $table->foreignId('position_id')->constrained('positions')->restrictOnDelete();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('nama');
            $table->string('bidang')->nullable();
            $table->string('foto')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes for fast lookup (without unique constraint on banom_id + position_id)
            $table->index('banom_id');
            $table->index('position_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banom_officers');
    }
};
