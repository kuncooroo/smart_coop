<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $fillable = ['name'];

    public function Kota()
    {
        return $this->hasMany(Kota::class);
    }
}
