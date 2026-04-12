<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceSetting extends Model
{
    protected $fillable = [
        'kandang_id',
        'timer_open',
        'timer_close',
        'auto_mode',
        'notification_active',
        'temp_threshold'
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class);
    }
}
