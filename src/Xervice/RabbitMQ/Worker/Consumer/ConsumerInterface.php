<?php

namespace Xervice\RabbitMQ\Worker\Consumer;

use DataProvider\RabbitMqMessageCollectionDataProvider;
use PhpAmqpLib\Message\AMQPMessage;
use Xervice\RabbitMQ\Worker\Listener\ListenerInterface;

interface ConsumerInterface
{
    /**
     * @param \Xervice\RabbitMQ\Worker\Listener\ListenerInterface $listener
     *
     * @return void
     */
    public function consumeQueries(ListenerInterface $listener): void;
}