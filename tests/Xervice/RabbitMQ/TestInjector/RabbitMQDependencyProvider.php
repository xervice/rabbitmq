<?php


namespace App\RabbitMQ;


use Xervice\RabbitMQ\RabbitMQDependencyProvider as XerviceRabbitMQDependencyProvider;
use XerviceTest\RabbitMQ\Exchange\TestExchange;
use XerviceTest\RabbitMQ\Listener\TestListener;
use XerviceTest\RabbitMQ\Queue\TestQueue;

class RabbitMQDependencyProvider extends XerviceRabbitMQDependencyProvider
{
    /**
     * @return array
     */
    protected function getListener(): array
    {
        return [
            new TestListener()
        ];
    }

    /**
     * @return \Xervice\RabbitMQ\Queue\QueueInterface[]
     */
    protected function getQueues(): array
    {
        return [
            new TestQueue()
        ];
    }

    /**
     * @return \Xervice\RabbitMQ\Exchange\ExchangeInterface[]
     */
    protected function getExchanges(): array
    {
        return [
            new TestExchange()
        ];
    }

}