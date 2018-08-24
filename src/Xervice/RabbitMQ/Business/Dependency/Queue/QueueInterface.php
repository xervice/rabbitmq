<?php


namespace Xervice\RabbitMQ\Business\Dependency\Queue;


use Xervice\RabbitMQ\Business\Model\Core\QueueProviderInterface;

interface QueueInterface
{
    /**
     * @param \Xervice\RabbitMQ\Business\Model\Core\QueueProviderInterface $queueProvider
     */
    public function declareQueue(QueueProviderInterface $queueProvider);
}