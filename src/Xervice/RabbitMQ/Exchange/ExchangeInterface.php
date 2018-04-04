<?php


namespace Xervice\RabbitMQ\Exchange;


use Xervice\RabbitMQ\Core\ExchangeProviderInterface;

interface ExchangeInterface
{
    /**
     * @param \Xervice\RabbitMQ\Core\ExchangeProviderInterface $exchangeProvider
     */
    public function declareExchange(ExchangeProviderInterface $exchangeProvider);
}