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
        Schema::create('banoms', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('singkatan', 30)->unique();
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->text('deskripsi')->nullable();
            $table->longText('sejarah')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('kontak')->nullable();
            $table->string('alamat')->nullable();
            $table->string('status', 20)->default('Aktif');
            $table->string('warna_primer', 20)->nullable();
            $table->string('warna_sekunder', 20)->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banoms');
    }
};
