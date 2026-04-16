<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $fillable = ['provinsi_id', 'name'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function Kecamantan()
    {
        return $this->hasMany(Kecamatan::class);
    }
}
