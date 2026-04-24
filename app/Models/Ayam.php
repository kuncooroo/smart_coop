<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayam extends Model
{
    protected $fillable = [
        'kandang_id',
        'direction',
        'source'
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }
}
