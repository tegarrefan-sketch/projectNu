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
        if (!Schema::hasColumn('members', 'status_keanggotaan')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('status_keanggotaan', 30)->default('Anggota')->after('status');
            });
        }

        // Pastikan kolom jabatan nullable agar aman jika tidak diisi lagi melalui input form
        Schema::table('members', function (Blueprint $table) {
            $table->string('jabatan')->nullable()->change();
        });

        // Migrasikan data jabatan lama ke status_keanggotaan dan arsipkan ke keterangan tanpa menghapus data
        $members = DB::table('members')->get();
        foreach ($members as $m) {
            $jabatan = trim($m->jabatan ?? '');
            $statusKeanggotaan = 'Anggota';

            if (in_array(strtolower($jabatan), ['simpatisan', 'warga'])) {
                $statusKeanggotaan = 'Simpatisan';
            } elseif (in_array(strtolower($jabatan), ['kader', 'kader aktif', 'kader pratama'])) {
                $statusKeanggotaan = 'Kader';
            } elseif (!empty($jabatan) && strtolower($jabatan) !== 'anggota') {
                $statusKeanggotaan = 'Kader';
                $oldNote = $m->keterangan ?? '';
                if (!str_contains($oldNote, $jabatan)) {
                    $newNote = trim(($oldNote ? $oldNote . ' | ' : '') . "Catatan Jabatan Lama: " . $jabatan);
                    DB::table('members')->where('id', $m->id)->update([
                        'status_keanggotaan' => $statusKeanggotaan,
                        'keterangan' => $newNote,
                    ]);
                    continue;
                }
            }

            DB::table('members')->where('id', $m->id)->update([
                'status_keanggotaan' => $statusKeanggotaan,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('members', 'status_keanggotaan')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('status_keanggotaan');
            });
        }
    }
};
