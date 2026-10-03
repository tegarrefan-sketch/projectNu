<?php

namespace Database\Seeders;

use App\Models\Aspiration;
use Illuminate\Database\Seeder;

class AspirationSeeder extends Seeder
{
    public function run(): void
    {
        $aspirations = [
            [
                'kode_tiket' => 'ASP-2026-00001',
                'nama' => 'H. M. Sholihin',
                'kontak' => '081234567890',
                'kategori' => 'Saran',
                'subjek' => 'Saran Penambahan Penerangan Akses Musholla Dusun Krajan',
                'pesan' => 'Assalamu\'alaikum Wr. Wb. Mohon izin memberikan saran agar jalan setapak menuju Musholla Nurul Huda Dusun Krajan diberikan tambahan lampu penerangan agar jemaah sepuh lebih aman saat sholat Isya dan Subuh. Terima kasih.',
                'status' => 'Diproses',
                'catatan_admin' => 'Telah dikoordinasikan dengan Banser dan pengurus Dusun Krajan untuk gotong royong pasang lampu LED.',
            ],
            [
                'kode_tiket' => 'ASP-2026-00002',
                'nama' => 'Ibu Sri Wahyuni',
                'kontak' => '082233445566',
                'kategori' => 'Aspirasi',
                'subjek' => 'Usulan Pelatihan Pembuatan Makanan Ringan untuk Fatayat & Warga',
                'pesan' => 'Mohon diadakan pelatihan wirausaha makanan olahan jagung atau singkong bersama ibu-ibu Fatayat agar membantu pemasukan keluarga di desa.',
                'status' => 'Dibaca',
                'catatan_admin' => 'Dipertimbangkan masuk ke program kerja semester dua Fatayat NU.',
            ],
            [
                'kode_tiket' => 'ASP-2026-00003',
                'nama' => 'Ahmad Rifa\'i',
                'kontak' => '085711223344',
                'kategori' => 'Pertanyaan',
                'subjek' => 'Prosedur Pembuatan KTA Fisik bagi Warga Lansia',
                'pesan' => 'Bagaimana cara mendaftarkan kakek kami untuk mendapatkan KTA NU fisik bila kakek tidak memiliki smartphone? Apakah bisa didaftarkan langsung di posko sekretariat?',
                'status' => 'Selesai',
                'catatan_admin' => 'Sudah dibalas via WhatsApp. Bisa datang langsung ke sekretariat setiap Ahad pagi untuk difotokan dan dicetak secara kolektif.',
            ],
        ];

        foreach ($aspirations as $item) {
            Aspiration::updateOrCreate(
                ['kode_tiket' => $item['kode_tiket']],
                $item
            );
        }
    }
}
