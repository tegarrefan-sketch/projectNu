<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Kta extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'member_id',
        'nomor_kta',
        'tanggal_terbit',
        'tanggal_berlaku',
        'status',
        'foto',
        'keterangan',
        'qr_code_svg',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_berlaku' => 'date',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Generate unique KTA number based on BANOM and Year
     * Format: {SINGKATAN}-{YEAR}-{00001}
     */
    public static function generateKtaNumber(Member $member): string
    {
        $banomCode = strtoupper($member->banom->singkatan ?? 'NU');
        $year = date('Y');

        return DB::transaction(function () use ($banomCode, $year) {
            $prefix = "{$banomCode}-{$year}-";

            // Find max sequence for this prefix
            $latest = static::withTrashed()
                ->where('nomor_kta', 'LIKE', "{$prefix}%")
                ->lockForUpdate()
                ->orderByDesc('id')
                ->first();

            $sequence = 1;
            if ($latest && preg_match('/-(\d+)$/', $latest->nomor_kta, $matches)) {
                $sequence = (int) $matches[1] + 1;
            }

            $number = sprintf('%s%05d', $prefix, $sequence);

            // Double check uniqueness
            while (static::withTrashed()->where('nomor_kta', $number)->exists()) {
                $sequence++;
                $number = sprintf('%s%05d', $prefix, $sequence);
            }

            return $number;
        });
    }
}
