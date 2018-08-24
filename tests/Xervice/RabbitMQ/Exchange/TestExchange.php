<?php


namespace XerviceTest\RabbitMQ\Exchange;


use DataProvider\RabbitMqExchangeDataProvider;
use Xervice\RabbitMQ\Business\Dependency\Exchange\ExchangeInterface;
use Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface;

class TestExchange implements ExchangeInterface
{
    /**
     * @param \Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface $exchangeProvider
     */
    public function declareExchange(ExchangeProviderInterface $exchangeProvider)
    {
        $testExchange = new RabbitMqExchangeDataProvider();
        $testExchange
            ->setName('UnitTest')
            ->setType('direct')
            ->setAutoDelete(false);

        $exchangeProvider->declare($testExchange);
    }

}