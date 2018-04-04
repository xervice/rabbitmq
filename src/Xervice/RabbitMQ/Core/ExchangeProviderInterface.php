<?php

namespace Xervice\RabbitMQ\Core;

use DataProvider\RabbitMqExchangeDataProvider;

interface ExchangeProviderInterface
{
    /**
     * @param string $name
     * @param string $type
     * @param bool $passive
     * @param bool $durable
     * @param bool $auto_delete
     * @param bool $internal
     * @param bool $nowait
     */
    public function declare(RabbitMqExchangeDataProvider $exchangeDataProvider);
}