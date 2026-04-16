<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $fillable = ['kota_id', 'name'];

    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }
}
