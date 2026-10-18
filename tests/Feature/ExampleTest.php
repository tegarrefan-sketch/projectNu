<?php

namespace Tests\Feature;

use App\Models\Banom;
use App\Models\Kta;
use App\Models\Member;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Test public portal homepage returns 200.
     */
    public function test_homepage_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Banjaranyar');
    }

    /**
     * Test public profil page returns 200.
     */
    public function test_profile_page_returns_successful_response(): void
    {
        $response = $this->get('/profil');
        $response->assertStatus(200);
        $response->assertSee('Visi');
    }

    /**
     * Test public BANOM page returns 200.
     */
    public function test_banom_index_and_detail(): void
    {
        $response = $this->get('/banom');
        $response->assertRedirect('/struktur?tab=banom');

        $tabResponse = $this->get('/struktur?tab=banom');
        $tabResponse->assertStatus(200);
        $tabResponse->assertSee('IPNU');

        $ipnuResponse = $this->get('/banom/ipnu');
        $ipnuResponse->assertStatus(200);
        $ipnuResponse->assertSee('IPNU');
    }

    /**
     * Test structure public page.
     */
    public function test_structure_public_page(): void
    {
        $response = $this->get('/struktur');
        $response->assertStatus(200);
        $response->assertSee('Struktur');
    }

    /**
     * Test posts public index and show.
     */
    public function test_posts_public_page(): void
    {
        $response = $this->get('/berita');
        $response->assertStatus(200);

        $post = Post::published()->first();
        if ($post) {
            $detailResponse = $this->get('/berita/' . $post->slug);
            $detailResponse->assertStatus(200);
            $detailResponse->assertSee($post->title);
        }
    }

    /**
     * Test events public index.
     */
    public function test_events_public_page(): void
    {
        $response = $this->get('/agenda');
        $response->assertStatus(200);
        $response->assertSee('Agenda');
    }

    /**
     * Test KTA verification public endpoint.
     */
    public function test_kta_verification_valid_and_invalid(): void
    {
        // Valid KTA from seeder
        $response = $this->get('/kta/verify/IPNU-2026-00001');
        $response->assertStatus(200);
        $response->assertSee('KTA TERDAFTAR');

        // Invalid KTA
        $invalidResponse = $this->get('/kta/verify/TIDAK-ADA-9999');
        $invalidResponse->assertStatus(200);
        $invalidResponse->assertSee('KTA TIDAK DITEMUKAN');
    }

    /**
     * Test citizen aspiration submission.
     */
    public function test_aspiration_submission(): void
    {
        $response = $this->post('/aspirasi', [
            'nama' => 'Warga Test Banjaranyar',
            'kontak' => '081299998888',
            'kategori' => 'Aspirasi',
            'subjek' => 'Usulan Pengadaan Lampu Jalan Dekat Masjid',
            'pesan' => 'Mohon bantuan koordinasi pengurus NU dengan pemdes untuk penerangan jalan santri.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('aspirations', [
            'nama' => 'Warga Test Banjaranyar',
            'subjek' => 'Usulan Pengadaan Lampu Jalan Dekat Masjid',
        ]);
    }

    /**
     * Test Admin authentication and dashboard.
     */
    public function test_admin_guest_redirect_and_authenticated_access(): void
    {
        // Unauthenticated guest cannot access dashboard
        $guestResponse = $this->get('/admin/dashboard');
        $guestResponse->assertRedirect('/admin/login');

        // Authenticated admin can access dashboard
        $admin = User::first();
        $authResponse = $this->actingAs($admin)->get('/admin/dashboard');
        $authResponse->assertStatus(200);
        $authResponse->assertSee('Ahlan wa Sahlan');
    }

    /**
     * Test KTA Studio, print view, and PDF download view.
     */
    public function test_admin_kta_management_and_print(): void
    {
        $admin = User::first();
        $kta = Kta::first();

        $this->assertNotNull($kta);

        // KTA Index
        $indexResponse = $this->actingAs($admin)->get('/admin/kta');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee($kta->nomor_kta);

        // KTA Show (Studio)
        $showResponse = $this->actingAs($admin)->get("/admin/kta/{$kta->id}");
        $showResponse->assertStatus(200);
        $showResponse->assertSee($kta->nomor_kta);

        // KTA Print
        $printResponse = $this->actingAs($admin)->get("/admin/kta/{$kta->id}/print");
        $printResponse->assertStatus(200);
        $printResponse->assertSee('ISO/IEC 7810 ID-1');

        // KTA Download
        $downloadResponse = $this->actingAs($admin)->get("/admin/kta/{$kta->id}/download");
        $downloadResponse->assertStatus(200);

        // KTA Bulk Print
        $bulkResponse = $this->actingAs($admin)->post('/admin/kta-bulk-print', [
            'kta_ids' => [$kta->id]
        ]);
        $bulkResponse->assertStatus(200);
        $bulkResponse->assertSee($kta->nomor_kta);
    }

    /**
     * Test generating a new KTA automatically for a new member.
     */
    public function test_member_creation_and_automatic_kta_generation(): void
    {
        $admin = User::first();
        $banom = Banom::where('singkatan', 'IPNU')->first();

        // Create Member with generate_kta=1
        $response = $this->actingAs($admin)->post('/admin/anggota', [
            'banom_id' => $banom->id,
            'nama_lengkap' => 'Muhammad Rifai Test',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
            'jabatan' => 'Anggota Kaderisasi',
            'tahun_masuk' => 2026,
            'generate_kta' => 1,
        ]);

        $response->assertRedirect('/admin/anggota');

        $newMember = Member::where('nama_lengkap', 'Muhammad Rifai Test')->first();
        $this->assertNotNull($newMember);
        $this->assertNotNull($newMember->kta);
        $this->assertStringStartsWith('IPNU-2026-', $newMember->kta->nomor_kta);
        $this->assertNotEmpty($newMember->kta->qr_code_svg);
    }

    /**
     * Test kta pages return 200 even when an orphaned KTA exists without an associated member.
     */
    public function test_kta_pages_return_200_when_kta_has_no_member(): void
    {
        $banom = Banom::first();
        $member = Member::create([
            'banom_id' => $banom->id,
            'nomor_anggota' => 'TEST-00999',
            'nama_lengkap' => 'Anggota Terhapus Test',
            'jenis_kelamin' => 'Laki-laki',
            'status' => 'Aktif',
            'status_keanggotaan' => 'Anggota',
            'tahun_masuk' => 2026,
            'tanggal_lahir' => '1990-01-01',
        ]);

        $orphanKta = Kta::create([
            'member_id' => $member->id,
            'nomor_kta' => 'ORPHAN-2026-99999',
            'status' => 'Aktif',
            'tanggal_terbit' => now()->toDateString(),
            'tanggal_berlaku' => now()->addYears(3)->toDateString(),
        ]);

        // Soft delete member
        $member->delete();

        $publicSearchResponse = $this->get('/kta/verifikasi');
        $publicSearchResponse->assertStatus(200);

        $searchResponse = $this->get('/kta/verifikasi?nomor_kta=ORPHAN-2026-99999&tanggal_lahir=1990-01-01');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Data tidak ditemukan');

        $admin = User::first();
        $adminIndexResponse = $this->actingAs($admin)->get('/admin/kta');
        $adminIndexResponse->assertStatus(200);

        $adminShowResponse = $this->actingAs($admin)->get("/admin/kta/{$orphanKta->id}");
        $adminShowResponse->assertStatus(200);

        $adminPrintResponse = $this->actingAs($admin)->get("/admin/kta/{$orphanKta->id}/print");
        $adminPrintResponse->assertStatus(200);

        $adminDownloadResponse = $this->actingAs($admin)->get("/admin/kta/{$orphanKta->id}/download");
        $adminDownloadResponse->assertStatus(200);
    }

    /**
     * Test public KTA search requires both nomor_kta and tanggal_lahir (2-factor verification).
     */
    public function test_public_kta_search_with_valid_dob_succeeds(): void
    {
        $kta = Kta::whereHas('member')->first();
        $this->assertNotNull($kta);
        $dob = $kta->member->tanggal_lahir ? $kta->member->tanggal_lahir->format('Y-m-d') : '2005-01-01';

        if (!$kta->member->tanggal_lahir) {
            $kta->member->update(['tanggal_lahir' => $dob]);
        }

        $wrongDobResponse = $this->get("/kta/verifikasi?nomor_kta={$kta->nomor_kta}&tanggal_lahir=1970-01-01");
        $wrongDobResponse->assertStatus(200);
        $wrongDobResponse->assertSee('Data tidak ditemukan');

        $correctResponse = $this->get("/kta/verifikasi?nomor_kta={$kta->nomor_kta}&tanggal_lahir={$dob}");
        $correctResponse->assertStatus(200);
        $correctResponse->assertSee($kta->nomor_kta);
        $correctResponse->assertSee($kta->member->nama_lengkap);
    }
}
