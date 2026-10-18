<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfaqSetting extends Model
{
    protected $fillable = [
        'nama_program',
        'deskripsi_program',
        'bank_utama_nama',
        'bank_utama_rekening',
        'bank_utama_atas_nama',
        'bank_kedua_nama',
        'bank_kedua_rekening',
        'bank_kedua_atas_nama',
        'qris_image',
        'nomor_whatsapp_konfirmasi',
        'pesan_amanah',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'nama_program' => 'Gerakan Infaq & Sedekah Koin LAZISNU Banjaranyar',
            'deskripsi_program' => 'Penyaluran infaq dan sedekah terpadu untuk kemakmuran dakwah, santunan yatim piatu, bantuan dhuafa, serta pemberdayaan umat ranting Banjaranyar.',
            'bank_utama_nama' => 'Bank Syariah Indonesia (BSI)',
            'bank_utama_rekening' => '7234567890',
            'bank_utama_atas_nama' => 'PRNU BANJARANYAR - LAZISNU',
            'bank_kedua_nama' => 'Bank Jatim',
            'bank_kedua_rekening' => '0123456789',
            'bank_kedua_atas_nama' => 'UPZIS LAZISNU BANJARANYAR',
            'nomor_whatsapp_konfirmasi' => '081234567890',
            'pesan_amanah' => 'Setiap rupiah infaq Anda dikelola secara amanah, akuntabel, dan transparan oleh UPZIS LAZISNU PRNU Banjaranyar demi kemaslahatan umat. Jazakumullah Khairan Katsiran.',
        ]);
    }
}
