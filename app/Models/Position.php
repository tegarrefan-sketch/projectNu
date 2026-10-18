<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori',
        'tipe',
        'maks_orang',
        'batas_keras',
        'anjuran_maks',
        'urutan',
        'urutan_hierarki',
        'keterangan',
    ];

    protected $casts = [
        'maks_orang' => 'integer',
        'batas_keras' => 'boolean',
        'anjuran_maks' => 'integer',
        'urutan' => 'integer',
        'urutan_hierarki' => 'integer',
    ];

    public function isTanpaBatas(): bool
    {
        return is_null($this->maks_orang) && !$this->batas_keras;
    }

    public function isBatasKeras(): bool
    {
        return (bool) $this->batas_keras;
    }

    public function hasAnjuran(): bool
    {
        return !is_null($this->anjuran_maks) && $this->anjuran_maks > 0;
    }

    public function banomOfficers(): HasMany
    {
        return $this->hasMany(BanomOfficer::class);
    }

    /**
     * Get positions relevant for a specific Banom or Ranting.
     */
    public static function forBanom(Banom $banom)
    {
        if ($banom->kategori === 'ranting') {
            return static::whereIn('kategori', ['Mustasyar', 'Syuriyah', 'Tanfidziyah'])
                ->orderBy('urutan')
                ->get();
        }

        if (str_contains(strtoupper($banom->singkatan), 'BANSER')) {
            return static::where(function ($q) {
                $q->whereIn('nama', [
                    'Kepala Satkorkel (Kasatkorkel)',
                    'Wakil Kepala Satkorkel (Wakasatkorkel)',
                    'Kepala Satuan Markas (Kasamarkel)',
                    'Kepala Unit/Biro',
                    'Anggota Pasukan',
                    'Pembina/Penasihat',
                ])->orWhere('kategori', 'Bidang');
            })->orderBy('urutan')->get();
        }

        return static::whereIn('kategori', ['Banom', 'Bidang'])
            ->whereNotIn('nama', [
                'Kepala Satkorkel (Kasatkorkel)',
                'Wakil Kepala Satkorkel (Wakasatkorkel)',
                'Kepala Satuan Markas (Kasamarkel)',
                'Anggota Pasukan',
            ])
            ->orderBy('urutan')
            ->get();
    }
}
