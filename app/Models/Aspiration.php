<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aspiration extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_tiket',
        'nama',
        'kontak',
        'kategori',
        'subjek',
        'pesan',
        'status',
        'catatan_admin',
    ];

    public static function generateTiket(): string
    {
        $year = date('Y');
        $prefix = "ASP-{$year}-";

        $latest = static::withTrashed()
            ->where('kode_tiket', 'LIKE', "{$prefix}%")
            ->orderByDesc('id')
            ->first();

        $sequence = 1;
        if ($latest && preg_match('/-(\d+)$/', $latest->kode_tiket, $matches)) {
            $sequence = (int) $matches[1] + 1;
        }

        $code = sprintf('%s%05d', $prefix, $sequence);
        while (static::withTrashed()->where('kode_tiket', $code)->exists()) {
            $sequence++;
            $code = sprintf('%s%05d', $prefix, $sequence);
        }

        return $code;
    }
}
