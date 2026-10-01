<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sungai extends Model
{
    use HasFactory;

    protected $table = 'sungai';

    protected $fillable = [
        'nama_sungai',
        'panjang_km',
        'lokasi',
    ];
}