<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'banom_id',
        'nomor_anggota',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nomor_telepon',
        'email',
        'status',
        'jabatan',
        'tahun_masuk',
        'foto',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tahun_masuk' => 'integer',
    ];

    public function banom(): BelongsTo
    {
        return $this->belongsTo(Banom::class);
    }

    public function kta(): HasOne
    {
        return $this->hasOne(Kta::class);
    }

    public function getHasKtaAttribute(): bool
    {
        return $this->kta()->exists();
    }
}
