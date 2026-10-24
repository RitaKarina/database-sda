<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $fillable = [
        'kode_kecamatan',
        'kabupaten',
        'nama_kecamatan',
    ];
}
