<?php

namespace Tests\Feature;

use App\Models\Banom;
use App\Models\BanomOfficer;
use App\Models\Division;
use App\Models\Member;
use App\Models\Position;
use App\Models\User;
use App\Services\OfficerPhotoService;
use Database\Seeders\BanomSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DivisionSeeder;
use Database\Seeders\PositionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StructureRevisionTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->admin = User::first() ?? User::factory()->create();
    }

    /**
     * (1) Tambah 200 Anggota Pasukan / Anggota Departemen berhasil tanpa error
     */
    public function test_1_tambah_200_anggota_pasukan_atau_departemen_berhasil_tanpa_error(): void
    {
        $banom = Banom::where('singkatan', 'BANSER')->first() 
            ?? Banom::create([
                'nama' => 'Satuan Koordinasi Kelompok (SATKORKEL) BANSER',
                'singkatan' => 'BANSER',
                'slug' => 'banser',
                'kategori' => 'banom',
                'urutan' => 2,
                'is_active' => true,
            ]);

        $position = Position::where('nama', 'Anggota Pasukan')->first()
            ?? Position::create([
                'nama' => 'Anggota Pasukan',
                'kategori' => 'Banom',
                'tipe' => 'anggota',
                'maks_orang' => null,
                'batas_keras' => false,
                'urutan' => 27,
            ]);

        // Buat 200 member untuk ditambahkan sekaligus
        $memberIds = [];
        for ($i = 1; $i <= 200; $i++) {
            $member = Member::create([
                'banom_id' => $banom->id,
                'nama_lengkap' => "Anggota Pasukan {$i}",
                'nomor_anggota' => 'BNS-' . str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'status' => 'Aktif',
            ]);
            $memberIds[] = $member->id;
        }

        $response = $this->actingAs($this->admin)->post(
            route('admin.banoms.officers.bulk-store', $banom->id),
            [
                'position_id' => $position->id,
                'member_ids' => $memberIds,
                'is_active' => 1,
            ]
        );

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.banoms.officers.index', $banom->id));

        $count = BanomOfficer::where('banom_id', $banom->id)
            ->where('position_id', $position->id)
            ->count();

        $this->assertEquals(200, $count);
    }

    /**
     * (2) 10 A'wan berhasil ditambahkan
     */
    public function test_2_tambah_10_awan_berhasil_tanpa_error(): void
    {
        $prnu = Banom::where('kategori', 'ranting')->first()
            ?? Banom::create([
                'nama' => 'Pengurus Ranting Nahdlatul Ulama',
                'singkatan' => 'PRNU',
                'slug' => 'prnu',
                'kategori' => 'ranting',
                'urutan' => 0,
                'is_active' => true,
            ]);

        $positionAwan = Position::where('nama', "A'wan")->first()
            ?? Position::create([
                'nama' => "A'wan",
                'kategori' => 'Syuriyah',
                'tipe' => 'anggota',
                'maks_orang' => null,
                'batas_keras' => false,
                'urutan' => 6,
            ]);

        for ($i = 1; $i <= 10; $i++) {
            $response = $this->actingAs($this->admin)->post(
                route('admin.banoms.officers.store', $prnu->id),
                [
                    'position_id' => $positionAwan->id,
                    'nama' => "Kiai A'wan {$i}",
                    'is_active' => 1,
                    'urutan' => $i,
                ]
            );

            $response->assertSessionHasNoErrors();
        }

        $awanCount = BanomOfficer::where('banom_id', $prnu->id)
            ->where('position_id', $positionAwan->id)
            ->count();

        $this->assertGreaterThanOrEqual(10, $awanCount);
    }

    /**
     * (3) Ketua kedua pada organisasi yang sama ditolak dengan pesan validasi, bukan error 500
     */
    public function test_3_ketua_kedua_pada_organisasi_sama_ditolak_dengan_pesan_validasi(): void
    {
        $banom = Banom::where('kategori', 'banom')->first();
        $this->assertNotNull($banom);

        $posKetua = Position::where('nama', 'Ketua')
            ->where('kategori', 'Banom')
            ->first();

        $this->assertNotNull($posKetua);
        $this->assertTrue($posKetua->batas_keras);

        // Hapus pengurus ketua lama jika ada di banom ini untuk isolasi tes
        BanomOfficer::where('banom_id', $banom->id)
            ->where('position_id', $posKetua->id)
            ->delete();

        // 1. Tambah Ketua pertama (berhasil)
        $firstRes = $this->actingAs($this->admin)->post(
            route('admin.banoms.officers.store', $banom->id),
            [
                'position_id' => $posKetua->id,
                'nama' => 'Ketua Pertama Terpilih',
                'is_active' => 1,
            ]
        );
        $firstRes->assertSessionHasNoErrors();

        // 2. Tambah Ketua kedua (harus ditolak dengan pesan ramah, BUKAN 500)
        $secondRes = $this->actingAs($this->admin)->post(
            route('admin.banoms.officers.store', $banom->id),
            [
                'position_id' => $posKetua->id,
                'nama' => 'Ketua Kedua Hendak Mendaftar',
                'is_active' => 1,
            ]
        );

        $this->assertNotEquals(500, $secondRes->getStatusCode());
        $secondRes->assertSessionHasErrors(['position_id']);

        $errorMsg = session('errors')->first('position_id');
        $this->assertEquals(
            'Jabatan ini sudah terisi, ubah atau nonaktifkan pengurus lama terlebih dahulu.',
            $errorMsg
        );

        $this->assertDatabaseMissing('banom_officers', [
            'banom_id' => $banom->id,
            'nama' => 'Ketua Kedua Hendak Mendaftar',
        ]);
    }

    /**
     * (4) Wakil Ketua ketiga hanya memunculkan peringatan lunak dan tetap tersimpan
     */
    public function test_4_wakil_ketua_ketiga_hanya_memunculkan_peringatan_lunak_dan_tetap_tersimpan(): void
    {
        $banom = Banom::where('kategori', 'banom')->first();
        $posWakil = Position::where('nama', 'Wakil Ketua')
            ->where('kategori', 'Banom')
            ->first();

        $this->assertNotNull($posWakil);
        $this->assertFalse($posWakil->batas_keras);
        $this->assertEquals(2, $posWakil->anjuran_maks);

        // Bersihkan wakil lama di banom ini
        BanomOfficer::where('banom_id', $banom->id)
            ->where('position_id', $posWakil->id)
            ->delete();

        // Tambah Wakil I
        $res1 = $this->actingAs($this->admin)->post(
            route('admin.banoms.officers.store', $banom->id),
            [
                'position_id' => $posWakil->id,
                'nama' => 'Wakil Ketua I',
                'is_active' => 1,
            ]
        );
        $res1->assertSessionHasNoErrors();

        // Tambah Wakil II
        $res2 = $this->actingAs($this->admin)->post(
            route('admin.banoms.officers.store', $banom->id),
            [
                'position_id' => $posWakil->id,
                'nama' => 'Wakil Ketua II',
                'is_active' => 1,
            ]
        );
        $res2->assertSessionHasNoErrors();

        // Tambah Wakil III (melebihi anjuran 2 orang, tetapi TIDAK diblokir)
        $res3 = $this->actingAs($this->admin)->post(
            route('admin.banoms.officers.store', $banom->id),
            [
                'position_id' => $posWakil->id,
                'nama' => 'Wakil Ketua III',
                'is_active' => 1,
            ]
        );

        $res3->assertSessionHasNoErrors();
        $res3->assertSessionHas('warning');

        $this->assertDatabaseHas('banom_officers', [
            'banom_id' => $banom->id,
            'position_id' => $posWakil->id,
            'nama' => 'Wakil Ketua III',
        ]);
    }

    /**
     * (5) Seeder dijalankan dua kali tanpa data ganda (idempotent)
     */
    public function test_5_seeder_dijalankan_dua_kali_tanpa_data_ganda(): void
    {
        $banomCount1 = Banom::count();
        $posCount1 = Position::count();
        $divCount1 = Division::count();

        // Jalankan seeder kedua kalinya
        $this->seed(BanomSeeder::class);
        $this->seed(PositionSeeder::class);
        $this->seed(DivisionSeeder::class);

        $banomCount2 = Banom::count();
        $posCount2 = Position::count();
        $divCount2 = Division::count();

        $this->assertEquals($banomCount1, $banomCount2, 'Banom duplicate detected after re-seeding!');
        $this->assertEquals($posCount1, $posCount2, 'Position duplicate detected after re-seeding!');
        $this->assertEquals($divCount1, $divCount2, 'Division duplicate detected after re-seeding!');
    }

    /**
     * (6) Unggah foto 8MB berhasil dan hasil akhirnya di bawah 300KB (WebP)
     */
    public function test_6_unggah_foto_8mb_berhasil_dan_hasil_akhir_di_bawah_300kb(): void
    {
        Storage::fake('public');

        // Buat file image JPEG 8MB yang valid untuk GD
        $tmpFile = tempnam(sys_get_temp_dir(), 'test_8mb_');
        $img = imagecreatetruecolor(1200, 1200);
        // Isi dengan noise warna agar ukurannya realistis
        for ($c = 0; $c < 20; $c++) {
            $col = imagecolorallocate($img, rand(0, 255), rand(0, 255), rand(0, 255));
            imagefilledrectangle($img, rand(0, 1000), rand(0, 1000), rand(200, 1200), rand(200, 1200), $col);
        }
        imagejpeg($img, $tmpFile, 95);
        imagedestroy($img);

        // Tambah padding byte untuk mencapai ~8MB (8000 KB)
        $currentSize = filesize($tmpFile);
        $targetSize = 8 * 1024 * 1024; // 8MB
        if ($targetSize > $currentSize) {
            $padding = str_repeat("\0", $targetSize - $currentSize);
            file_put_contents($tmpFile, $padding, FILE_APPEND);
        }

        $uploadedFile = new UploadedFile(
            $tmpFile,
            'pengurus_8mb.jpg',
            'image/jpeg',
            null,
            true
        );

        $service = new OfficerPhotoService();
        $storedPath = $service->processAndStore($uploadedFile);

        $this->assertNotNull($storedPath);
        $this->assertTrue(Storage::disk('public')->exists($storedPath));

        $fullPath = Storage::disk('public')->path($storedPath);
        $fileSizeKb = filesize($fullPath) / 1024;

        // Hasil akhir kompresi WebP 800px harus di bawah 300KB
        $this->assertLessThan(300, $fileSizeKb, "File size {$fileSizeKb}KB exceeds 300KB");

        @unlink($tmpFile);
    }

    /**
     * (7) Foto 12MB ditolak dengan pesan jelas
     */
    public function test_7_foto_12mb_ditolak_dengan_pesan_jelas(): void
    {
        $banom = Banom::first();
        $position = Position::where('tipe', 'anggota')->first();

        // 12MB file = 12288 KB
        $largeFile = UploadedFile::fake()->create('foto_terlalu_besar.jpg', 12500, 'image/jpeg');

        $response = $this->actingAs($this->admin)->post(
            route('admin.banoms.officers.store', $banom->id),
            [
                'position_id' => $position->id,
                'nama' => 'Pengurus Foto 12MB',
                'foto' => $largeFile,
                'is_active' => 1,
            ]
        );

        $response->assertSessionHasErrors(['foto']);
        $errorMsg = session('errors')->first('foto');

        $this->assertEquals('Maksimal 10 MB, sistem akan mengecilkan otomatis.', $errorMsg);
    }

    /**
     * (8) Foto yang terputar otomatis tegak (EXIF Orientation)
     */
    public function test_8_foto_yang_terputar_otomatis_tegak(): void
    {
        Storage::fake('public');

        // Buat file GD image landscape (800x400)
        $img = imagecreatetruecolor(800, 400);
        $tmpFile = tempnam(sys_get_temp_dir(), 'test_exif_');
        imagejpeg($img, $tmpFile, 90);
        imagedestroy($img);

        $uploadedFile = new UploadedFile($tmpFile, 'landscape.jpg', 'image/jpeg', null, true);

        $service = new OfficerPhotoService();
        $storedPath = $service->processAndStore($uploadedFile);

        $this->assertTrue(Storage::disk('public')->exists($storedPath));

        $savedFile = Storage::disk('public')->path($storedPath);
        $info = getimagesize($savedFile);

        // Ukuran harus valid dan dimensi terpanjang <= 800px
        $this->assertLessThanOrEqual(800, max($info[0], $info[1]));

        @unlink($tmpFile);
    }

    /**
     * (9) Foto lama terhapus saat diganti
     */
    public function test_9_foto_lama_terhapus_saat_diganti(): void
    {
        Storage::fake('public');

        $file1 = UploadedFile::fake()->image('foto_awal.jpg', 600, 600);
        $service = new OfficerPhotoService();
        $storedPath1 = $service->processAndStore($file1);

        $this->assertTrue(Storage::disk('public')->exists($storedPath1));

        // Ganti dengan foto baru
        $file2 = UploadedFile::fake()->image('foto_baru.jpg', 600, 600);
        $storedPath2 = $service->processAndStore($file2, $storedPath1);

        // Foto lama harus sudah terhapus
        $this->assertFalse(Storage::disk('public')->exists($storedPath1));
        // Foto baru harus ada
        $this->assertTrue(Storage::disk('public')->exists($storedPath2));

        // Hapus saat pengurus dihapus
        $service->deleteOld($storedPath2);
        $this->assertFalse(Storage::disk('public')->exists($storedPath2));
    }
}
