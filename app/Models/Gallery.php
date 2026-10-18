<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'tanggal',
        'lokasi',
        'cover',
        'kategori',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('urutan');
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('status', 'Publik')
            ->orderByDesc('tanggal');
    }
}
