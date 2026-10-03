<?php

namespace Database\Seeders;

use App\Models\Banom;
use Illuminate\Database\Seeder;

class BanomSeeder extends Seeder
{
    public function run(): void
    {
        $banoms = [
            [
                'nama' => 'Ikatan Pelajar Nahdlatul Ulama',
                'singkatan' => 'IPNU',
                'slug' => 'ipnu',
                'deskripsi' => 'Badan Otonom NU yang menghimpun, membina, dan mengembangkan potensi pelajar putra, santri, dan mahasiswa Nahdlatul Ulama di Desa Banjaranyar.',
                'sejarah' => 'Pimpinan Ranting IPNU Banjaranyar berdiri sebagai wadah kaderisasi awal bagi putra-putra Nahdliyin untuk menyemai nilai-nilai Aswaja, cinta ilmu, dan kepemimpinan berwawasan kebangsaan sejak usia muda.',
                'visi' => 'Terbentuknya pelajar NU yang bertakwa kepada Allah SWT, berilmu, berakhlak mulia, berwawasan kebangsaan, dan bertanggung jawab atas tegaknya syariat Islam Ahlussunnah wal Jama\'ah.',
                'misi' => "1. Menghimpun dan membina pelajar, santri, dan pemuda di Desa Banjaranyar.\n2. Menyelenggarakan kaderisasi formal MAKESTA (Masa Kesetiaan Anggota) secara berkesinambungan.\n3. Mengembangkan minat bakat literasi, teknologi, dan olahraga.",
                'kontak' => '+62 821-4567-8901',
                'alamat' => 'Kompleks Gedung Bersama PRNU Banjaranyar Lt. 2',
                'status' => 'Aktif',
                'warna_primer' => '#0284C7',
                'warna_sekunder' => '#0C5A37',
                'urutan' => 1,
            ],
            [
                'nama' => 'Ikatan Pelajar Putri Nahdlatul Ulama',
                'singkatan' => 'IPPNU',
                'slug' => 'ippnu',
                'deskripsi' => 'Wadah kaderisasi pelajar putri, santriwati, dan pemudi Nahdlatul Ulama untuk mencetak generasi muslimah yang cerdas, mandiri, dan berakhlakul karimah.',
                'sejarah' => 'PR IPPNU Banjaranyar aktif menjadi kawah candradimuka bagi santriwati dan pelajar putri desa dalam bidang penguatan kepemimpinan, keputrian islami, dan kepedulian sosial kemasyarakatan.',
                'visi' => 'Terwujudnya pelajar putri NU yang bertaqwa, berilmu, mandiri, terampil, dan berakhlak mulia berlandaskan Islam Ahlussunnah wal Jama\'ah.',
                'misi' => "1. Membangun kesadaran berorganisasi dan literasi di kalangan pelajar putri.\n2. Menyelenggarakan forum shalawat dan kajian keputrian berkala.\n3. Melahirkan kader muslimah pelopor perubahan positif di desa.",
                'kontak' => '+62 822-5678-9012',
                'alamat' => 'Kompleks Gedung Bersama PRNU Banjaranyar Lt. 2',
                'status' => 'Aktif',
                'warna_primer' => '#10B981',
                'warna_sekunder' => '#CA8A04',
                'urutan' => 2,
            ],
            [
                'nama' => 'Fatayat Nahdlatul Ulama',
                'singkatan' => 'FATAYAT',
                'slug' => 'fatayat',
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
            ],
            [
                'nama' => 'Gerakan Pemuda Ansor',
                'singkatan' => 'ANSOR',
                'slug' => 'ansor',
                'deskripsi' => 'Kekuatan kepemudaan garda terdepan NU yang mengawal para kiai, menjaga NKRI, dan menggerakkan solidaritas sosial kemanusiaan di tingkat ranting.',
                'sejarah' => 'Pimpinan Ranting GP Ansor Banjaranyar adalah motor penggerak kebhinekaan, kepemudaan, dan pengamanan tradisi keagamaan Aswaja sejak berdirinya organisasi di Banjaranyar.',
                'visi' => 'Terwujudnya pemuda muslim Indonesia yang beriman, bertaqwa, militan, berilmu, dan mandiri dalam menegakkan Islam Rahmatan Lil Alamin.',
                'misi' => "1. Menjaga marwah para ulama dan keutuhan Negara Kesatuan Republik Indonesia.\n2. Melaksanakan kaderisasi PKD (Pelatihan Kepemimpinan Dasar) secara konsisten.\n3. Menggerakkan kegiatan sosial gotong royong dan tanggap bencana desa.",
                'kontak' => '+62 813-7890-1234',
                'alamat' => 'Kompleks Gedung Bersama PRNU Banjaranyar',
                'status' => 'Aktif',
                'warna_primer' => '#0A5C36',
                'warna_sekunder' => '#B45309',
                'urutan' => 4,
            ],
            [
                'nama' => 'Barisan Ansor Serbaguna',
                'singkatan' => 'BANSER',
                'slug' => 'banser',
                'deskripsi' => 'Korps tenaga inti GP Ansor yang bertugas melaksanakan pengamanan, ketertiban sosial, pertahanan kemanusiaan, dan bakti fisik masyarakat.',
                'sejarah' => 'Satkorkel Banser Banjaranyar selalu siap sedia menjalankan instruksi kiai, mengamankan seluruh agenda pengajian akbar, istighotsah, dan membantu kebencanaan desa.',
                'visi' => 'Mewujudkan korps Banser yang disiplin, terlatih, berjiwa ksatria, dan setia mengawal ulama serta menjaga tanah air.',
                'misi' => "1. Melaksanakan pengamanan kegiatan keagamaan dan pengajian akbar NU.\n2. Membantu ketertiban lalulintas dan kenyamanan masyarakat pada hari besar Islam.\n3. Bersinergi dengan aparat desa, TNI, dan Polri dalam menjaga kondusifitas lingkungan.",
                'kontak' => '+62 812-8901-2345',
                'alamat' => 'Posko Satkorkel Banser Banjaranyar',
                'status' => 'Aktif',
                'warna_primer' => '#3F4F34',
                'warna_sekunder' => '#DC2626',
                'urutan' => 5,
            ],
        ];

        foreach ($banoms as $data) {
            Banom::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
