<?php


namespace XerviceTest\RabbitMQ\Exchange;


use DataProvider\RabbitMqExchangeDataProvider;
use Xervice\RabbitMQ\Core\ExchangeProviderInterface;
use Xervice\RabbitMQ\Exchange\ExchangeInterface;

class TestExchange implements ExchangeInterface
{
    /**
     * @param \Xervice\RabbitMQ\Core\ExchangeProviderInterface $exchangeProvider
     */
    public function declareExchange(ExchangeProviderInterface $exchangeProvider)
    {
        $testExchange = new RabbitMqExchangeDataProvider();
        $testExchange
            ->setName('UnitTest')
            ->setType('direct');

        $exchangeProvider->declare($testExchange);
    }

}