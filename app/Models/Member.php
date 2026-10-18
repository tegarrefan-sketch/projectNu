<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
        'status_keanggotaan',
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

    public function officers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BanomOfficer::class);
    }

    public function activeOfficer(): HasOne
    {
        return $this->hasOne(BanomOfficer::class)->where('is_active', true)->latest('id');
    }

    public function getHasKtaAttribute(): bool
    {
        return $this->kta()->exists();
    }

    /**
     * Format jabatan resmi untuk KTA (tampilan, cetak, dan PDF).
     * Jika terhubung sebagai pengurus aktif: "Ketua - PR IPNU".
     * Jika bukan pengurus aktif: Status Keanggotaan (Anggota, Kader, Simpatisan).
     */
    public function getJabatanKtaAttribute(): string
    {
        $officer = $this->relationLoaded('activeOfficer')
            ? $this->activeOfficer
            : $this->activeOfficer()->with(['position', 'banom', 'division'])->first();

        if ($officer && $officer->is_active && $officer->position) {
            $posName = $officer->display_jabatan;
            $orgName = match (strtoupper($officer->banom?->singkatan ?? '')) {
                'IPNU' => 'PR IPNU',
                'IPPNU' => 'PR IPPNU',
                'ANSOR' => 'PR GP Ansor',
                'FATAYAT' => 'PR Fatayat NU',
                'MUSLIMAT' => 'PR Muslimat NU',
                'BANSER' => 'Satkorkel Banser',
                'PRNU' => 'PRNU',
                default => $officer->banom?->singkatan ?? 'PRNU',
            };
            return "{$posName} - {$orgName}";
        }

        return $this->status_keanggotaan ?: 'Anggota';
    }

    /**
     * Aksesor kompatibilitas untuk pemanggilan $member->jabatan
     */
    public function getJabatanAttribute($value): string
    {
        return $this->getJabatanKtaAttribute();
    }

    /**
     * Generate nomor anggota unik dengan proteksi collision terhadap soft-deleted records.
     * Format: NIA-{SINGKATAN}-{TAHUN}-{0001}
     */
    public static function generateMemberNumber(Banom $banom, ?int $year = null): string
    {
        $year = $year ?? (int) date('Y');
        $singkatan = strtoupper(trim($banom->singkatan ?? 'NU'));
        $prefix = sprintf('NIA-%s-%s-', $singkatan, $year);

        return DB::transaction(function () use ($prefix, $banom) {
            $latest = static::withTrashed()
                ->where('nomor_anggota', 'LIKE', "{$prefix}%")
                ->orderBy('nomor_anggota', 'desc')
                ->lockForUpdate()
                ->first();

            $sequence = 1;
            if ($latest && preg_match('/-(\d+)$/', $latest->nomor_anggota, $matches)) {
                $sequence = (int) $matches[1] + 1;
            } else {
                $sequence = static::withTrashed()->where('banom_id', $banom->id)->count() + 1;
            }

            $number = sprintf('%s%04d', $prefix, $sequence);

            while (static::withTrashed()->where('nomor_anggota', $number)->exists()) {
                $sequence++;
                $number = sprintf('%s%04d', $prefix, $sequence);
            }

            return $number;
        });
    }
}
