<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'kandang_id',
        'device_id',
        'device_name',
        'device_type',
        'profile_image',
        'status',
        'door_status',
        'light_status',
        'last_updated'
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }

    public function sensorData()
    {
        return $this->hasMany(SensorData::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
