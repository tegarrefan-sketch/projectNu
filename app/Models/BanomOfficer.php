<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BanomOfficer extends Model
{
    use HasFactory;

    protected $fillable = [
        'banom_id',
        'position_id',
        'division_id',
        'member_id',
        'nama',
        'bidang',
        'foto',
        'urutan',
        'urutan_wakil',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'urutan_wakil' => 'integer',
    ];

    public function banom(): BelongsTo
    {
        return $this->belongsTo(Banom::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getDisplayNamaAttribute(): string
    {
        if ($this->member_id && $this->relationLoaded('member') && $this->member) {
            return $this->member->nama_lengkap;
        }
        return $this->nama ?: ($this->member?->nama_lengkap ?? '-');
    }

    public function getDisplayJabatanAttribute(): string
    {
        $namaJabatan = $this->position?->nama ?? 'Pengurus';
        if ($this->urutan_wakil && str_contains(strtolower($namaJabatan), 'wakil')) {
            $namaJabatan .= ' ' . $this->urutan_wakil;
        }
        $bagian = $this->division?->nama ?? $this->bidang;
        if ($bagian && (str_contains(strtolower($namaJabatan), 'bidang') || str_contains(strtolower($namaJabatan), 'unit') || str_contains(strtolower($namaJabatan), 'departemen') || str_contains(strtolower($namaJabatan), 'seksi') || str_contains(strtolower($namaJabatan), 'anggota'))) {
            return $namaJabatan . ' ' . $bagian;
        }
        return $namaJabatan;
    }

    public function getDisplayFotoAttribute(): ?string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        if ($this->member_id && $this->member?->foto) {
            return asset('storage/' . $this->member->foto);
        }
        return null;
    }
}
