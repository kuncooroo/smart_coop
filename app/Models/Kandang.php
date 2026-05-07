<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandang extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'code',
        'image',
        'capacity',
        'current_chicken',
        'timer_open',
        'timer_close'
    ];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
    public function setting()
    {
        return $this->hasOne(DeviceSetting::class, 'kandang_id')->withDefault([
            'auto_mode' => true,
            'timer_open' => '06:00:00',
            'timer_close' => '18:00:00',
            'temp_threshold' => 30.00
        ]);
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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
