<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deteksi extends Model
{
    protected $fillable = [
        'kandang_id',
        'device_id',
        'object',
        'confidence',
        'is_valid',
        'image',
        'boxes'
    ];

    protected $casts = [
        'objects' => 'array',
        'boxes' => 'array',
        'is_valid' => 'boolean',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
