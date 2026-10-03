<?php

namespace Database\Seeders;

use App\Models\Banom;
use App\Models\OrganizationStructure;
use Illuminate\Database\Seeder;

class OrganizationStructureSeeder extends Seeder
{
    public function run(): void
    {
        $ansor = Banom::where('singkatan', 'ANSOR')->first();
        $banser = Banom::where('singkatan', 'BANSER')->first();
        $fatayat = Banom::where('singkatan', 'FATAYAT')->first();
        $ipnu = Banom::where('singkatan', 'IPNU')->first();
        $ippnu = Banom::where('singkatan', 'IPPNU')->first();

        $structures = [
            // MUSTASYAR
            [
                'banom_id' => null,
                'kategori_hierarki' => 'mustasyar',
                'nama' => 'K.H. Masduki Syakur',
                'jabatan' => 'Mustasyar (Penasihat Sepuh)',
                'deskripsi' => 'Pengasuh Majelis Ta\'lim & Sesepuh Warga Nahdliyin Banjaranyar.',
                'urutan' => 1,
            ],
            [
                'banom_id' => null,
                'kategori_hierarki' => 'mustasyar',
                'nama' => 'K.H. Ahmad Dahlan Thohir',
                'jabatan' => 'Mustasyar',
                'deskripsi' => 'Tokoh Ulama Sesepuh Aswaja Desa Banjaranyar.',
                'urutan' => 2,
            ],

            // SYURIYAH
            [
                'banom_id' => null,
                'kategori_hierarki' => 'syuriyah',
                'nama' => 'K.H. Nur Hadi Syafi\'i',
                'jabatan' => 'Rais Syuriyah',
                'deskripsi' => 'Pimpinan Tertinggi Syuriyah, Pengarah Spiritual & Pembina Hukum Aswaja.',
                'urutan' => 3,
            ],
            [
                'banom_id' => null,
                'kategori_hierarki' => 'syuriyah',
                'nama' => 'K. Ahmad Fauzi, S.Ag',
                'jabatan' => 'Katib Syuriyah',
                'deskripsi' => 'Sekretaris Eksekutif Syuriyah & Koordinator Bahtsul Masail.',
                'urutan' => 4,
            ],
            [
                'banom_id' => null,
                'kategori_hierarki' => 'syuriyah',
                'nama' => 'Ust. M. Sholihin',
                'jabatan' => 'A\'wan Syuriyah',
                'deskripsi' => 'Anggota Majelis Syuriyah bidang Kemakmuran Masjid dan Musholla.',
                'urutan' => 5,
            ],

            // TANFIDZIYAH
            [
                'banom_id' => null,
                'kategori_hierarki' => 'tanfidziyah',
                'nama' => 'H. M. Zainuddin, S.Pd',
                'jabatan' => 'Ketua Tanfidziyah',
                'deskripsi' => 'Pelaksana Mandat & Penggerak Harian Program Keummatan PRNU Banjaranyar.',
                'urutan' => 6,
            ],
            [
                'banom_id' => null,
                'kategori_hierarki' => 'tanfidziyah',
                'nama' => 'M. Ali Mansyur, S.Pd.I',
                'jabatan' => 'Sekretaris Tanfidziyah',
                'deskripsi' => 'Kepala Tata Usaha, Registrasi SIMNU, dan Administrasi Organisasi.',
                'urutan' => 7,
            ],
            [
                'banom_id' => null,
                'kategori_hierarki' => 'tanfidziyah',
                'nama' => 'H. Sukirno, S.E',
                'jabatan' => 'Bendahara Tanfidziyah',
                'deskripsi' => 'Pengelola Keuangan, Kas Organisasi, dan Sinergi LAZISNU Banjaranyar.',
                'urutan' => 8,
            ],

            // BANOM LEADERS
            [
                'banom_id' => $ansor?->id,
                'kategori_hierarki' => 'banom',
                'nama' => 'Sahabat Ahmad Ridwan, S.Sos',
                'jabatan' => 'Ketua Pimpinan Ranting GP Ansor',
                'deskripsi' => 'Komandan Pemuda Ansor Ranting Banjaranyar.',
                'urutan' => 9,
            ],
            [
                'banom_id' => $banser?->id,
                'kategori_hierarki' => 'banom',
                'nama' => 'Ndan Sugeng Prayitno',
                'jabatan' => 'Kepala Satkorkel Banser',
                'deskripsi' => 'Komandan Operasional Satuan Koordinasi Kelompok Banser.',
                'urutan' => 10,
            ],
            [
                'banom_id' => $fatayat?->id,
                'kategori_hierarki' => 'banom',
                'nama' => 'Sahabat Siti Mar\'atun Sholihah, S.Pd',
                'jabatan' => 'Ketua Pimpinan Ranting Fatayat NU',
                'deskripsi' => 'Penggerak Perempuan Muda Nahdliyin Banjaranyar.',
                'urutan' => 11,
            ],
            [
                'banom_id' => $ipnu?->id,
                'kategori_hierarki' => 'banom',
                'nama' => 'Rekan Bagus Santoso',
                'jabatan' => 'Ketua Pimpinan Ranting IPNU',
                'deskripsi' => 'Koordinator Pelajar dan Santri Putra Banjaranyar.',
                'urutan' => 12,
            ],
            [
                'banom_id' => $ippnu?->id,
                'kategori_hierarki' => 'banom',
                'nama' => 'Rekanita Nur Lailatul Fitriyah',
                'jabatan' => 'Ketua Pimpinan Ranting IPPNU',
                'deskripsi' => 'Koordinator Pelajar Putri dan Santriwati Banjaranyar.',
                'urutan' => 13,
            ],
        ];

        foreach ($structures as $item) {
            OrganizationStructure::updateOrCreate(
                ['nama' => $item['nama'], 'jabatan' => $item['jabatan']],
                $item
            );
        }
    }
}
