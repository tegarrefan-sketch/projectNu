<?php

namespace Tests\Feature;

use App\Models\Aspiration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AspirationTrackingAndSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    /**
     * (a) Kode baru unik dan tidak berurutan.
     * Format: ASP-YYYYMMDD-XXXXXX (minimal 6 karakter alfanumerik acak di akhir).
     */
    public function test_a_new_ticket_codes_are_unique_and_non_sequential(): void
    {
        $codes = [];
        for ($i = 0; $i < 20; $i++) {
            $code = Aspiration::generateTiket();
            $codes[] = $code;

            // Pastikan format diawali ASP-YYYYMMDD- dan diikuti minimal 6 karakter alfanumerik
            $this->assertMatchesRegularExpression('/^ASP-\d{8}-[A-Z0-9]{6,}$/', $code);
        }

        // Pastikan seluruh kode yang di-generate unik (tidak ada duplikasi)
        $uniqueCodes = array_unique($codes);
        $this->assertCount(count($codes), $uniqueCodes);

        // Pastikan tidak berurutan (bukan increment angka berurutan)
        $suffixes = array_map(function ($c) {
            return substr($c, 13);
        }, $codes);

        // Setidaknya ada variasi karakter dan bukan sequential increment
        $this->assertNotEquals($suffixes[0], $suffixes[1]);
        $this->assertNotEquals($suffixes[1], $suffixes[2]);
    }

    /**
     * (b) Kode lama masih bisa dilacak tanpa diubah.
     */
    public function test_b_old_ticket_codes_can_still_be_tracked(): void
    {
        $oldTicket = Aspiration::create([
            'kode_tiket' => 'ASP-2026-00001',
            'nama' => 'Warga Banjaranyar Lama',
            'kontak' => '081234567890',
            'kategori' => 'Aspirasi',
            'subjek' => 'Usulan Pembangunan Gedung Madrasah',
            'pesan' => 'Mohon musyawarah pembangunan madrasah diprioritaskan tahun depan.',
            'status' => 'Diproses',
        ]);

        $response = $this->get(route('aspirasi.track', ['kode_tiket' => 'ASP-2026-00001']));

        $response->assertStatus(200);
        $response->assertSee('ASP-2026-00001');
        $response->assertSee('Usulan Pembangunan Gedung Madrasah');
        $response->assertSee('Diproses');
    }

    /**
     * (c) Pencarian lewat nomor WhatsApp hanya menampilkan kode samar tanpa isi pesan.
     */
    public function test_c_whatsapp_search_shows_only_masked_code_without_message_body(): void
    {
        $ticket = Aspiration::create([
            'kode_tiket' => 'ASP-20261017-X7K2Q9',
            'nama' => 'Haji Sulaiman Banjaranyar',
            'kontak' => '081234567899',
            'is_anonim' => false,
            'kategori' => 'Pengaduan',
            'subjek' => 'Judul Rahasia Sangat Penting',
            'pesan' => 'Isi pesan rahasia yang tidak boleh terbaca di halaman lupa tiket',
            'status' => 'Baru',
            'catatan_admin' => 'Tanggapan rahasia dari pengurus harian',
        ]);

        $response = $this->post(route('aspirasi.forgot-ticket'), [
            'whatsapp' => '081234567899',
        ]);

        $response->assertStatus(200);

        // Harus menampilkan kode yang disamarkan (mis. ASP-2026••••-X7K2)
        $masked = $ticket->masked_kode;
        $this->assertStringContainsString('••••', $masked);
        $response->assertSee($masked);

        // JANGAN tampilkan kode lengkap
        $response->assertDontSee('ASP-20261017-X7K2Q9');

        // JANGAN tampilkan isi pesan, balasan admin, atau subjek
        $response->assertDontSee('Isi pesan rahasia yang tidak boleh terbaca di halaman lupa tiket');
        $response->assertDontSee('Judul Rahasia Sangat Penting');
        $response->assertDontSee('Tanggapan rahasia dari pengurus harian');

        // JANGAN tampilkan nama pengirim pada tabel hasil lupa nomor tiket
        $response->assertDontSee('Haji Sulaiman Banjaranyar');
    }

    /**
     * (d) Aspirasi anonim tidak muncul di pencarian nomor WhatsApp dan identitas tidak disimpan.
     */
    public function test_d_anonymous_aspirations_do_not_appear_in_whatsapp_search(): void
    {
        // 1. Submit form anonim dengan nomor kontak yang diketikkan di payload
        $postData = [
            'member_select' => 'anonim',
            'kontak' => '087777777777', // Dikirim tapi harus di-nolkan karena anonim
            'kategori' => 'Kritik',
            'subjek' => 'Kritik Kinerja Takmir Musholla',
            'pesan' => 'Jadwal imam dan muadzin mohon ditata lebih tertib.',
        ];

        $submitRes = $this->post(route('aspirasi.store'), $postData);
        $submitRes->assertRedirect(route('aspirasi.create'));

        $aspiration = Aspiration::where('subjek', 'Kritik Kinerja Takmir Musholla')->first();
        $this->assertNotNull($aspiration);
        $this->assertTrue($aspiration->is_anonim);
        $this->assertNull($aspiration->kontak); // Data identitas tidak disimpan
        $this->assertEquals('Warga Banjaranyar (Anonim)', $aspiration->nama);

        // 2. Pencarian lupa nomor tiket dengan nomor tersebut harus "Tidak ditemukan"
        $searchRes = $this->post(route('aspirasi.forgot-ticket'), [
            'whatsapp' => '087777777777',
        ]);

        $searchRes->assertStatus(200);
        $searchRes->assertSee('Tidak ditemukan');
        $searchRes->assertDontSee($aspiration->kode_tiket);
        $searchRes->assertDontSee($aspiration->masked_kode);
    }

    /**
     * (e) Admin bisa mencari berdasarkan nomor WhatsApp.
     */
    public function test_e_admin_can_search_by_whatsapp_number(): void
    {
        $target = Aspiration::create([
            'kode_tiket' => 'ASP-20261017-ABCDEF',
            'nama' => 'Kiai Ahmad',
            'kontak' => '081299998888',
            'is_anonim' => false,
            'kategori' => 'Aspirasi',
            'subjek' => 'Pengajian Rutin Selapanan',
            'pesan' => 'Mohon diadakan pengajian selapanan di masjid jami ranting.',
            'status' => 'Baru',
        ]);

        $other = Aspiration::create([
            'kode_tiket' => 'ASP-20261017-ZZZZZZ',
            'nama' => 'Warga Lain',
            'kontak' => '085500001111',
            'is_anonim' => false,
            'kategori' => 'Saran',
            'subjek' => 'Usulan Kotak Infak',
            'pesan' => 'Penempatan kotak infak di gang masuk dusun.',
            'status' => 'Baru',
        ]);

        // Admin melakukan pencarian lewat filter whatsapp
        $response = $this->actingAs($this->admin)->get(route('admin.aspirasi.index', [
            'whatsapp' => '081299998888',
        ]));

        $response->assertStatus(200);
        $response->assertSee('ASP-20261017-ABCDEF');
        $response->assertSee('Kiai Ahmad');
        $response->assertDontSee('ASP-20261017-ZZZZZZ');

        // Admin juga bisa mencari via nama pengirim
        $nameResponse = $this->actingAs($this->admin)->get(route('admin.aspirasi.index', [
            'nama' => 'Kiai Ahmad',
        ]));

        $nameResponse->assertStatus(200);
        $nameResponse->assertSee('ASP-20261017-ABCDEF');
        $nameResponse->assertDontSee('ASP-20261017-ZZZZZZ');
    }

    /**
     * (f) Throttle bekerja: batasi pencarian "Lupa nomor tiket" dan pelacakan 10 kali per menit per IP.
     */
    public function test_f_throttle_limits_tracking_and_forgot_ticket_to_10_per_minute(): void
    {
        // 10 kali request ke /aspirasi/lacak diperbolehkan
        for ($i = 1; $i <= 10; $i++) {
            $res = $this->get(route('aspirasi.track', ['kode_tiket' => 'ASP-NONEXIST']));
            $res->assertStatus(200);
        }

        // Request ke-11 harus diblokir oleh throttle:10,1 (HTTP 429 Too Many Requests)
        $blocked = $this->get(route('aspirasi.track', ['kode_tiket' => 'ASP-NONEXIST']));
        $blocked->assertStatus(429);
    }
}
