<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    protected $table = 'sensor_data';

    protected $fillable = [
        'kandang_id',
        'device_id',
        'temperature',
        'chicken_detected',
        'chicken_in',
        'chicken_out'
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
