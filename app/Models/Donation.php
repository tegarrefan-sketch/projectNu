<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_transaksi',
        'nama_donatur',
        'is_anonim',
        'nomor_whatsapp',
        'nominal',
        'metode_pembayaran',
        'pesan_doa',
        'bukti_transfer',
        'status',
        'catatan_admin',
        'verified_at',
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
        'nominal' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    public static function generateKode(): string
    {
        $prefix = 'INF-' . date('Ymd');
        $random = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
        $count = static::whereDate('created_at', today())->count() + 1;
        return sprintf('%s-%03d-%s', $prefix, $count, $random);
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('status', 'Terverifikasi');
    }
}
