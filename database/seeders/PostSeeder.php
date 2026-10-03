<?php

namespace Database\Seeders;

use App\Models\Banom;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $banoms = Banom::all()->keyBy('singkatan');

        $posts = [
            [
                'banom_id' => null,
                'kategori' => 'Kegiatan',
                'title' => 'Semarak Selapanan Ahad Kliwon: Penguatan Aswaja dan Solidaritas Nahdliyin Banjaranyar',
                'slug' => 'semarak-selapanan-ahad-kliwon-penguatan-aswaja-dan-solidaritas-nahdliyin-banjaranyar',
                'excerpt' => 'Ratusan jemaah dan pengurus ranting memadati Masjid Jami\' Baitul Muttaqin dalam pengajian selapanan rutin Ahad Kliwon yang diisi tausiyah kebangsaan dan santunan LAZISNU.',
                'content' => "<p><strong>BANJARANYAR, BAURENO</strong> — Suasana khidmat dan penuh kehangatan menyelimuti serambi Masjid Jami' Baitul Muttaqin Desa Banjaranyar pada gelaran Pengajian Selapanan Rutin Ahad Kliwon, Ahad pagi kemarin. Ratusan jemaah dari berbagai dusun berduyun-duyun hadir sejak selepas sholat Subuh untuk mengikuti pembacaan Istighotsah, Dzikir Tahlil, serta mendengarkan mauidhoh hasanah dari Rais Syuriyah PRNU Banjaranyar, K.H. Nur Hadi Syafi'i.</p>

<p>Dalam tausiyahnya, K.H. Nur Hadi menegaskan pentingnya menjaga tradisi keagamaan Aswaja di tengah derasnya arus disinformasi dan perubahan zaman. 'Pengajian selapanan ini bukan sekadar rutinitas amaliyah lisan, melainkan benteng pertahanan spiritual desa dan sarana menyambung silaturahmi antargenerasi nahdliyin,' tutur beliau di hadapan jemaah.</p>

<p>Pada kesempatan yang sama, Unit Pengelola Zakat, Infaq, dan Sedekah (UPZIS) LAZISNU Ranting Banjaranyar juga menyalurkan santunan berkah pendidikan untuk 15 santri yatim dan dhuafa desa. Kegiatan ini mencerminkan komitmen nyata PRNU Banjaranyar dalam mewujudkan kemandirian dan kepedulian sosial yang berkesinambungan.</p>",
                'thumbnail' => null,
                'author' => 'LTN NU Banjaranyar',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'views' => 1240,
            ],
            [
                'banom_id' => null,
                'kategori' => 'Umum',
                'title' => 'Gerakan Koin Infaq LAZISNU Banjaranyar Tembus Rp 48,2 Juta Sepanjang Tahun Berjalan',
                'slug' => 'gerakan-koin-infaq-lazisnu-banjaranyar-tembus-rp-48-juta',
                'excerpt' => 'Transparansi dan akuntabilitas pengelolaan kaleng koin LAZISNU di setiap rumah warga membuktikan tingginya kepercayaan jemaah terhadap program kemaslahatan desa.',
                'content' => "<p><strong>BANJARANYAR</strong> — Program Gerakan Koin Infaq Nahdlatul Ulama yang dikelola oleh UPZIS LAZISNU Ranting Banjaranyar kembali mencatatkan capaian membanggakan. Hingga bulan ini, total perolehan infaq kaleng koin yang terkumpul dari para donatur dan warga nahdliyin desa mencapai Rp 48.250.000,-.</p>

<p>Ketua Tanfidziyah PRNU Banjaranyar, H. M. Zainuddin, menyampaikan apresiasi setinggi-tingginya kepada seluruh relawan LAZISNU dan warga desa. Dana infaq tersebut secara transparan dialokasikan untuk 4 pilar utama: Pendidikan Santri, Kesehatan Dhuafa, Tanggap Bencana Lokal, dan Kemakmuran Musholla se-Desa Banjaranyar.</p>",
                'thumbnail' => null,
                'author' => 'Sekretariat LAZISNU',
                'status' => 'published',
                'published_at' => now()->subDays(6),
                'views' => 890,
            ],
            [
                'banom_id' => $banoms['BANSER']?->id,
                'kategori' => 'BANSER',
                'title' => 'Satkorkel Banser Banjaranyar Siagakan Pasukan Amankan Agenda Keagamaan dan Kamtibmas Desa',
                'slug' => 'satkorkel-banser-banjaranyar-siagakan-pasukan-amankan-agenda-keagamaan',
                'excerpt' => 'Korps Banser Banjaranyar menggelar apel koordinasi taktis dan kesiapsiagaan di Gedung Bersama PRNU guna mendukung kelancaran pengajian akbar dan keamanan lingkungan.',
                'content' => "<p><strong>BANJARANYAR</strong> — Sebagai garda terdepan pengawal ulama dan benteng NKRI, puluhan personel Barisan Ansor Serbaguna (Banser) Satkorkel Banjaranyar melaksanakan apel kesiapsiagaan di halaman Gedung Bersama PRNU Banjaranyar.</p>

<p>Kepala Satkorkel Banser Banjaranyar, Ndan Sugeng Prayitno, memimpin langsung jalannya apel dan menekankan pentingnya kedisiplinan serta koordinasi santun dengan warga dan aparat keamanan desa saat bertugas mengatur lalu lintas dan kenyamanan jemaah pengajian.</p>",
                'thumbnail' => null,
                'author' => 'Humas Banser',
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'views' => 610,
            ],
            [
                'banom_id' => $banoms['IPNU']?->id,
                'kategori' => 'IPNU',
                'title' => 'Makesta Raya IPNU-IPPNU Banjaranyar 2026: Cetak Generasi Pelajar Aswaja yang Melek Digital',
                'slug' => 'makesta-raya-ipnu-ippnu-banjaranyar-2026-cetak-generasi-pelajar-aswaja',
                'excerpt' => 'Masa Kesetiaan Anggota (MAKESTA) gabungan berhasil mengkader 45 pelajar putra dan putri dengan materi keaswajaan, kepemimpinan, dan literasi media sosial.',
                'content' => "<p><strong>BANJARANYAR</strong> — Pimpinan Ranting IPNU dan IPPNU Desa Banjaranyar sukses menggelar Masa Kesetiaan Anggota (MAKESTA) Raya yang diikuti oleh puluhan pelajar tingkat SMP dan SMA sederajat di wilayah Banjaranyar.</p>

<p>Pelatihan selama dua hari satu malam ini menitikberatkan pada penguatan ideologi Ahlussunnah wal Jama'ah An-Nahdliyyah, wawasan kebangsaan, serta etika bermedia digital agar pelajar NU mampu menjadi duta perdamaian dan penangkal hoax di dunia maya.</p>",
                'thumbnail' => null,
                'author' => 'Media Pelajar NU',
                'status' => 'published',
                'published_at' => now()->subDays(14),
                'views' => 740,
            ],
            [
                'banom_id' => $banoms['FATAYAT']?->id,
                'kategori' => 'FATAYAT',
                'title' => 'Fatayat NU Banjaranyar Gelar Rutinan Diba\'iyah Keliling dan Edukasi Pola Asuh Islami',
                'slug' => 'fatayat-nu-banjaranyar-gelar-rutinan-dibaiyah-keliling-dan-edukasi-pola-asuh',
                'excerpt' => 'Pertemuan selapanan kaum ibu muda Fatayat NU diisi pembacaan shalawat Nabi dan diskusi parenting islami guna menumbuhkan keluarga sakinah mawaddah wa rahmah.',
                'content' => "<p><strong>BANJARANYAR</strong> — Rutinan pembacaan Maulid Diba'iyah Pimpinan Ranting Fatayat NU Banjaranyar putaran Dusun Kauman berlangsung meriah dan khidmat. Puluhan kader Fatayat tampak antusias mengikuti lantunan shalawat yang dipimpin oleh tim paduan suara hadrah Fatayat.</p>

<p>Ketua PR Fatayat NU Banjaranyar, Sahabat Siti Mar'atun Sholihah, mengajak para ibu muda untuk terus aktif menambah wawasan parenting islami dan senantiasa mendidik putra-putrinya dengan keteladanan akhlak Nabi Muhammad SAW.</p>",
                'thumbnail' => null,
                'author' => 'Sekretariat Fatayat',
                'status' => 'published',
                'published_at' => now()->subDays(18),
                'views' => 520,
            ],
            [
                'banom_id' => $banoms['ANSOR']?->id,
                'kategori' => 'ANSOR',
                'title' => 'GP Ansor Banjaranyar Pelopori Kerja Bakti Bersih Saluran Air dan Lingkungan Dusun',
                'slug' => 'gp-ansor-banjaranyar-pelopori-kerja-bakti-bersih-saluran-air-lingkungan-dusun',
                'excerpt' => 'Semangat gotong royong ditunjukkan pemuda GP Ansor bersama warga desa dalam membersihkan saluran irigasi guna mengantisipasi genangan air di musim penghujan.',
                'content' => "<p><strong>BANJARANYAR</strong> — Puluhan anggota GP Ansor Banjaranyar turun langsung ke parit dan saluran pembuangan air di Dusun Krajan dalam aksi bakti sosial gotong royong pembersihan lingkungan. Aksi ini mendapat sambutan hangat dari kepala desa dan tokoh masyarakat setempat.</p>",
                'thumbnail' => null,
                'author' => 'Sahabat Ansor',
                'status' => 'published',
                'published_at' => now()->subDays(22),
                'views' => 430,
            ],
        ];

        foreach ($posts as $item) {
            Post::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
