<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandang extends Model
{
    protected $fillable = [
        'name',
        'code',
        'image',
        'capacity',
        'timer_open',
        'timer_close'
    ];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function sensorData()
    {
        return $this->hasMany(SensorData::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
    public function setting()
    {
        return $this->hasOne(DeviceSetting::class);
    }
}
