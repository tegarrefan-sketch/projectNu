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
        'urutan',
    ];

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
}
