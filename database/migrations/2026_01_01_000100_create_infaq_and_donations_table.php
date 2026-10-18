<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('infaq_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program')->default('Gerakan Infaq & Sedekah Koin LAZISNU Banjaranyar');
            $table->text('deskripsi_program')->nullable();
            $table->string('bank_utama_nama')->default('Bank Syariah Indonesia (BSI)');
            $table->string('bank_utama_rekening')->default('7234567890');
            $table->string('bank_utama_atas_nama')->default('PRNU BANJARANYAR - LAZISNU');
            $table->string('bank_kedua_nama')->nullable()->default('Bank Jatim');
            $table->string('bank_kedua_rekening')->nullable()->default('0123456789');
            $table->string('bank_kedua_atas_nama')->nullable()->default('UPZIS LAZISNU BANJARANYAR');
            $table->string('qris_image')->nullable();
            $table->string('nomor_whatsapp_konfirmasi')->default('081234567890');
            $table->text('pesan_amanah')->nullable();
            $table->timestamps();
        });

        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->string('nama_donatur')->default('Hamba Allah');
            $table->boolean('is_anonim')->default(false);
            $table->string('nomor_whatsapp')->nullable();
            $table->decimal('nominal', 14, 2);
            $table->string('metode_pembayaran')->default('Transfer Bank');
            $table->text('pesan_doa')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->enum('status', ['Menunggu Verifikasi', 'Terverifikasi', 'Ditolak'])->default('Menunggu Verifikasi');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
        Schema::dropIfExists('infaq_settings');
    }
};
