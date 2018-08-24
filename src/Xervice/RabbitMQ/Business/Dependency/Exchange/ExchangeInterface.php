<?php


namespace Xervice\RabbitMQ\Business\Dependency\Exchange;


use Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface;

interface ExchangeInterface
{
    /**
     * @param \Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface $exchangeProvider
     */
    public function declareExchange(ExchangeProviderInterface $exchangeProvider);
}