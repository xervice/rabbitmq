<?php


namespace Xervice\RabbitMQ\Worker;


class Worker
{
    /**
     * @var \Xervice\RabbitMQ\Worker\Listener\ListenerCollection
     */
    private $listenerCollection;

    private $consumer;
}