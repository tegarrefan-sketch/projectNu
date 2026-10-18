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
        'is_anonim',
        'kategori',
        'subjek',
        'pesan',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
    ];

    /**
     * Generate format kode tiket baru yang tidak bisa ditebak (unpredictable).
     * Format: ASP-YYYYMMDD-XXXXXX (contoh: ASP-20261017-X7K2Q9)
     * Bagian akhir acak minimal 6 karakter alfanumerik kapital dan dijamin unik.
     */
    public static function generateTiket(): string
    {
        $date = date('Ymd');
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $maxIdx = strlen($chars) - 1;

        do {
            $random = '';
            for ($i = 0; $i < 6; $i++) {
                $random .= $chars[random_int(0, $maxIdx)];
            }
            $code = "ASP-{$date}-{$random}";
        } while (static::withTrashed()->where('kode_tiket', $code)->exists());

        return $code;
    }

    /**
     * Samarkan kode tiket untuk tampilan fitur "Lupa Nomor Tiket".
     * Contoh: ASP-20261017-X7K2Q9 -> ASP-2026••••-X7K2
     * Format lama: ASP-2026-00001 -> ASP-2026-••••1
     */
    public static function maskKodeTiket(string $kode): string
    {
        // Format baru ASP-YYYYMMDD-XXXXXX -> ASP-YYYY••••-XXXX
        if (preg_match('/^ASP-(\d{4})\d{4}-([A-Z0-9]{4})[A-Z0-9]*$/', $kode, $m)) {
            return "ASP-{$m[1]}••••-{$m[2]}";
        }

        // Format alternatif dengan tanggal: ASP-YYYYMMDD-...
        if (preg_match('/^ASP-(\d{4})\d{4}-(.*)$/', $kode, $m)) {
            $sub = substr($m[2], 0, 4);
            return "ASP-{$m[1]}••••-{$sub}";
        }

        // Format lama ASP-YYYY-00001 -> ASP-YYYY-••••1
        if (preg_match('/^ASP-(\d{4})-(.*)$/', $kode, $m)) {
            $tail = $m[2];
            $lastChar = substr($tail, -1);
            return "ASP-{$m[1]}-••••{$lastChar}";
        }

        // Fallback jika format berbeda
        if (strlen($kode) > 8) {
            return substr($kode, 0, 4) . '••••' . substr($kode, -4);
        }

        return substr($kode, 0, 2) . '••••';
    }

    /**
     * Accessor untuk mendapatkan kode tersamar.
     */
    public function getMaskedKodeAttribute(): string
    {
        return static::maskKodeTiket($this->kode_tiket);
    }

    /**
     * Normalisasi nomor telepon / WhatsApp untuk pencarian.
     */
    public static function cleanPhoneNumber(?string $phone): string
    {
        if (empty($phone)) {
            return '';
        }

        $digits = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($digits, '62')) {
            $digits = '0' . substr($digits, 2);
        }

        return $digits;
    }
}
