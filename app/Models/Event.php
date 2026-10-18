<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'banom_id',
        'title',
        'slug',
        'description',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'thumbnail',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function banom(): BelongsTo
    {
        return $this->belongsTo(Banom::class);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('tanggal', '>=', now()->toDateString())
            ->where('status', '!=', 'Dibatalkan')
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai');
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->where('tanggal', '<', now()->toDateString())
            ->where('status', '!=', 'Dibatalkan')
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu_mulai');
    }
}
