<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\MqttService;

Route::post('/servo/open', function () {

    MqttService::publish('kandang/servo', 'OPEN');

    return response()->json([
        'status' => 'success'
    ]);
});

Route::post('/servo/close', function () {

    MqttService::publish('kandang/servo', 'CLOSE');

    return response()->json([
        'status' => 'success'
    ]);
});

Route::post('/lamp/on', function () {

    MqttService::publish('kandang/lamp', 'ON');

    return response()->json([
        'status' => 'success'
    ]);
});

Route::post('/lamp/off', function () {

    MqttService::publish('kandang/lamp', 'OFF');

    return response()->json([
        'status' => 'success'
    ]);
});