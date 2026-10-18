<?php

namespace Tests\Feature;

use App\Models\Banom;
use App\Models\Position;
use App\Models\BanomOfficer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BanomPyramidHierarchyTest extends TestCase
{
    use RefreshDatabase;

    public function test_banom_show_renders_pyramid_hierarchy_with_dynamic_data(): void
    {
        $banom = Banom::create([
            'nama' => 'Pimpinan Ranting Gerakan Pemuda Ansor',
            'singkatan' => 'GP Ansor',
            'slug' => 'ansor-test',
            'kategori' => 'banom',
            'status' => 'Aktif',
            'warna_primer' => '#005429',
            'urutan' => 1,
            'is_active' => true,
        ]);

        $posKetua = Position::create([
            'nama' => 'Ketua',
            'kategori' => 'Banom',
            'tipe' => 'inti',
            'urutan' => 1,
            'urutan_hierarki' => 1,
        ]);

        $posWakil = Position::create([
            'nama' => 'Wakil Ketua',
            'kategori' => 'Banom',
            'tipe' => 'wakil',
            'urutan' => 2,
            'urutan_hierarki' => 2,
        ]);

        $posSekretaris = Position::create([
            'nama' => 'Sekretaris',
            'kategori' => 'Banom',
            'tipe' => 'inti',
            'urutan' => 3,
            'urutan_hierarki' => 3,
        ]);

        $posBidang = Position::create([
            'nama' => 'Ketua Bidang',
            'kategori' => 'Bidang',
            'tipe' => 'inti',
            'urutan' => 4,
            'urutan_hierarki' => 4,
        ]);

        BanomOfficer::create([
            'banom_id' => $banom->id,
            'position_id' => $posKetua->id,
            'nama' => 'H. Pimpinan Puncak Ansor',
            'is_active' => true,
            'urutan' => 1,
        ]);

        BanomOfficer::create([
            'banom_id' => $banom->id,
            'position_id' => $posWakil->id,
            'nama' => 'Wakil Pimpinan Ansor',
            'is_active' => true,
            'urutan' => 1,
        ]);

        BanomOfficer::create([
            'banom_id' => $banom->id,
            'position_id' => $posSekretaris->id,
            'nama' => 'Sekretaris Ansor',
            'is_active' => true,
            'urutan' => 1,
        ]);

        BanomOfficer::create([
            'banom_id' => $banom->id,
            'position_id' => $posBidang->id,
            'nama' => 'Koordinator Bidang Kaderisasi',
            'bidang' => 'Kaderisasi',
            'is_active' => true,
            'urutan' => 1,
        ]);

        $response = $this->get(route('banom.show', $banom->slug));

        $response->assertStatus(200);
        $response->assertSee('Puncak Hierarki • Pimpinan Tertinggi');
        $response->assertSee('H. Pimpinan Puncak Ansor');
        $response->assertSee('Level II • Wakil Pimpinan');
        $response->assertSee('Wakil Pimpinan Ansor');
        $response->assertSee('Level III • Sekretariat & Kebendaharaan', false);
        $response->assertSee('Sekretaris Ansor');
        $response->assertSee('Level IV • Bidang, Departemen & Divisi', false);
        $response->assertSee('Koordinator Bidang Kaderisasi');
    }
}
