<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationStructure extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'banom_id',
        'kategori_hierarki',
        'nama',
        'jabatan',
        'foto',
        'deskripsi',
        'urutan',
        'status',
    ];

    public function banom(): BelongsTo
    {
        return $this->belongsTo(Banom::class);
    }
}
