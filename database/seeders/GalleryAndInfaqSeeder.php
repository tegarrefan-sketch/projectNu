<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\InfaqSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GalleryAndInfaqSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Infaq Settings
        InfaqSetting::current();

        // 2. Sample Infaq Donations
        $sampleDonations = [
            [
                'kode_transaksi' => 'INF-20261001-001-9F2A',
                'nama_donatur' => 'H. M. Sholihin',
                'is_anonim' => false,
                'nomor_whatsapp' => '081234567890',
                'nominal' => 250000,
                'metode_pembayaran' => 'Transfer Bank BSI',
                'pesan_doa' => 'Semoga barokah untuk kelancaran dakwah Aswaja dan kemakmuran musholla warga.',
                'status' => 'Terverifikasi',
                'catatan_admin' => 'Dana telah masuk ke rekening BSI PRNU Banjaranyar.',
                'verified_at' => now()->subDays(9),
                'created_at' => now()->subDays(9),
            ],
            [
                'kode_transaksi' => 'INF-20261003-002-88B1',
                'nama_donatur' => 'Hamba Allah',
                'is_anonim' => true,
                'nomor_whatsapp' => '085712345678',
                'nominal' => 100000,
                'metode_pembayaran' => 'QRIS',
                'pesan_doa' => 'Niat infaq untuk santunan anak yatim piatu di Banjaranyar.',
                'status' => 'Terverifikasi',
                'catatan_admin' => 'QRIS terkonfirmasi.',
                'verified_at' => now()->subDays(7),
                'created_at' => now()->subDays(7),
            ],
            [
                'kode_transaksi' => 'INF-20261007-003-7C44',
                'nama_donatur' => 'Hj. Siti Mahmudah',
                'is_anonim' => false,
                'nomor_whatsapp' => '081398765432',
                'nominal' => 500000,
                'metode_pembayaran' => 'Transfer Bank BSI',
                'pesan_doa' => 'Keluarga besar mendoakan para sesepuh dan pejuang NU desa Banjaranyar.',
                'status' => 'Terverifikasi',
                'catatan_admin' => 'Valid, dana dialokasikan untuk program beasiswa yatim.',
                'verified_at' => now()->subDays(3),
                'created_at' => now()->subDays(3),
            ],
            [
                'kode_transaksi' => 'INF-20261009-004-12FA',
                'nama_donatur' => 'Ahmad Fathoni',
                'is_anonim' => false,
                'nomor_whatsapp' => '082155556666',
                'nominal' => 50000,
                'metode_pembayaran' => 'Transfer Bank Jatim',
                'pesan_doa' => 'Bismillah, semoga berkah bagi jam\'iyyah.',
                'status' => 'Menunggu Verifikasi',
                'created_at' => now()->subHours(8),
            ],
        ];

        foreach ($sampleDonations as $d) {
            Donation::updateOrCreate(
                ['kode_transaksi' => $d['kode_transaksi']],
                $d
            );
        }

        // 3. Sample Galleries & Photos
        $galleryDir = storage_path('app/public/gallery');
        if (!File::exists($galleryDir)) {
            File::makeDirectory($galleryDir, 0755, true);
        }

        $albums = [
            [
                'judul' => 'Istighotsah Kubro & Dzikir Bersama Malam Jumat Legi',
                'slug' => 'istighotsah-kubro-dzikir-bersama',
                'deskripsi' => 'Dokumentasi pelaksanaan Istighotsah Kubro dan doa bersama warga Nahdliyin Banjaranyar memohon keselamatan umat dan bangsa di Gedung Bersama PRNU.',
                'tanggal' => '2026-10-02',
                'lokasi' => 'Gedung Bersama PRNU Banjaranyar',
                'kategori' => 'Keagamaan',
                'photos' => [
                    'Jamaah khusyuk melantunkan kalimat thayyibah dan istighotsah',
                    'Kiai Sepuh memimpin doa bersama para santri dan tokoh masyarakat',
                    'Suasana keakraban para warga sesudah majelis doa selesai',
                ],
            ],
            [
                'judul' => 'Apel Siaga & Latihan Gabungan Satkorkel Banser',
                'slug' => 'apel-siaga-banser-banjaranyar',
                'deskripsi' => 'Apel disiplin dan latihan fisik kebugaran kesiapsiagaan anggota Banser Banjaranyar dalam mengawal ulama dan menjaga stabilitas lingkungan desa.',
                'tanggal' => '2026-09-25',
                'lokasi' => 'Lapangan Olahraga Desa Banjaranyar',
                'kategori' => 'Banser & Ansor',
                'photos' => [
                    'Formasi baris-berbaris anggota Banser saat apel pagi',
                    'Pengarahan dari Kasatkorkel Banser Banjaranyar',
                    'Simulasi pengamanan lalu lintas pengajian akbar',
                ],
            ],
            [
                'judul' => 'Makesta Perdana IPNU-IPPNU Banjaranyar',
                'slug' => 'makesta-perdana-ipnu-ippnu',
                'deskripsi' => 'Masa Kesetiaan Anggota (Makesta) untuk mencetak kader pelajar putra dan putri NU yang bertakwa, berwawasan luas, dan berkarakter Aswaja.',
                'tanggal' => '2026-09-18',
                'lokasi' => 'Madrasah Diniyah Miftahul Huda',
                'kategori' => 'Kaderisasi',
                'photos' => [
                    'Peserta Makesta menyanyikan lagu Indonesia Raya dan Mars IPNU-IPPNU',
                    'Penyampaian materi keaswajaan oleh alumni pesantren',
                    'Foto bersama pengurus dan peserta seusai baiat pengkaderan',
                ],
            ],
            [
                'judul' => 'Penyaluran Santunan Yatim & Lansia LAZISNU',
                'slug' => 'penyaluran-santunan-lazisnu-banjaranyar',
                'deskripsi' => 'Bakti sosial gerakan koin infaq warga untuk memberikan santunan sembako dan beasiswa tunai kepada puluhan anak yatim dan dhuafa di Desa Banjaranyar.',
                'tanggal' => '2026-09-10',
                'lokasi' => 'Serambi Masjid Jami\' Banjaranyar',
                'kategori' => 'Sosial Ummat',
                'photos' => [
                    'Penyerahan bingkisan beasiswa yatim oleh jajaran pengurus Syuriyah',
                    'Senyum kebahagiaan para dhuafa saat menerima paket sembako',
                ],
            ],
        ];

        // Create sample SVG images for galleries
        $svgTemplates = [
            '#004125' => '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="600" viewBox="0 0 800 600"><rect width="800" height="600" fill="#004125"/><circle cx="400" cy="300" r="180" fill="#0c5a37" opacity="0.6"/><path d="M400 160 L450 250 L550 260 L475 330 L500 430 L400 375 L300 430 L325 330 L250 260 L350 250 Z" fill="#fe932c" opacity="0.8"/><text x="400" y="520" font-family="sans-serif" font-size="28" font-weight="bold" fill="#ffffff" text-anchor="middle">DOKUMENTASI KEGIATAN NU BANJARANYAR</text></svg>',
            '#0c5a37' => '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="600" viewBox="0 0 800 600"><rect width="800" height="600" fill="#0c5a37"/><rect x="100" y="80" width="600" height="440" rx="24" fill="#002110" opacity="0.4"/><circle cx="400" cy="280" r="120" fill="#aaf2c4" opacity="0.3"/><text x="400" y="300" font-family="sans-serif" font-size="32" font-weight="bold" fill="#ffdcc3" text-anchor="middle">NU RANTING BANJARANYAR</text><text x="400" y="340" font-family="sans-serif" font-size="18" fill="#ffffff" opacity="0.8" text-anchor="middle">Kecamatan Baureno, Bojonegoro</text></svg>',
            '#904d00' => '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="600" viewBox="0 0 800 600"><rect width="800" height="600" fill="#904d00"/><circle cx="400" cy="300" r="220" fill="#fe932c" opacity="0.4"/><circle cx="400" cy="300" r="130" fill="#004125" opacity="0.6"/><text x="400" y="310" font-family="sans-serif" font-size="28" font-weight="bold" fill="#ffffff" text-anchor="middle">KHIDMAH & PEMBERDAYAAN UMAT</text></svg>',
        ];

        $colorKeys = array_keys($svgTemplates);

        foreach ($albums as $i => $alb) {
            $coverFileName = 'gallery/' . $alb['slug'] . '-cover.svg';
            $coverFullPath = storage_path('app/public/' . $coverFileName);
            $chosenSvg = $svgTemplates[$colorKeys[$i % count($colorKeys)]];
            File::put($coverFullPath, $chosenSvg);

            $gallery = Gallery::updateOrCreate(
                ['slug' => $alb['slug']],
                [
                    'judul' => $alb['judul'],
                    'deskripsi' => $alb['deskripsi'],
                    'tanggal' => $alb['tanggal'],
                    'lokasi' => $alb['lokasi'],
                    'cover' => $coverFileName,
                    'kategori' => $alb['kategori'],
                    'status' => 'Publik',
                ]
            );

            // Clean previous photos if re-seeding
            GalleryPhoto::where('gallery_id', $gallery->id)->delete();

            foreach ($alb['photos'] as $idx => $caption) {
                $photoFileName = 'gallery/' . $alb['slug'] . '-photo-' . ($idx + 1) . '.svg';
                $photoFullPath = storage_path('app/public/' . $photoFileName);
                File::put($photoFullPath, $chosenSvg);

                GalleryPhoto::create([
                    'gallery_id' => $gallery->id,
                    'foto' => $photoFileName,
                    'caption' => $caption,
                    'urutan' => $idx + 1,
                ]);
            }
        }
    }
}
