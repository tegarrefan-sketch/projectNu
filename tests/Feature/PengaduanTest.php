<?php

namespace Tests\Feature;

use App\Models\Aspiration;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PengaduanTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_user_can_submit_pengaduan_as_warga_umum(): void
    {
        $data = [
            'member_select' => 'bukan_anggota',
            'nama_custom' => 'Bapak Ahmad Subagyo',
            'kontak' => '081234567890',
            'kategori' => 'Pengaduan',
            'subjek' => 'Laporan Kerusakan Lampu Penerangan Musholla RT 03',
            'pesan' => 'Mohon bantuan perbaikan lampu jalan dan penerangan serambi musholla yang padam sejak 3 hari.',
        ];

        $response = $this->post(route('aspirasi.store'), $data);

        $response->assertRedirect(route('aspirasi.create'));
        $response->assertSessionHas('success');
        $response->assertSessionHas('kode_tiket');

        $this->assertDatabaseHas('aspirations', [
            'nama' => 'Bapak Ahmad Subagyo',
            'kategori' => 'Pengaduan',
            'subjek' => 'Laporan Kerusakan Lampu Penerangan Musholla RT 03',
            'status' => 'Baru',
        ]);
    }

    public function test_user_can_submit_pengaduan_as_anggota_kader(): void
    {
        $banom = \App\Models\Banom::create([
            'nama' => 'Gerakan Pemuda Ansor',
            'singkatan' => 'Ansor',
            'slug' => 'ansor-test-pengaduan',
            'kategori' => 'banom',
            'status' => 'Aktif',
            'urutan' => 1,
        ]);

        $member = Member::create([
            'banom_id' => $banom->id,
            'nama_lengkap' => 'Sahabat Lukman Hakim',
            'nomor_anggota' => '3522-2024-0012',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
        ]);

        $data = [
            'member_select' => $member->id,
            'kontak' => '08987654321',
            'kategori' => 'Pengaduan',
            'subjek' => 'Pengaduan Sosial Terkait Bantuan Dhuafa',
            'pesan' => 'Ada warga lansia sebatang kara di RT 04 yang membutuhkan santunan sembako berkala dari Lazisnu.',
        ];

        $response = $this->post(route('aspirasi.store'), $data);

        $response->assertRedirect(route('aspirasi.create'));
        $response->assertSessionHas('kode_tiket');

        $this->assertDatabaseHas('aspirations', [
            'nama' => 'Sahabat Lukman Hakim',
            'kategori' => 'Pengaduan',
            'status' => 'Baru',
        ]);
    }

    public function test_user_can_submit_pengaduan_as_anonim(): void
    {
        $data = [
            'member_select' => 'anonim',
            'kategori' => 'Pengaduan',
            'subjek' => 'Laporan Kebersihan Lingkungan Masjid',
            'pesan' => 'Perlu kerja bakti bersama warga untuk membersihkan saluran drainase samping masjid.',
        ];

        $response = $this->post(route('aspirasi.store'), $data);

        $response->assertRedirect(route('aspirasi.create'));
        $response->assertSessionHas('kode_tiket');

        $this->assertDatabaseHas('aspirations', [
            'nama' => 'Warga Banjaranyar (Anonim)',
            'kategori' => 'Pengaduan',
        ]);
    }

    public function test_pengaduan_validation_fails_when_message_too_short(): void
    {
        $data = [
            'member_select' => 'bukan_anggota',
            'kategori' => 'Pengaduan',
            'subjek' => 'Judul Pengaduan',
            'pesan' => 'Pendek', // Less than 10 chars
        ];

        $response = $this->post(route('aspirasi.store'), $data);

        $response->assertSessionHasErrors(['pesan']);
        $this->assertDatabaseCount('aspirations', 0);
    }

    public function test_pengaduan_appears_in_admin_console_and_can_be_viewed(): void
    {
        $aspiration = Aspiration::create([
            'kode_tiket' => 'ASP-2026-00099',
            'nama' => 'Warga RT 05',
            'kontak' => '0811223344',
            'kategori' => 'Pengaduan',
            'subjek' => 'Pengaduan Saluran Air',
            'pesan' => 'Saluran air samping TPQ mampet dan meluap ke halaman.',
            'status' => 'Baru',
        ]);

        // Admin index sees the pengaduan
        $adminIndex = $this->actingAs($this->admin)->get(route('admin.aspirasi.index'));
        $adminIndex->assertStatus(200);
        $adminIndex->assertSee('ASP-2026-00099');
        $adminIndex->assertSee('Pengaduan Saluran Air');

        // Admin view details updates status to Dibaca
        $adminShow = $this->actingAs($this->admin)->get(route('admin.aspirasi.show', $aspiration->id));
        $adminShow->assertStatus(200);
        $adminShow->assertSee('ASP-2026-00099');

        $aspiration->refresh();
        $this->assertEquals('Dibaca', $aspiration->status);
    }
}
