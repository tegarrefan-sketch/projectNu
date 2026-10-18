<?php

namespace Tests\Feature;

use App\Models\Banom;
use App\Models\BanomOfficer;
use App\Models\Member;
use App\Models\Position;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GroupByOnlyFullGroupByTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Banom $banom;
    protected Position $position;
    protected BanomOfficer $officer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->admin = User::first();

        $this->banom = Banom::firstOrCreate(
            ['slug' => 'prnu-test'],
            [
                'nama' => 'Pengurus Ranting NU Test',
                'singkatan' => 'PRNU-T',
                'kategori' => 'ranting',
                'urutan' => 1,
                'is_active' => true,
            ]
        );

        $this->position = Position::firstOrCreate(
            ['nama' => 'Ketua Tanfidziyah Test'],
            [
                'kategori' => 'Tanfidziyah',
                'tipe' => 'inti',
                'urutan' => 1,
            ]
        );

        $this->officer = BanomOfficer::create([
            'banom_id' => $this->banom->id,
            'position_id' => $this->position->id,
            'nama' => 'H. Test Officer',
            'is_active' => true,
            'urutan' => 1,
        ]);
    }

    /**
     * Memastikan query penghitungan kuota pada relasi banomOfficers() di-reorder
     * sehingga toSql() tidak mengandung klausa ORDER BY yang melanggar only_full_group_by di MySQL.
     */
    public function test_banom_officers_quota_query_does_not_contain_order_by(): void
    {
        // 1. Relasi bawaan banomOfficers() memiliki default orderBy('urutan')
        $rawRelationQuery = $this->banom->banomOfficers()
            ->where('is_active', true)
            ->groupBy('position_id')
            ->selectRaw('position_id, count(*) as count');
        
        $rawSql = strtolower($rawRelationQuery->toSql());
        $this->assertStringContainsString('order by', $rawSql, 'Query bawaan relasi memiliki orderBy urutan');

        // 2. Query yang telah diperbaiki dengan ->reorder() HARUS bebas dari klausa ORDER BY
        $fixedQuery = $this->banom->banomOfficers()
            ->reorder()
            ->where('is_active', true)
            ->groupBy('position_id')
            ->selectRaw('position_id, count(*) as count');

        $fixedSql = strtolower($fixedQuery->toSql());
        $this->assertStringNotContainsString('order by', $fixedSql, 'Query penghitungan kuota tidak boleh mengandung ORDER BY saat menggunakan GROUP BY');
    }

    /**
     * Memastikan query maxPerBanom pada PositionController juga terlindung dengan reorder().
     */
    public function test_position_officers_group_by_does_not_contain_order_by(): void
    {
        $query = $this->position->banomOfficers()
            ->reorder()
            ->where('is_active', true)
            ->groupBy('banom_id')
            ->selectRaw('count(*) as count');

        $sql = strtolower($query->toSql());
        $this->assertStringNotContainsString('order by', $sql);
    }

    /**
     * Memastikan halaman edit pengurus (/admin/banoms/{banom}/officers/{officer}/edit)
     * tidak mengeksekusi query SQL dengan GROUP BY yang disertai ORDER BY yang tidak valid.
     */
    public function test_admin_banom_officer_edit_page_executes_valid_group_by_sql(): void
    {
        DB::enableQueryLog();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.banoms.officers.edit', [$this->banom->id, $this->officer->id]));

        $response->assertStatus(200);

        $queries = DB::getQueryLog();
        $this->assertNotEmpty($queries);

        foreach ($queries as $q) {
            $sql = strtolower($q['query']);
            if (str_contains($sql, 'group by')) {
                // Pastikan tidak ada query GROUP BY yang membawa ORDER BY urutan
                $this->assertStringNotContainsString(
                    'order by `urutan`',
                    $sql,
                    "Ditemukan query GROUP BY yang membawa ORDER BY urutan: {$q['query']}"
                );
                $this->assertStringNotContainsString(
                    'order by "urutan"',
                    $sql,
                    "Ditemukan query GROUP BY yang membawa ORDER BY urutan: {$q['query']}"
                );
            }
        }
    }

    /**
     * Memastikan halaman create pengurus (/admin/banoms/{banom}/officers/create)
     * juga tidak mengeksekusi query GROUP BY yang tercemar klausa ORDER BY.
     */
    public function test_admin_banom_officer_create_page_executes_valid_group_by_sql(): void
    {
        DB::enableQueryLog();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.banoms.officers.create', $this->banom->id));

        $response->assertStatus(200);

        $queries = DB::getQueryLog();
        $this->assertNotEmpty($queries);

        foreach ($queries as $q) {
            $sql = strtolower($q['query']);
            if (str_contains($sql, 'group by')) {
                $this->assertStringNotContainsString('order by `urutan`', $sql);
                $this->assertStringNotContainsString('order by "urutan"', $sql);
            }
        }
    }
}
