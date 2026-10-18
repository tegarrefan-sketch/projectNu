<?php

namespace Database\Seeders;

use App\Models\Banom;
use Illuminate\Database\Seeder;

class BanomSeeder extends Seeder
{
    /**
     * Seed master data organisasi (PRNU & 6 Badan Otonom) secara idempotent.
     */
    public function run(): void
    {
        $organizations = [
            // PRNU (Tingkat Ranting)
            [
                'nama' => 'Pengurus Ranting Nahdlatul Ulama (PRNU) Banjaranyar',
                'singkatan' => 'PRNU',
                'slug' => 'prnu',
                'kategori' => 'ranting',
                'rentang_usia' => 'Seluruh Warga Nahdliyin',
                'label_bagian' => 'Lembaga',
                'deskripsi' => 'Struktur kepengurusan Nahdlatul Ulama tingkat desa/ranting Banjaranyar yang menaungi Majelis Mustasyar, Syuriyah, Tanfidziyah, dan Badan Otonom.',
                'sejarah' => 'Pengurus Ranting Nahdlatul Ulama Banjaranyar berkhidmat sejak puluhan tahun silam dalam membina amaliyah Ahlussunnah wal Jama\'ah an-Nahdliyyah, membimbing spiritual keagamaan, serta memperkuat solidaritas sosial warga desa.',
                'visi' => 'Menjadi wadah khidmah keagamaan dan kemasyarakatan yang mandiri, maslahat, dan berakhlakul karimah berlandaskan Islam Ahlussunnah wal Jama\'ah.',
                'misi' => "1. Menjaga dan menyiarkan aqidah Islam Ahlussunnah wal Jama'ah an-Nahdliyyah.\n2. Mengkoordinasikan penguatan kelembagaan, masjid, musholla, dan majelis ta'lim se-Desa Banjaranyar.\n3. Menggerakkan kemandirian ekonomi, ZISWAF, dan kepedulian sosial umat.",
                'kontak' => '+62 812-3456-7890',
                'alamat' => 'Gedung Bersama PRNU Banjaranyar, Kec. Baureno, Kab. Bojonegoro',
                'status' => 'Aktif',
                'warna_primer' => '#004125',
                'warna_sekunder' => '#FE932C',
                'urutan' => 0,
                'is_active' => true,
            ],
            // 1. Pimpinan Ranting (PR) Gerakan Pemuda Ansor
            [
                'nama' => 'Pimpinan Ranting (PR) Gerakan Pemuda Ansor',
                'singkatan' => 'ANSOR',
                'slug' => 'ansor',
                'kategori' => 'banom',
                'rentang_usia' => 'Pemuda usia 20-40 tahun',
                'label_bagian' => 'Bidang',
                'deskripsi' => 'Kekuatan kepemudaan garda terdepan NU yang mengawal para kiai, menjaga NKRI, dan menggerakkan solidaritas sosial kemanusiaan di tingkat ranting.',
                'sejarah' => 'Pimpinan Ranting GP Ansor Banjaranyar adalah motor penggerak kebhinekaan, kepemudaan, dan pengamanan tradisi keagamaan Aswaja sejak berdirinya organisasi di Banjaranyar.',
                'visi' => 'Terwujudnya pemuda muslim Indonesia yang beriman, bertaqwa, militan, berilmu, dan mandiri dalam menegakkan Islam Rahmatan Lil Alamin.',
                'misi' => "1. Menjaga marwah para ulama dan keutuhan Negara Kesatuan Republik Indonesia.\n2. Melaksanakan kaderisasi PKD (Pelatihan Kepemimpinan Dasar) secara konsisten.\n3. Menggerakkan kegiatan sosial gotong royong dan tanggap bencana desa.",
                'kontak' => '+62 813-7890-1234',
                'alamat' => 'Kompleks Gedung Bersama PRNU Banjaranyar',
                'status' => 'Aktif',
                'warna_primer' => '#0A5C36',
                'warna_sekunder' => '#B45309',
                'urutan' => 1,
                'is_active' => true,
            ],
            // 2. Satuan Koordinasi Kelompok (SATKORKEL) BANSER
            [
                'nama' => 'Satuan Koordinasi Kelompok (SATKORKEL) BANSER',
                'singkatan' => 'BANSER',
                'slug' => 'banser',
                'kategori' => 'banom',
                'rentang_usia' => 'Tenaga Inti Pengamanan GP Ansor',
                'label_bagian' => 'Unit/Biro',
                'deskripsi' => 'Korps tenaga inti GP Ansor yang bertugas melaksanakan pengamanan, ketertiban sosial, pertahanan kemanusiaan, dan bakti fisik masyarakat.',
                'sejarah' => 'Satkorkel Banser Banjaranyar selalu siap sedia menjalankan instruksi kiai, mengamankan seluruh agenda pengajian akbar, istighotsah, dan membantu kebencanaan desa.',
                'visi' => 'Mewujudkan korps Banser yang disiplin, terlatih, berjiwa ksatria, dan setia mengawal ulama serta menjaga tanah air.',
                'misi' => "1. Melaksanakan pengamanan kegiatan keagamaan dan pengajian akbar NU.\n2. Membantu ketertiban lalu lintas dan kenyamanan masyarakat pada hari besar Islam.\n3. Bersinergi dengan aparat desa, TNI, dan Polri dalam menjaga kondusifitas lingkungan.",
                'kontak' => '+62 812-8901-2345',
                'alamat' => 'Posko Satkorkel Banser Banjaranyar',
                'status' => 'Aktif',
                'warna_primer' => '#3F4F34',
                'warna_sekunder' => '#DC2626',
                'urutan' => 2,
                'is_active' => true,
            ],
            // 3. Pimpinan Ranting (PR) Fatayat NU
            [
                'nama' => 'Pimpinan Ranting (PR) Fatayat NU',
                'singkatan' => 'FATAYAT',
                'slug' => 'fatayat',
                'kategori' => 'banom',
                'rentang_usia' => 'Pemudi usia 20-40 tahun',
                'label_bagian' => 'Bidang',
                'deskripsi' => 'Badan otonom pemberdayaan perempuan muda NU yang berfokus pada ketahanan keluarga, kesehatan balita/ibu, pendidikan anak usia dini, dan amaliyah keagamaan.',
                'sejarah' => 'Pimpinan Ranting Fatayat NU Banjaranyar menggerakkan kaum ibu muda Nahdliyin melalui pembacaan Diba\'iyah, pengajian rukun keluarga, serta aksi tanggap kesehatan gizi dan stunting desa.',
                'visi' => 'Membentuk perempuan muda NU yang bertaqwa, berakhlak karimah, mandiri, dan berdaya guna bagi agama, nusa, dan bangsa.',
                'misi' => "1. Menguatkan peran ibu muda dalam pendidikan karakter anak berbasis Aswaja.\n2. Mengembangkan wirausaha mandiri perempuan pedesaan.\n3. Memperkokoh tali silaturahmi melalui pengajian rutin Diba'iyah antar-dusun.",
                'kontak' => '+62 823-6789-0123',
                'alamat' => 'Kompleks Gedung Bersama PRNU Banjaranyar',
                'status' => 'Aktif',
                'warna_primer' => '#059669',
                'warna_sekunder' => '#ECFDF5',
                'urutan' => 3,
                'is_active' => true,
            ],
            // 4. Pimpinan Ranting (PR) Muslimat NU
            [
                'nama' => 'Pimpinan Ranting (PR) Muslimat NU',
                'singkatan' => 'MUSLIMAT',
                'slug' => 'muslimat',
                'kategori' => 'banom',
                'rentang_usia' => 'Perempuan dewasa usia di atas 40 tahun',
                'label_bagian' => 'Seksi',
                'deskripsi' => 'Badan otonom kaum ibu Nahdlatul Ulama yang berkhidmat dalam pembinaan rohani keluarga, pengajian shalawat akbar, majelis taklim, dan santunan sosial desa.',
                'sejarah' => 'Pimpinan Ranting Muslimat NU Banjaranyar berdiri kokoh sebagai benteng akidah ahlussunnah wal jamaah an-nahdliyyah bagi para ibu dan sesepuh putri di seluruh pedukuhan Banjaranyar.',
                'visi' => 'Terwujudnya masyarakat sejahtera, mandiri, bertaqwa, dan berakhlakul karimah dalam naungan ridho Allah SWT.',
                'misi' => "1. Menumbuhkembangkan kesadaran beragama dan bermasyarakat.\n2. Menggiatkan pengajian majelis taklim dan santunan anak yatim.\n3. Mewujudkan keluarga maslahah berbasis nilai-nilai Aswaja.",
                'kontak' => '+62 821-3456-7890',
                'alamat' => 'Kompleks Gedung Bersama PRNU Banjaranyar',
                'status' => 'Aktif',
                'warna_primer' => '#047857',
                'warna_sekunder' => '#A7F3D0',
                'urutan' => 4,
                'is_active' => true,
            ],
            // 5. Pimpinan Ranting (PR) IPNU
            [
                'nama' => 'Pimpinan Ranting (PR) IPNU',
                'singkatan' => 'IPNU',
                'slug' => 'ipnu',
                'kategori' => 'banom',
                'rentang_usia' => 'Pelajar putra, usia maksimal 24 tahun',
                'label_bagian' => 'Departemen',
                'deskripsi' => 'Badan Otonom NU yang menghimpun, membina, dan mengembangkan potensi pelajar putra, santri, dan mahasiswa Nahdlatul Ulama di Desa Banjaranyar.',
                'sejarah' => 'Pimpinan Ranting IPNU Banjaranyar berdiri sebagai wadah kaderisasi awal bagi putra-putra Nahdliyin untuk menyemai nilai-nilai Aswaja, cinta ilmu, dan kepemimpinan berwawasan kebangsaan sejak usia muda.',
                'visi' => 'Terbentuknya pelajar NU yang bertakwa kepada Allah SWT, berilmu, berakhlak mulia, berwawasan kebangsaan, dan bertanggung jawab atas tegaknya syariat Islam Ahlussunnah wal Jama\'ah.',
                'misi' => "1. Menghimpun dan membina pelajar, santri, dan pemuda di Desa Banjaranyar.\n2. Menyelenggarakan kaderisasi formal MAKESTA (Masa Kesetiaan Anggota) secara berkesinambungan.\n3. Mengembangkan minat bakat literasi, teknologi, dan olahraga.",
                'kontak' => '+62 821-4567-8901',
                'alamat' => 'Kompleks Gedung Bersama PRNU Banjaranyar Lt. 2',
                'status' => 'Aktif',
                'warna_primer' => '#0284C7',
                'warna_sekunder' => '#0C5A37',
                'urutan' => 5,
                'is_active' => true,
            ],
            // 6. Pimpinan Ranting (PR) IPPNU
            [
                'nama' => 'Pimpinan Ranting (PR) IPPNU',
                'singkatan' => 'IPPNU',
                'slug' => 'ippnu',
                'kategori' => 'banom',
                'rentang_usia' => 'Pelajar putri, usia maksimal 24 tahun',
                'label_bagian' => 'Departemen',
                'deskripsi' => 'Wadah kaderisasi pelajar putri, santriwati, dan pemudi Nahdlatul Ulama untuk mencetak generasi muslimah yang cerdas, mandiri, dan berakhlakul karimah.',
                'sejarah' => 'PR IPPNU Banjaranyar aktif menjadi kawah candradimuka bagi santriwati dan pelajar putri desa dalam bidang penguatan kepemimpinan, keputrian islami, dan kepedulian sosial kemasyarakatan.',
                'visi' => 'Terwujudnya pelajar putri NU yang bertaqwa, berilmu, mandiri, terampil, dan berakhlak mulia berlandaskan Islam Ahlussunnah wal Jama\'ah.',
                'misi' => "1. Membangun kesadaran berorganisasi dan literasi di kalangan pelajar putri.\n2. Menyelenggarakan forum shalawat dan kajian keputrian berkala.\n3. Melahirkan kader muslimah pelopor perubahan positif di desa.",
                'kontak' => '+62 822-5678-9012',
                'alamat' => 'Kompleks Gedung Bersama PRNU Banjaranyar Lt. 2',
                'status' => 'Aktif',
                'warna_primer' => '#10B981',
                'warna_sekunder' => '#CA8A04',
                'urutan' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($organizations as $org) {
            Banom::updateOrCreate(
                ['slug' => $org['slug']],
                $org
            );
        }
    }
}
