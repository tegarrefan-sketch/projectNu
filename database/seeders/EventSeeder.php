<?php

namespace Database\Seeders;

use App\Models\Banom;
use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $banoms = Banom::all()->keyBy('singkatan');

        $events = [
            [
                'banom_id' => null,
                'title' => 'Pengajian Rutin Selapanan Ahad Kliwon PRNU Banjaranyar',
                'slug' => 'pengajian-rutin-selapanan-ahad-kliwon-prnu-banjaranyar',
                'description' => 'Pembacaan Dzikir Tahlil, Istighotsah akbar, Mauidhoh Hasanah oleh Rais Syuriyah, serta penyerahan santunan koin LAZISNU untuk santri berprestasi desa.',
                'tanggal' => now()->addDays(5)->toDateString(),
                'waktu_mulai' => '06:00:00',
                'waktu_selesai' => '08:30:00',
                'lokasi' => 'Masjid Jami\' Baitul Muttaqin, Dusun Krajan Banjaranyar',
                'status' => 'Akan Datang',
            ],
            [
                'banom_id' => null,
                'title' => 'Istighotsah Kubro & Dzikir Bersama Malam Jumat Legi',
                'slug' => 'istighotsah-kubro-dzikir-bersama-malam-jumat-legi',
                'description' => 'Majelis doa bersama untuk kemaslahatan, ketentraman desa, dan arwah para sesepuh perintis Nahdlatul Ulama Desa Banjaranyar.',
                'tanggal' => now()->addDays(11)->toDateString(),
                'waktu_mulai' => '19:30:00',
                'waktu_selesai' => '21:30:00',
                'lokasi' => 'Gedung Bersama PRNU Banjaranyar',
                'status' => 'Akan Datang',
            ],
            [
                'banom_id' => null,
                'title' => 'Kajian Kitab Fathul Qorib & Forum Bahtsul Masail Ranting',
                'slug' => 'kajian-kitab-fathul-qorib-bahtsul-masail-ranting',
                'description' => 'Pendalaman hukum fiqih seputar muamalah kontemporer bersama jajaran Asatidz dan Majelis Syuriyah PRNU Banjaranyar.',
                'tanggal' => now()->addDays(16)->toDateString(),
                'waktu_mulai' => '20:00:00',
                'waktu_selesai' => '22:00:00',
                'lokasi' => 'Musholla Al-Ikhlas, Dusun Kauman',
                'status' => 'Akan Datang',
            ],
            [
                'banom_id' => $banoms['IPNU']?->id,
                'title' => 'Latihan Rutin Hadrah & Sholawat Kolaborasi IPNU-IPPNU',
                'slug' => 'latihan-rutin-hadrah-sholawat-ipnu-ippnu',
                'description' => 'Asah bakat seni rebana dan vokal shalawat pelajar NU menyongsong peringatan Hari Santri Nasional.',
                'tanggal' => now()->addDays(7)->toDateString(),
                'waktu_mulai' => '19:00:00',
                'waktu_selesai' => '21:00:00',
                'lokasi' => 'Aula Pertemuan Gedung Bersama PRNU Lt. 2',
                'status' => 'Akan Datang',
            ],
            [
                'banom_id' => $banoms['BANSER']?->id,
                'title' => 'Kursus Latihan Lapangan & Kebugaran Fisik Satkorkel Banser',
                'slug' => 'kursus-latihan-lapangan-satkorkel-banser',
                'description' => 'Pemantapan keterampilan baris-berbaris, pertolongan pertama pada kecelakaan (PPGD), dan simulasi pengamanan lalu lintas pengajian.',
                'tanggal' => now()->addDays(14)->toDateString(),
                'waktu_mulai' => '15:30:00',
                'waktu_selesai' => '17:30:00',
                'lokasi' => 'Lapangan Desa Banjaranyar',
                'status' => 'Akan Datang',
            ],
        ];

        foreach ($events as $item) {
            Event::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
