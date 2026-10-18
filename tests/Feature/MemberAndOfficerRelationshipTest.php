<?php

namespace Tests\Feature;

use App\Models\Banom;
use App\Models\BanomOfficer;
use App\Models\Kta;
use App\Models\Member;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberAndOfficerRelationshipTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Banom $banomIpnu;
    protected Position $posKetua;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::first() ?? User::factory()->create();
        $this->banomIpnu = Banom::where('singkatan', 'IPNU')->firstOrFail();
        $this->posKetua = Position::where('nama', 'Ketua')
            ->where('kategori', 'Banom')
            ->firstOrFail();
    }

    /**
     * 1. Anggota non-pengurus tampil di KTA dengan status keanggotaan
     */
    public function test_non_officer_member_shows_status_keanggotaan_on_kta(): void
    {
        $member = Member::create([
            'banom_id' => $this->banomIpnu->id,
            'nomor_anggota' => 'NIA-IPNU-2026-9901',
            'nama_lengkap' => 'Muhammad Zaidan',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
            'status_keanggotaan' => 'Kader',
            'tahun_masuk' => 2024,
        ]);

        $kta = Kta::create([
            'member_id' => $member->id,
            'nomor_kta' => 'IPNU-2026-99001',
            'tanggal_terbit' => now()->toDateString(),
            'tanggal_berlaku' => now()->addYears(3)->toDateString(),
            'status' => 'Aktif',
        ]);

        // Accessor check
        $this->assertEquals('Kader', $member->jabatan_kta);
        $this->assertEquals('Kader', $member->jabatan);

        // KTA show page check
        $responseShow = $this->actingAs($this->admin)->get(route('admin.kta.show', $kta->id));
        $responseShow->assertStatus(200);
        $responseShow->assertSee('Kader');

        // KTA print page check
        $responsePrint = $this->actingAs($this->admin)->get(route('admin.kta.print', $kta->id));
        $responsePrint->assertStatus(200);
        $responsePrint->assertSee('Kader');
    }

    /**
     * 2. Anggota yang menjadi Ketua tampil "Ketua - PR IPNU" (mengandung "Ketua") di KTA
     */
    public function test_member_who_becomes_ketua_shows_ketua_on_kta(): void
    {
        $member = Member::create([
            'banom_id' => $this->banomIpnu->id,
            'nomor_anggota' => 'NIA-IPNU-2026-9902',
            'nama_lengkap' => 'Achmad Choirul',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
            'status_keanggotaan' => 'Kader',
            'tahun_masuk' => 2024,
        ]);

        $kta = Kta::create([
            'member_id' => $member->id,
            'nomor_kta' => 'IPNU-2026-99002',
            'tanggal_terbit' => now()->toDateString(),
            'tanggal_berlaku' => now()->addYears(3)->toDateString(),
            'status' => 'Aktif',
        ]);

        // Assign sebagai pengurus aktif Ketua IPNU
        $officer = BanomOfficer::create([
            'banom_id' => $this->banomIpnu->id,
            'position_id' => $this->posKetua->id,
            'member_id' => $member->id,
            'nama' => $member->nama_lengkap,
            'is_active' => true,
            'urutan' => 1,
        ]);

        $member = $member->fresh();
        $this->assertEquals('Ketua - PR IPNU', $member->jabatan_kta);
        $this->assertStringContainsString('Ketua', $member->jabatan_kta);

        // KTA show & print view check
        $responseShow = $this->actingAs($this->admin)->get(route('admin.kta.show', $kta->id));
        $responseShow->assertStatus(200);
        $responseShow->assertSee('Ketua - PR IPNU');

        $responsePrint = $this->actingAs($this->admin)->get(route('admin.kta.print', $kta->id));
        $responsePrint->assertStatus(200);
        $responsePrint->assertSee('Ketua - PR IPNU');
    }

    /**
     * 3. Setelah pengurus dinonaktifkan, KTA kembali ke status keanggotaan
     */
    public function test_deactivated_officer_reverts_kta_back_to_status_keanggotaan(): void
    {
        $member = Member::create([
            'banom_id' => $this->banomIpnu->id,
            'nomor_anggota' => 'NIA-IPNU-2026-9903',
            'nama_lengkap' => 'Farhan Maulana',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
            'status_keanggotaan' => 'Anggota',
            'tahun_masuk' => 2023,
        ]);

        $kta = Kta::create([
            'member_id' => $member->id,
            'nomor_kta' => 'IPNU-2026-99003',
            'tanggal_terbit' => now()->toDateString(),
            'tanggal_berlaku' => now()->addYears(3)->toDateString(),
            'status' => 'Aktif',
        ]);

        $officer = BanomOfficer::create([
            'banom_id' => $this->banomIpnu->id,
            'position_id' => $this->posKetua->id,
            'member_id' => $member->id,
            'nama' => $member->nama_lengkap,
            'is_active' => true,
            'urutan' => 1,
        ]);

        $this->assertEquals('Ketua - PR IPNU', $member->fresh()->jabatan_kta);

        // Nonaktifkan jabatan pengurus
        $officer->update(['is_active' => false]);

        $member = $member->fresh();
        $this->assertEquals('Anggota', $member->jabatan_kta);

        $responseShow = $this->actingAs($this->admin)->get(route('admin.kta.show', $kta->id));
        $responseShow->assertStatus(200);
        $responseShow->assertSee('Anggota');
        $responseShow->assertDontSee('Ketua - PR IPNU');
    }

    /**
     * 4. Badge Pengurus dan tombol "Jadikan Pengurus" di halaman daftar & detail anggota
     */
    public function test_member_index_and_show_badge_and_button(): void
    {
        // Anggota 1: non-pengurus
        $memberNonPengurus = Member::create([
            'banom_id' => $this->banomIpnu->id,
            'nomor_anggota' => 'NIA-IPNU-2026-9904',
            'nama_lengkap' => 'Budi Non Pengurus',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
            'status_keanggotaan' => 'Simpatisan',
        ]);

        // Anggota 2: pengurus aktif
        $memberPengurus = Member::create([
            'banom_id' => $this->banomIpnu->id,
            'nomor_anggota' => 'NIA-IPNU-2026-9905',
            'nama_lengkap' => 'Hadi Pengurus Aktif',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
            'status_keanggotaan' => 'Kader',
        ]);

        BanomOfficer::create([
            'banom_id' => $this->banomIpnu->id,
            'position_id' => $this->posKetua->id,
            'member_id' => $memberPengurus->id,
            'nama' => $memberPengurus->nama_lengkap,
            'is_active' => true,
            'urutan' => 1,
        ]);

        // Index page check
        $responseIndex = $this->actingAs($this->admin)->get(route('admin.anggota.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('Jadikan Pengurus');
        $responseIndex->assertSee('Pengurus: Ketua');

        // Detail page non-pengurus
        $responseShowNon = $this->actingAs($this->admin)->get(route('admin.anggota.show', $memberNonPengurus->id));
        $responseShowNon->assertStatus(200);
        $responseShowNon->assertSee('Jadikan Pengurus');

        // Detail page pengurus
        $responseShowPengurus = $this->actingAs($this->admin)->get(route('admin.anggota.show', $memberPengurus->id));
        $responseShowPengurus->assertStatus(200);
        $responseShowPengurus->assertSee('Pengurus: Ketua (IPNU)');
    }

    /**
     * 5. Form anggota menggunakan dropdown Status Keanggotaan dan tidak mewajibkan teks bebas jabatan
     */
    public function test_member_store_and_update_with_status_keanggotaan(): void
    {
        $responseStore = $this->actingAs($this->admin)->post(route('admin.anggota.store'), [
            'banom_id' => $this->banomIpnu->id,
            'nama_lengkap' => 'Kader Baru Test',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
            'status_keanggotaan' => 'Simpatisan',
            'tahun_masuk' => 2025,
        ]);

        $responseStore->assertRedirect(route('admin.anggota.index'));

        $newMember = Member::where('nama_lengkap', 'Kader Baru Test')->first();
        $this->assertNotNull($newMember);
        $this->assertEquals('Simpatisan', $newMember->status_keanggotaan);

        // Update ke Kader
        $responseUpdate = $this->actingAs($this->admin)->put(route('admin.anggota.update', $newMember->id), [
            'banom_id' => $this->banomIpnu->id,
            'nomor_anggota' => $newMember->nomor_anggota,
            'nama_lengkap' => 'Kader Baru Test Diperbarui',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
            'status_keanggotaan' => 'Kader',
            'tahun_masuk' => 2025,
        ]);

        $responseUpdate->assertRedirect(route('admin.anggota.index'));
        $this->assertEquals('Kader', $newMember->fresh()->status_keanggotaan);
    }

    /**
     * 6. Teks bantuan singkat di bagian atas menu Anggota dan menu Pengurus
     */
    public function test_helper_texts_in_member_and_officer_menus(): void
    {
        $responseMember = $this->actingAs($this->admin)->get(route('admin.anggota.index'));
        $responseMember->assertStatus(200);
        $responseMember->assertSee('Buku induk warga dan kader, tanpa batas jumlah');

        $responseOfficer = $this->actingAs($this->admin)->get(route('admin.banoms.officers.index', $this->banomIpnu->id));
        $responseOfficer->assertStatus(200);
        $responseOfficer->assertSee('Susunan resmi organisasi dan jabatan');
    }
}
