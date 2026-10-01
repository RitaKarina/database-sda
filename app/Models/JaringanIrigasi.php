<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JaringanIrigasi extends Model
{
    protected $guarded = ['id'];

    public function daerahIrigasi()
    {
        return $this->belongsTo(DaerahIrigasi::class);
    }
}