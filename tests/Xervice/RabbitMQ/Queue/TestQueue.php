<?php


namespace XerviceTest\RabbitMQ\Queue;


use DataProvider\RabbitMqExchangeDataProvider;
use DataProvider\RabbitMqQueueBindDataProvider;
use DataProvider\RabbitMqQueueDataProvider;
use Xervice\RabbitMQ\Core\QueueProviderInterface;
use Xervice\RabbitMQ\Queue\QueueInterface;

class TestQueue implements QueueInterface
{
    public function declareQueue(QueueProviderInterface $queueProvider)
    {
        $queue = new RabbitMqQueueDataProvider();
        $queue
            ->setName('TestQueue')
            ->setArgument([]);

        $testExchange = new RabbitMqExchangeDataProvider();
        $testExchange
            ->setName('UnitTest');

        $bind = new RabbitMqQueueBindDataProvider();
        $bind
            ->setExchange($testExchange)
            ->setQueue($queue);

        $queueProvider->declare($queue);
        $queueProvider->bind($bind);
    }

}