<?php

namespace Database\Seeders;

use App\Models\Banom;
use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seed master data Bagian (Bidang, Unit/Biro, Seksi, Departemen) secara idempotent.
     */
    public function run(): void
    {
        $divisionsData = [
            // 1. GP Ansor: Bidang bawaan
            'ansor' => [
                ['nama' => 'Organisasi', 'urutan' => 1, 'deskripsi' => 'Penguatan tata kelola dan kelembagaan ranting'],
                ['nama' => 'Kaderisasi', 'urutan' => 2, 'deskripsi' => 'Pelatihan kepemimpinan dan perekrutan anggota baru'],
                ['nama' => 'Dakwah', 'urutan' => 3, 'deskripsi' => 'Majelis Dzikir dan Sholawat Rijalul Ansor'],
                ['nama' => 'Sosial', 'urutan' => 4, 'deskripsi' => 'Aksi kepedulian masyarakat dan bakti lingkungan'],
                ['nama' => 'Ekonomi', 'urutan' => 5, 'deskripsi' => 'Pengembangan kemandirian ekonomi pemuda'],
            ],
            // 2. SATKORKEL BANSER: Unit/Biro
            'banser' => [
                ['nama' => 'Lantas', 'urutan' => 1, 'deskripsi' => 'Pengaturan lalu lintas dan ketertiban jalan'],
                ['nama' => 'Protokoler', 'urutan' => 2, 'deskripsi' => 'Pengawalan kiai dan protokoler acara resmi'],
                ['nama' => 'Bagana', 'urutan' => 3, 'deskripsi' => 'Banser Tanggap Bencana dan kemanusiaan'],
            ],
            // 3. Fatayat NU: Bidang
            'fatayat' => [
                ['nama' => 'Pengembangan Organisasi', 'urutan' => 1, 'deskripsi' => 'Konsolidasi anggota dan keorganisasian'],
                ['nama' => 'Pendidikan', 'urutan' => 2, 'deskripsi' => 'Pendidikan anak usia dini dan wawasan keaswajaan'],
                ['nama' => 'Ekonomi', 'urutan' => 3, 'deskripsi' => 'Kemandirian wirausaha ibu muda'],
            ],
            // 4. Muslimat NU: Seksi
            'muslimat' => [
                ['nama' => 'Sosial', 'urutan' => 1, 'deskripsi' => 'Santunan yatim dan kepedulian dhuafa'],
                ['nama' => 'Kesehatan', 'urutan' => 2, 'deskripsi' => 'Posyandu lansia dan kesehatan keluarga'],
                ['nama' => 'Penerangan/Dakwah', 'urutan' => 3, 'deskripsi' => 'Majelis taklim dan pengajian shalawat akbar'],
            ],
            // 5. IPNU: Departemen
            'ipnu' => [
                ['nama' => 'Organisasi', 'urutan' => 1, 'deskripsi' => 'Administrasi dan koordinasi komisariat/ranting'],
                ['nama' => 'Kaderisasi', 'urutan' => 2, 'deskripsi' => 'MAKESTA dan pembinaan santri/pelajar'],
                ['nama' => 'Minat dan Bakat', 'urutan' => 3, 'deskripsi' => 'Olahraga, teknologi, dan seni shalawat'],
            ],
            // 6. IPPNU: Departemen
            'ippnu' => [
                ['nama' => 'Organisasi', 'urutan' => 1, 'deskripsi' => 'Konsolidasi pelajar putri dan administrasi'],
                ['nama' => 'Kaderisasi', 'urutan' => 2, 'deskripsi' => 'MAKESTA dan keputrian Aswaja'],
                ['nama' => 'Minat dan Bakat', 'urutan' => 3, 'deskripsi' => 'Literasi, kreativitas seni, dan kewirausahaan'],
            ],
        ];

        foreach ($divisionsData as $slug => $divisions) {
            $banom = Banom::where('slug', $slug)->first();
            if (!$banom) {
                continue;
            }

            foreach ($divisions as $d) {
                Division::updateOrCreate(
                    [
                        'banom_id' => $banom->id,
                        'nama' => $d['nama'],
                    ],
                    [
                        'urutan' => $d['urutan'],
                        'deskripsi' => $d['deskripsi'] ?? null,
                    ]
                );
            }
        }
    }
}
