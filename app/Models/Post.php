<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'banom_id',
        'kategori',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'author',
        'status',
        'published_at',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    public function banom(): BelongsTo
    {
        return $this->belongsTo(Banom::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
