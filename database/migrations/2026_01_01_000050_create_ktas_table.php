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
        Schema::create('ktas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->unique()->constrained('members')->cascadeOnDelete();
            $table->string('nomor_kta')->unique();
            $table->date('tanggal_terbit');
            $table->date('tanggal_berlaku');
            $table->string('status', 20)->default('Aktif'); // Aktif, Tidak Aktif, Kadaluarsa
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->longText('qr_code_svg')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ktas');
    }
};
