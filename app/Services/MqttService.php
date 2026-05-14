<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;

class MqttService
{
    public static function publish($topic, $message)
    {
        $server = '127.0.0.1';
        $port = 1883;

        $clientId = 'laravel_' . uniqid();

        $mqtt = new MqttClient($server, $port, $clientId);

        $mqtt->connect();

        $mqtt->publish($topic, $message);

        $mqtt->disconnect();
    }
}