<?php

namespace Xervice\RabbitMQ\Core;

use DataProvider\RabbitMqExchangeDataProvider;

interface ExchangeProviderInterface
{
    /**
     * @param \DataProvider\RabbitMqExchangeDataProvider $exchangeDataProvider
     */
    public function declare(RabbitMqExchangeDataProvider $exchangeDataProvider): void;

    /**
     * @param \DataProvider\RabbitMqExchangeDataProvider $exchangeDataProvider
     */
    public function delete(RabbitMqExchangeDataProvider $exchangeDataProvider): void;
}