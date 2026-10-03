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
        Schema::create('organization_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banom_id')->nullable()->constrained('banoms')->nullOnDelete();
            $table->string('kategori_hierarki', 30)->default('syuriyah'); // mustasyar, syuriyah, tanfidziyah, lembaga, banom
            $table->string('nama');
            $table->string('jabatan');
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
            $table->string('status', 20)->default('Aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_structures');
    }
};
