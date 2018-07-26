<?php

use Xervice\DataProvider\DataProviderConfig;
use Xervice\RabbitMQ\RabbitMQConfig;

$config[DataProviderConfig::DATA_PROVIDER_GENERATED_PATH] = dirname(__DIR__) . '/src/Generated';
$config[DataProviderConfig::DATA_PROVIDER_PATHS] = [
    dirname(__DIR__) . '/src/',
    dirname(__DIR__) . '/tests/',
    dirname(__DIR__) . '/vendor/'
];



if (class_exists(RabbitMQConfig::class)) {
    $config[RabbitMQConfig::CONNECTION_HOST] = '127.0.0.1';
    $config[RabbitMQConfig::CONNECTION_PORT] = '5672';
    $config[RabbitMQConfig::CONNECTION_USERNAME] = 'guest';
    $config[RabbitMQConfig::CONNECTION_PASSWORD] = 'guest';
    $config[RabbitMQConfig::CONNECTION_VIRTUALHOST] = '/';
    $config[RabbitMQConfig::CONNECTION_INSIST] = 'false';
    $config[RabbitMQConfig::CONNECTION_LOGIN_METHOD] = 'AMQPLAIN';
    $config[RabbitMQConfig::CONNECTION_LOCALE] = 'de_DE';
    $config[RabbitMQConfig::CONNECTION_CONNECTION_TIMEOUT] = 3.0;
    $config[RabbitMQConfig::CONNECTION_READWRITE_TIMEOUT] = 3.0;
    $config[RabbitMQConfig::CONNECTION_CONTEXT] = null;
    $config[RabbitMQConfig::CONNECTION_KEEPALIVE] = false;
    $config[RabbitMQConfig::CONNECTION_HEARTBEAT] = 0;
}