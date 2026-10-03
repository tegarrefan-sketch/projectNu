<?php

namespace Database\Seeders;

use App\Models\Banom;
use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $banoms = Banom::all()->keyBy('singkatan');

        $members = [
            // IPNU
            [
                'banom_id' => $banoms['IPNU']->id,
                'nomor_anggota' => 'NIA-IPNU-3522-001',
                'nama_lengkap' => 'Bagus Santoso',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bojonegoro',
                'tanggal_lahir' => '2005-04-12',
                'alamat' => 'Dusun Krajan RT 02 RW 01, Desa Banjaranyar, Baureno',
                'nomor_telepon' => '082134567801',
                'email' => 'bagus.santoso@gmail.com',
                'status' => 'Aktif',
                'jabatan' => 'Ketua Ranting',
                'tahun_masuk' => 2021,
                'keterangan' => 'Kader Makesta 2021',
            ],
            [
                'banom_id' => $banoms['IPNU']->id,
                'nomor_anggota' => 'NIA-IPNU-3522-002',
                'nama_lengkap' => 'Ahmad Fathoni',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bojonegoro',
                'tanggal_lahir' => '2006-08-20',
                'alamat' => 'Dusun Banjar RT 05 RW 02, Desa Banjaranyar',
                'nomor_telepon' => '082134567802',
                'email' => 'fathoni.nu@gmail.com',
                'status' => 'Aktif',
                'jabatan' => 'Sekretaris',
                'tahun_masuk' => 2022,
                'keterangan' => 'Kader Makesta 2022',
            ],

            // IPPNU
            [
                'banom_id' => $banoms['IPPNU']->id,
                'nomor_anggota' => 'NIA-IPPNU-3522-001',
                'nama_lengkap' => 'Nur Lailatul Fitriyah',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bojonegoro',
                'tanggal_lahir' => '2006-11-04',
                'alamat' => 'Dusun Kauman RT 01 RW 03, Desa Banjaranyar',
                'nomor_telepon' => '082245678901',
                'email' => 'nurlaila.ippnu@gmail.com',
                'status' => 'Aktif',
                'jabatan' => 'Ketua Ranting',
                'tahun_masuk' => 2022,
                'keterangan' => 'Kader Makesta IPPNU 2022',
            ],
            [
                'banom_id' => $banoms['IPPNU']->id,
                'nomor_anggota' => 'NIA-IPPNU-3522-002',
                'nama_lengkap' => 'Dewi Masitoh',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Tuban',
                'tanggal_lahir' => '2007-02-15',
                'alamat' => 'Dusun Krajan RT 04 RW 01, Desa Banjaranyar',
                'nomor_telepon' => '082245678902',
                'email' => 'dewi.masitoh@gmail.com',
                'status' => 'Aktif',
                'jabatan' => 'Bendahara',
                'tahun_masuk' => 2023,
                'keterangan' => 'Kader Makesta 2023',
            ],

            // FATAYAT
            [
                'banom_id' => $banoms['FATAYAT']->id,
                'nomor_anggota' => 'NIA-FAT-3522-001',
                'nama_lengkap' => 'Siti Mar\'atun Sholihah, S.Pd',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bojonegoro',
                'tanggal_lahir' => '1992-06-18',
                'alamat' => 'Dusun Krajan RT 03 RW 01, Desa Banjaranyar',
                'nomor_telepon' => '082356789012',
                'email' => 'maratun.fatayat@gmail.com',
                'status' => 'Aktif',
                'jabatan' => 'Ketua Ranting',
                'tahun_masuk' => 2018,
                'keterangan' => 'Kader LKD Fatayat NU',
            ],
            [
                'banom_id' => $banoms['FATAYAT']->id,
                'nomor_anggota' => 'NIA-FAT-3522-002',
                'nama_lengkap' => 'Umi Kulsum, S.E',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Lamongan',
                'tanggal_lahir' => '1994-09-25',
                'alamat' => 'Dusun Banjar RT 06 RW 02, Desa Banjaranyar',
                'nomor_telepon' => '082356789013',
                'email' => 'umi.kulsum@gmail.com',
                'status' => 'Aktif',
                'jabatan' => 'Sekretaris',
                'tahun_masuk' => 2019,
                'keterangan' => 'Penggerak Diba\'iyah',
            ],

            // ANSOR
            [
                'banom_id' => $banoms['ANSOR']->id,
                'nomor_anggota' => 'NIA-ANS-3522-001',
                'nama_lengkap' => 'Ahmad Ridwan, S.Sos',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bojonegoro',
                'tanggal_lahir' => '1990-03-10',
                'alamat' => 'Dusun Krajan RT 01 RW 01, Desa Banjaranyar',
                'nomor_telepon' => '081378901201',
                'email' => 'ridwan.ansor@gmail.com',
                'status' => 'Aktif',
                'jabatan' => 'Ketua Ranting',
                'tahun_masuk' => 2015,
                'keterangan' => 'Kader PKD Ansor 2016',
            ],
            [
                'banom_id' => $banoms['ANSOR']->id,
                'nomor_anggota' => 'NIA-ANS-3522-002',
                'nama_lengkap' => 'Mohammad Syarifudin',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bojonegoro',
                'tanggal_lahir' => '1993-12-05',
                'alamat' => 'Dusun Kauman RT 03 RW 03, Desa Banjaranyar',
                'nomor_telepon' => '081378901202',
                'email' => 'syarif.ansor@gmail.com',
                'status' => 'Aktif',
                'jabatan' => 'Wakil Ketua',
                'tahun_masuk' => 2017,
                'keterangan' => 'Kader PKD Ansor 2017',
            ],

            // BANSER
            [
                'banom_id' => $banoms['BANSER']->id,
                'nomor_anggota' => 'NTA-BSR-3522-001',
                'nama_lengkap' => 'Sugeng Prayitno',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bojonegoro',
                'tanggal_lahir' => '1987-07-22',
                'alamat' => 'Dusun Banjar RT 07 RW 02, Desa Banjaranyar',
                'nomor_telepon' => '081289012301',
                'email' => 'sugeng.banser@gmail.com',
                'status' => 'Aktif',
                'jabatan' => 'Kepala Satkorkel',
                'tahun_masuk' => 2012,
                'keterangan' => 'Kader Diklatsar Banser 2012',
            ],
            [
                'banom_id' => $banoms['BANSER']->id,
                'nomor_anggota' => 'NTA-BSR-3522-002',
                'nama_lengkap' => 'Joko Wahyudi',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bojonegoro',
                'tanggal_lahir' => '1989-10-14',
                'alamat' => 'Dusun Krajan RT 05 RW 01, Desa Banjaranyar',
                'nomor_telepon' => '081289012302',
                'email' => 'joko.banser@gmail.com',
                'status' => 'Aktif',
                'jabatan' => 'Wakil Komandan',
                'tahun_masuk' => 2014,
                'keterangan' => 'Kader Diklatsar Banser 2014',
            ],
        ];

        foreach ($members as $data) {
            Member::updateOrCreate(
                ['nomor_anggota' => $data['nomor_anggota']],
                $data
            );
        }
    }
}
