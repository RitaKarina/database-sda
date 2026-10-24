<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DaerahIrigasiKelembagaan extends Model
{
    protected $fillable = [
        'jenis_kelembagaan',
        'nama_kelembagaan',
        'ruas',
    ];

    public function daerahIrigasi(): BelongsTo
    {
        return $this->belongsTo(DaerahIrigasi::class);
    }
}
