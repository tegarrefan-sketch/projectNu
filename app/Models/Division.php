<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    protected $fillable = [
        'banom_id',
        'nama',
        'urutan',
        'deskripsi',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function banom(): BelongsTo
    {
        return $this->belongsTo(Banom::class);
    }

    public function officers(): HasMany
    {
        return $this->hasMany(BanomOfficer::class, 'division_id')->orderBy('urutan');
    }
}
