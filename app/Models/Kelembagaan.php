<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelembagaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lembaga',
        'jenis_lembaga',
        'nomor_sk',
        'status_keaktifan',
        'tusi',
        'data_rtt',
        'data_raat'
    ];
}