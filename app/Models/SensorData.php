<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    protected $table = 'sensor_data';

    protected $fillable = [
        'device_id',
        'temperature',
        'chicken_detected',
        'chicken_in',
        'chicken_out'
    ];
}
