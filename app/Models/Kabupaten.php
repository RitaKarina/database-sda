<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $guarded = ['id'];

    public function daerahIrigasis()
    {
        return $this->hasMany(DaerahIrigasi::class);
    }

    public function embungs()
    {
        return $this->hasMany(Embung::class);
    }
}