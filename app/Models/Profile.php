<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'nama_organisasi',
        'tingkat',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'deskripsi_singkat',
        'sejarah',
        'visi',
        'misi',
        'tujuan',
        'nilai_organisasi',
        'alamat',
        'kontak_email',
        'kontak_telepon',
        'sk_nomor',
        'masa_khidmat',
        'logo',
        'hero_image',
    ];

    /**
     * Singleton instance helper
     */
    public static function current(): self
    {
        return static::firstOrCreate([], [
            'nama_organisasi' => 'Nahdlatul Ulama Ranting Banjaranyar',
            'tingkat' => 'Desa / Ranting',
            'kecamatan' => 'Baureno',
            'kabupaten' => 'Bojonegoro',
            'provinsi' => 'Jawa Timur',
            'deskripsi_singkat' => 'Pusat informasi resmi Nahdlatul Ulama Ranting Banjaranyar, Kecamatan Baureno, Kabupaten Bojonegoro. Mengokohkan pilar Ahlussunnah wal Jama\'ah An-Nahdliyyah demi keharmonisan sosial dan kemandirian warga desa.',
            'alamat' => 'Jl. Raya Banjaranyar, Kec. Baureno, Kab. Bojonegoro, Jawa Timur 62192',
            'kontak_email' => 'sekretariat@nu-banjaranyar.or.id',
            'kontak_telepon' => '+62 812-3456-7890',
            'sk_nomor' => '184/A.II/PC/SK/VIII/2023',
            'masa_khidmat' => '2023 - 2028',
        ]);
    }
}
