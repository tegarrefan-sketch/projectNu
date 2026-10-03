<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'nama_organisasi' => 'Pengurus Ranting Nahdlatul Ulama Desa Banjaranyar',
                'tingkat' => 'Ranting (Tingkat Desa)',
                'kecamatan' => 'Baureno',
                'kabupaten' => 'Bojonegoro',
                'provinsi' => 'Jawa Timur',
                'deskripsi_singkat' => 'Pusat khidmah jam\'iyyah dan jemaah Nahdlatul Ulama Ranting Banjaranyar, Kecamatan Baureno, Kabupaten Bojonegoro. Mengokohkan pilar Ahlussunnah wal Jama\'ah An-Nahdliyyah demi keharmonisan sosial, spiritualitas berkah, dan kemandirian warga desa.',
                'sejarah' => "Nahdlatul Ulama (NU) Ranting Banjaranyar telah berakar kuat di tengah masyarakat agraris dan santri Desa Banjaranyar sejak era perintisan oleh para kiai sepuh desa pada pertengahan abad ke-20. Sebagai basis tradisi pesantren dan amaliyah Aswaja, PRNU Banjaranyar senantiasa menjadi jangkar kedamaian sosial, perekat ukhuwah islamiyyah, wathaniyyah, dan basyariyyah.

Melalui sinergi dwitunggal kepemimpinan Syuriyah dan Tanfidziyah, PRNU Banjaranyar terus bertransformasi mengimbangi dinamika zaman tanpa tercerabut dari sanad keilmuan ulama salafush sholih. Dari pengajian selapanan keliling musholla, pembinaan generasi muda melalui IPNU-IPPNU dan Ansor-Banser, hingga pemberdayaan ekonomi umat lewat LAZISNU.",
                'visi' => 'Terwujudnya tatanan masyarakat Desa Banjaranyar yang religius, berkarakter Ahlussunnah wal Jama\'ah An-Nahdliyyah, mandiri secara ekonomi, rukun, serta berdaya dalam kemaslahatan umat.',
                'misi' => "1. Meneguhkan pengamalan akidah, syariah, dan akhlak berlandaskan madzhab Ahlussunnah wal Jama'ah An-Nahdliyyah di seluruh lapisan warga desa.
2. Memakmurkan masjid dan musholla melalui kegiatan dakwah, kajian kitab kuning, tahlil, istighotsah, dan pembacaan shalawat rutin.
3. Memperkuat kaderisasi berkelanjutan melalui 5 Badan Otonom (IPNU, IPPNU, Fatayat NU, GP Ansor, dan Satkorkel Banser).
4. Mendorong kemandirian ekonomi umat melalui optimalisasi Koin Infaq LAZISNU dan jejaring kepedulian sosial fakir miskin.
5. Menyelenggarakan tata kelola organisasi yang transparan, akuntabel, dan berbasis digital melalui SIMNU Banjaranyar.",
                'tujuan' => 'Mewujudkan khidmah sejati kepada jemaah dan jam\'iyyah Nahdlatul Ulama demi tercapainya kemaslahatan duniawi dan ukhrawi.',
                'nilai_organisasi' => 'Tawassuth (Moderat), Tawazun (Seimbang), Tasamuh (Toleran), I\'tidal (Tegak Lurus/Adil), dan Amar Ma\'ruf Nahi Munkar.',
                'alamat' => 'Gedung Sekretariat Bersama PRNU Banjaranyar, Jl. Raya Banjaranyar No. 45, Kec. Baureno, Kab. Bojonegoro, Jawa Timur 62192',
                'kontak_email' => 'sekretariat@nu-banjaranyar.or.id',
                'kontak_telepon' => '+62 857-3210-9876',
                'sk_nomor' => '184/A.II/PC/SK/VIII/2023',
                'masa_khidmat' => '2023 - 2028',
                'logo' => null,
                'hero_image' => null,
            ]
        );
    }
}
