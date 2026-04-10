<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoorTimer extends Model
{
    protected $fillable = [
        'device_id', 'open_time', 'close_time', 'enabled'
    ];
}