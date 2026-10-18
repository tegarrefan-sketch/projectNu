<?php

use App\Models\Banom;
use App\Models\BanomOfficer;
use App\Models\OrganizationStructure;
use App\Models\Position;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $prnu = Banom::where('slug', 'prnu')->first();
        if (!$prnu) {
            return;
        }

        $structures = OrganizationStructure::where('status', 'Aktif')
            ->whereIn('kategori_hierarki', ['mustasyar', 'syuriyah', 'tanfidziyah'])
            ->get();

        foreach ($structures as $st) {
            $position = null;
            $jabatanLower = strtolower($st->jabatan);

            if ($st->kategori_hierarki === 'mustasyar') {
                $position = Position::where('nama', 'Mustasyar')->where('kategori', 'Mustasyar')->first();
            } elseif ($st->kategori_hierarki === 'syuriyah') {
                if (str_contains($jabatanLower, 'wakil rais')) {
                    $position = Position::where('nama', 'Wakil Rais')->where('kategori', 'Syuriyah')->first();
                } elseif (str_contains($jabatanLower, 'rais')) {
                    $position = Position::where('nama', 'Rais')->where('kategori', 'Syuriyah')->first();
                } elseif (str_contains($jabatanLower, 'wakil katib')) {
                    $position = Position::where('nama', 'Wakil Katib')->where('kategori', 'Syuriyah')->first();
                } elseif (str_contains($jabatanLower, 'katib')) {
                    $position = Position::where('nama', 'Katib')->where('kategori', 'Syuriyah')->first();
                } elseif (str_contains($jabatanLower, "a'wan") || str_contains($jabatanLower, 'awan')) {
                    $position = Position::where('nama', "A'wan")->where('kategori', 'Syuriyah')->first();
                }
            } elseif ($st->kategori_hierarki === 'tanfidziyah') {
                if (str_contains($jabatanLower, 'wakil ketua')) {
                    $position = Position::where('nama', 'Wakil Ketua')->where('kategori', 'Tanfidziyah')->first();
                } elseif (str_contains($jabatanLower, 'ketua')) {
                    $position = Position::where('nama', 'Ketua')->where('kategori', 'Tanfidziyah')->first();
                } elseif (str_contains($jabatanLower, 'wakil sekretaris')) {
                    $position = Position::where('nama', 'Wakil Sekretaris')->where('kategori', 'Tanfidziyah')->first();
                } elseif (str_contains($jabatanLower, 'sekretaris')) {
                    $position = Position::where('nama', 'Sekretaris')->where('kategori', 'Tanfidziyah')->first();
                } elseif (str_contains($jabatanLower, 'wakil bendahara')) {
                    $position = Position::where('nama', 'Wakil Bendahara')->where('kategori', 'Tanfidziyah')->first();
                } elseif (str_contains($jabatanLower, 'bendahara')) {
                    $position = Position::where('nama', 'Bendahara')->where('kategori', 'Tanfidziyah')->first();
                }
            }

            if (!$position) {
                // Fallback position
                $position = Position::where('kategori', ucfirst($st->kategori_hierarki))->first();
            }

            if ($position) {
                BanomOfficer::firstOrCreate(
                    [
                        'banom_id' => $prnu->id,
                        'nama' => $st->nama,
                    ],
                    [
                        'position_id' => $position->id,
                        'foto' => $st->foto,
                        'urutan' => $st->urutan ?: 0,
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe to keep migrated data
    }
};
