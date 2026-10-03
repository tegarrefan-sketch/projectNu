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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_organisasi')->default('Nahdlatul Ulama Ranting Banjaranyar');
            $table->string('tingkat')->default('Desa / Ranting');
            $table->string('kecamatan')->default('Baureno');
            $table->string('kabupaten')->default('Bojonegoro');
            $table->string('provinsi')->default('Jawa Timur');
            $table->text('deskripsi_singkat')->nullable();
            $table->longText('sejarah')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('nilai_organisasi')->nullable();
            $table->string('alamat')->default('Jl. Raya Banjaranyar, Kec. Baureno, Kab. Bojonegoro, Jawa Timur 62192');
            $table->string('kontak_email')->default('sekretariat@nu-banjaranyar.or.id');
            $table->string('kontak_telepon')->default('+62 812-3456-7890');
            $table->string('sk_nomor')->default('184/A.II/PC/SK/VIII/2023');
            $table->string('masa_khidmat')->default('2023 - 2028');
            $table->string('logo')->nullable();
            $table->string('hero_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
