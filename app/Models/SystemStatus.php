<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemStatus extends Model
{
    protected $table = 'system_status';

    protected $primaryKey = 'device_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'device_id',
        'door_status',
        'light_status'
    ];
}
