<?php

use Xervice\DataProvider\DataProviderConfig;

$config[DataProviderConfig::DATA_PROVIDER_GENERATED_PATH] = dirname(__DIR__) . '/src/Generated';
$config[DataProviderConfig::DATA_PROVIDER_PATHS] = [
    dirname(__DIR__) . '/src/*/*/Schema',
    dirname(__DIR__) . '/vendor/xervice/*/src/*/*/Schema'
];
