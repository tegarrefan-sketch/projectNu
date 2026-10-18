<?php

namespace Tests\Feature;

use App\Models\Banom;
use App\Models\BanomOfficer;
use App\Models\Member;
use App\Models\Position;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionAndOfficerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->admin = User::first();
    }

    /**
     * Test validasi maks_orang: menolak jika jumlah pengurus aktif telah mencapai kuota maks_orang.
     */
    public function test_validasi_maks_orang_menolak_pengurus_melebihi_kuota(): void
    {
        $banom = Banom::firstOrCreate(
            ['slug' => 'test-banom-kuota'],
            [
                'nama' => 'Test Banom Kuota',
                'singkatan' => 'TBK',
                'deskripsi' => 'Deskripsi test',
                'urutan' => 99,
                'is_active' => true,
            ]
        );

        $position = Position::create([
            'nama' => 'Ketua Utama Test',
            'kategori' => 'Banom',
            'maks_orang' => 1,
            'urutan' => 1,
        ]);

        // Simpan pengurus aktif pertama (kuota 1 tercapai)
        BanomOfficer::create([
            'banom_id' => $banom->id,
            'position_id' => $position->id,
            'nama' => 'Ahmad Pengurus Pertama',
            'is_active' => true,
            'urutan' => 1,
        ]);

        // Percobaan mendaftarkan pengurus aktif kedua pada jabatan yang sama harus ditolak
        $response = $this->actingAs($this->admin)->post(route('admin.banoms.officers.store', $banom), [
            'position_id' => $position->id,
            'nama' => 'Budi Pengurus Kedua',
            'is_active' => 1,
            'urutan' => 2,
        ]);

        $response->assertSessionHasErrors('position_id');
        $this->assertDatabaseMissing('banom_officers', [
            'nama' => 'Budi Pengurus Kedua',
        ]);

        // Namun pengurus dengan status TIDAK AKTIF tetap diperbolehkan atau jika diedit record yang sama
        $inactiveResponse = $this->actingAs($this->admin)->post(route('admin.banoms.officers.store', $banom), [
            'position_id' => $position->id,
            'nama' => 'Calon Pengurus Nonaktif',
            'is_active' => 0,
            'urutan' => 3,
        ]);

        $inactiveResponse->assertSessionHasNoErrors();
        $this->assertDatabaseHas('banom_officers', [
            'nama' => 'Calon Pengurus Nonaktif',
            'is_active' => 0,
        ]);
    }

    /**
     * Test penolakan penghapusan jabatan yang sedang dipakai oleh pengurus.
     */
    public function test_penolakan_hapus_jabatan_yang_sedang_dipakai(): void
    {
        $banom = Banom::first();
        $position = Position::create([
            'nama' => 'Jabatan Dipakai Test',
            'kategori' => 'Banom',
            'maks_orang' => 5,
            'urutan' => 10,
        ]);

        $officer = BanomOfficer::create([
            'banom_id' => $banom->id,
            'position_id' => $position->id,
            'nama' => 'Pengurus Uji Hapus',
            'is_active' => true,
            'urutan' => 1,
        ]);

        // Coba hapus jabatan yang masih memiliki relasi ke banom_officers
        $response = $this->actingAs($this->admin)->delete(route('admin.positions.destroy', $position));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('positions', [
            'id' => $position->id,
            'nama' => 'Jabatan Dipakai Test',
        ]);

        // Hapus pengurus terlebih dahulu
        $officer->delete();

        // Sekarang jabatan dapat dihapus dengan sukses
        $deleteSuccessResponse = $this->actingAs($this->admin)->delete(route('admin.positions.destroy', $position));
        $deleteSuccessResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('positions', [
            'id' => $position->id,
        ]);
    }

    /**
     * Test pembuatan beberapa pengurus pada jabatan yang sama (tanpa unique constraint).
     */
    public function test_pembuatan_beberapa_pengurus_pada_jabatan_yang_sama(): void
    {
        $banom = Banom::first();
        $position = Position::create([
            'nama' => 'Wakil Ketua Multi',
            'kategori' => 'Banom',
            'maks_orang' => 5,
            'urutan' => 2,
        ]);

        // Pengurus 1
        $response1 = $this->actingAs($this->admin)->post(route('admin.banoms.officers.store', $banom), [
            'position_id' => $position->id,
            'nama' => 'Pengurus Multi Satu',
            'is_active' => 1,
            'urutan' => 1,
        ]);
        $response1->assertSessionHasNoErrors();

        // Pengurus 2
        $response2 = $this->actingAs($this->admin)->post(route('admin.banoms.officers.store', $banom), [
            'position_id' => $position->id,
            'nama' => 'Pengurus Multi Dua',
            'is_active' => 1,
            'urutan' => 2,
        ]);
        $response2->assertSessionHasNoErrors();

        $this->assertDatabaseHas('banom_officers', [
            'banom_id' => $banom->id,
            'position_id' => $position->id,
            'nama' => 'Pengurus Multi Satu',
        ]);

        $this->assertDatabaseHas('banom_officers', [
            'banom_id' => $banom->id,
            'position_id' => $position->id,
            'nama' => 'Pengurus Multi Dua',
        ]);

        $count = BanomOfficer::where('banom_id', $banom->id)
            ->where('position_id', $position->id)
            ->count();

        $this->assertSame(2, $count);
    }

    /**
     * Test pencegahan duplikasi anggota: satu anggota tidak boleh didaftarkan dua kali pada jabatan dan banom yang sama.
     */
    public function test_mencegah_duplikasi_anggota_pada_jabatan_dan_banom_yang_sama(): void
    {
        $banom = Banom::first();
        $member = Member::first();
        $this->assertNotNull($member);

        $position = Position::create([
            'nama' => 'Penasihat Khusus',
            'kategori' => 'Banom',
            'maks_orang' => 10,
            'urutan' => 3,
        ]);

        // Daftarkan anggota pertama kali
        $response1 = $this->actingAs($this->admin)->post(route('admin.banoms.officers.store', $banom), [
            'position_id' => $position->id,
            'member_id' => $member->id,
            'is_active' => 1,
            'urutan' => 1,
        ]);
        $response1->assertSessionHasNoErrors();

        // Coba daftarkan anggota yang sama pada jabatan dan banom yang sama
        $response2 = $this->actingAs($this->admin)->post(route('admin.banoms.officers.store', $banom), [
            'position_id' => $position->id,
            'member_id' => $member->id,
            'is_active' => 1,
            'urutan' => 2,
        ]);

        $response2->assertSessionHasErrors('member_id');
    }

    /**
     * Test validasi maks_orang tetap aktif meskipun route dipanggil menggunakan slug banom.
     */
    public function test_validasi_maks_orang_ketua_juga_bekerja_dengan_parameter_slug_banom(): void
    {
        $banom = Banom::first();
        $posKetua = Position::where('nama', 'Ketua')->first();
        $this->assertNotNull($posKetua);

        // Pastikan sudah ada 1 ketua aktif di banom ini
        BanomOfficer::firstOrCreate(
            ['banom_id' => $banom->id, 'position_id' => $posKetua->id],
            ['nama' => 'Ketua Utama Aktif', 'is_active' => true, 'urutan' => 1]
        );

        // Akses via slug banom: /admin/banoms/{slug}/officers
        $response = $this->actingAs($this->admin)->post("/admin/banoms/{$banom->slug}/officers", [
            'position_id' => $posKetua->id,
            'nama' => 'Calon Ketua Kedua Ilegal',
            'is_active' => 1,
            'urutan' => 2,
        ]);

        $response->assertSessionHasErrors('position_id');
        $this->assertDatabaseMissing('banom_officers', [
            'banom_id' => $banom->id,
            'nama' => 'Calon Ketua Kedua Ilegal',
        ]);
    }

    /**
     * Test mencegah pembuatan duplikasi nama jabatan dalam satu kategori di Master Jabatan.
     */
    public function test_mencegah_duplikasi_nama_jabatan_di_master_jabatan(): void
    {
        // Posisi 'Ketua' dengan kategori 'Tanfidziyah' sudah ada dari seeder
        $response = $this->actingAs($this->admin)->post(route('admin.positions.store'), [
            'nama' => 'Ketua',
            'kategori' => 'Tanfidziyah',
            'maks_orang' => 1,
            'urutan' => 99,
        ]);

        $response->assertSessionHasErrors('nama');
    }

    /**
     * Test pergantian ketua dengan opsi replace_current: menonaktifkan ketua lama dan mengaktifkan ketua baru.
     */
    public function test_pergantian_ketua_dengan_replace_current(): void
    {
        $banom = Banom::first();
        $position = Position::where('nama', 'Ketua')->first();

        // Pastikan ada ketua lama yang aktif
        $ketuaLama = BanomOfficer::updateOrCreate(
            ['banom_id' => $banom->id, 'position_id' => $position->id],
            ['nama' => 'Ketua Lama', 'is_active' => true, 'urutan' => 1]
        );

        // Tambah ketua baru dengan replace_current = 1
        $response = $this->actingAs($this->admin)->post(route('admin.banoms.officers.store', $banom), [
            'position_id' => $position->id,
            'nama' => 'Ketua Baru Terpilih',
            'is_active' => 1,
            'replace_current' => 1,
            'urutan' => 1,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.banoms.officers.index', $banom->id));

        // Ketua lama harus menjadi tidak aktif
        $this->assertDatabaseHas('banom_officers', [
            'id' => $ketuaLama->id,
            'is_active' => false,
        ]);

        // Ketua baru harus aktif
        $this->assertDatabaseHas('banom_officers', [
            'banom_id' => $banom->id,
            'position_id' => $position->id,
            'nama' => 'Ketua Baru Terpilih',
            'is_active' => true,
        ]);

        // Jumlah ketua aktif di banom ini HARUS tepat 1
        $activeKetuaCount = BanomOfficer::where('banom_id', $banom->id)
            ->where('position_id', $position->id)
            ->where('is_active', true)
            ->count();
        $this->assertEquals(1, $activeKetuaCount);
    }

    /**
     * Test generate nomor anggota tidak tabrakan dengan anggota yang sudah di-soft-delete.
     */
    public function test_generate_nomor_anggota_bebas_tabrakan_soft_delete(): void
    {
        $banom = Banom::first();

        // Buat member lalu hapus (soft delete)
        $member1 = Member::create([
            'banom_id' => $banom->id,
            'nomor_anggota' => 'NIA-' . strtoupper($banom->singkatan) . '-2026-9999',
            'nama_lengkap' => 'Member Dihapus',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
            'jabatan' => 'Anggota',
            'tahun_masuk' => 2026,
        ]);
        $member1->delete();

        // Generate nomor berikutnya
        $newNumber = Member::generateMemberNumber($banom, 2026);
        $this->assertNotEquals('NIA-' . strtoupper($banom->singkatan) . '-2026-9999', $newNumber);

        // Simpan member baru lewat endpoint admin.anggota.store tanpa nomor_anggota (auto-generate)
        $response = $this->actingAs($this->admin)->post(route('admin.anggota.store'), [
            'banom_id' => $banom->id,
            'nama_lengkap' => 'Member Baru Sukses',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
            'jabatan' => 'Ketua Ranting',
            'tahun_masuk' => 2026,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('members', [
            'nama_lengkap' => 'Member Baru Sukses',
        ]);
    }
}
