<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update banoms table
        Schema::table('banoms', function (Blueprint $table) {
            if (!Schema::hasColumn('banoms', 'kategori')) {
                $table->string('kategori', 30)->default('banom')->after('slug');
            }
            if (!Schema::hasColumn('banoms', 'rentang_usia')) {
                $table->string('rentang_usia', 100)->nullable()->after('kategori');
            }
            if (!Schema::hasColumn('banoms', 'label_bagian')) {
                $table->string('label_bagian', 50)->default('Bidang')->after('rentang_usia');
            }
        });

        // 2. Update positions table
        // Change enum kategori to VARCHAR(50) safely
        try {
            DB::statement("ALTER TABLE `positions` MODIFY `kategori` VARCHAR(50) NOT NULL DEFAULT 'Banom'");
        } catch (\Throwable $e) {
            // fallback if already varchar or non-mysql
        }

        Schema::table('positions', function (Blueprint $table) {
            if (!Schema::hasColumn('positions', 'tipe')) {
                $table->enum('tipe', ['inti', 'wakil', 'anggota'])->default('inti')->after('kategori');
            }
            if (!Schema::hasColumn('positions', 'batas_keras')) {
                $table->boolean('batas_keras')->default(false)->after('maks_orang');
            }
            if (!Schema::hasColumn('positions', 'anjuran_maks')) {
                $table->unsignedInteger('anjuran_maks')->nullable()->after('batas_keras');
            }
            if (!Schema::hasColumn('positions', 'urutan_hierarki')) {
                $table->integer('urutan_hierarki')->default(0)->after('urutan');
            }
            if (!Schema::hasColumn('positions', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('urutan_hierarki');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'batas_keras', 'anjuran_maks', 'urutan_hierarki', 'keterangan']);
        });

        Schema::table('banoms', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'rentang_usia', 'label_bagian']);
        });
    }
};
