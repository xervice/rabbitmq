<?php
declare(strict_types=1);

namespace App\RabbitMQ;


use Xervice\RabbitMQ\RabbitMQDependencyProvider as XerviceRabbitMQDependencyProvider;
use XerviceTest\RabbitMQ\Exchange\TestExchange;
use XerviceTest\RabbitMQ\Listener\TestListener;
use XerviceTest\RabbitMQ\Queue\TestQueue;

class RabbitMQDependencyProvider extends XerviceRabbitMQDependencyProvider
{
    /**
     * @return \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface[]
     */
    protected function getListener(): array
    {
        return [
            new TestListener()
        ];
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Dependency\Queue\QueueInterface[]
     */
    protected function getQueues(): array
    {
        return [
            new TestQueue()
        ];
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Dependency\Exchange\ExchangeInterface[]
     */
    protected function getExchanges(): array
    {
        return [
            new TestExchange()
        ];
    }
}
