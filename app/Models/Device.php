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

    protected $casts = [
        'last_updated' => 'datetime',
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
    public function deteksis()
    {
        return $this->hasMany(Deteksi::class);
    }

    public function suhus()
    {
        return $this->hasMany(Suhu::class);
    }
    public function ayams()
    {
        return $this->hasMany(Ayam::class);
    }
}
