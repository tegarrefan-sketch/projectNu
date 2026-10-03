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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banom_id')->constrained('banoms')->cascadeOnDelete();
            $table->string('nomor_anggota')->unique();
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin', 20)->default('Laki-laki');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nomor_telepon', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('status', 20)->default('Aktif'); // Aktif, Tidak Aktif, Alumni
            $table->string('jabatan')->default('Anggota');
            $table->year('tahun_masuk')->nullable();
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
