<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banom extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'singkatan',
        'slug',
        'logo',
        'deskripsi',
        'sejarah',
        'visi',
        'misi',
        'kontak',
        'alamat',
        'status',
        'warna_primer',
        'warna_sekunder',
        'kategori',
        'rentang_usia',
        'label_bagian',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class)->orderBy('urutan');
    }

    public function banomOfficers(): HasMany
    {
        return $this->hasMany(BanomOfficer::class)->orderBy('urutan');
    }

    public function officers(): HasMany
    {
        return $this->hasMany(BanomOfficer::class)->orderBy('urutan');
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function organizationStructures(): HasMany
    {
        return $this->hasMany(OrganizationStructure::class)->orderBy('urutan');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->orderByDesc('published_at');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class)->orderBy('tanggal');
    }

    public function getActiveMembersCountAttribute(): int
    {
        return $this->members()->where('status', 'Aktif')->count();
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if ($field) {
            return $this->where($field, $value)->first();
        }

        if (is_numeric($value)) {
            return $this->where('id', $value)->first();
        }

        return $this->where('slug', $value)
            ->orWhereRaw('LOWER(singkatan) = ?', [strtolower($value)])
            ->orWhere('id', $value)
            ->first();
    }
}
