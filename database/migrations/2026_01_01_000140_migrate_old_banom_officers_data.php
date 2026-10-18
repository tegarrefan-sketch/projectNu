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
        // 1. Check if banoms table had legacy officer columns (e.g. ketua, sekretaris, bendahara, pembina)
        $potentialLegacyColumns = ['ketua', 'wakil_ketua', 'sekretaris', 'bendahara', 'pembina', 'penasihat'];
        $foundColumns = [];

        foreach ($potentialLegacyColumns as $col) {
            if (Schema::hasColumn('banoms', $col)) {
                $foundColumns[] = $col;
            }
        }

        if (!empty($foundColumns)) {
            // Find default positions or create them
            $banoms = DB::table('banoms')->get();
            foreach ($banoms as $banom) {
                foreach ($foundColumns as $col) {
                    $val = $banom->$col ?? null;
                    if (!empty($val)) {
                        $posName = ucwords(str_replace('_', ' ', $col));
                        $position = DB::table('positions')->where('nama', $posName)->first();
                        $positionId = $position ? $position->id : DB::table('positions')->insertGetId([
                            'nama' => $posName,
                            'kategori' => 'Banom',
                            'maks_orang' => 1,
                            'urutan' => 10,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        DB::table('banom_officers')->insert([
                            'banom_id' => $banom->id,
                            'position_id' => $positionId,
                            'nama' => $val,
                            'urutan' => 0,
                            'is_active' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // Drop old columns from banoms table
            Schema::table('banoms', function (Blueprint $table) use ($foundColumns) {
                $table->dropColumn($foundColumns);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op for legacy migration
    }
};
