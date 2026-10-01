<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perencanaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'usulan_kegiatan',
        'status_ded',
        'status_rc',
        'kategori_perencanaan',
        'tahun_perencanaan'
    ];
}