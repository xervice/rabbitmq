<?php


namespace Xervice\RabbitMQ\Queue;


use Xervice\RabbitMQ\Core\QueueProviderInterface;

interface QueueInterface
{
    /**
     * @param \Xervice\RabbitMQ\Core\QueueProviderInterface $queueProvider
     */
    public function declareQueue(QueueProviderInterface $queueProvider);
}