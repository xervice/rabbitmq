<?php


namespace Xervice\RabbitMQ\Queue;


use Xervice\RabbitMQ\Core\QueueProviderInterface;

class QueueBuilder implements QueueBuilderInterface
{
    /**
     * @var \Xervice\RabbitMQ\Core\QueueProviderInterface
     */
    private $queueProvider;

    /**
     * @var \Xervice\RabbitMQ\Queue\QueueCollection
     */
    private $queueCollection;

    /**
     * QueueBuilder constructor.
     *
     * @param \Xervice\RabbitMQ\Core\QueueProviderInterface $queueProvider
     * @param \Xervice\RabbitMQ\Queue\QueueCollection $queueCollection
     */
    public function __construct(
        QueueProviderInterface $queueProvider,
        QueueCollection $queueCollection
    ) {
        $this->queueProvider = $queueProvider;
        $this->queueCollection = $queueCollection;
    }

    public function buildQueues()
    {
        foreach ($this->queueCollection as $queue) {
            $queue->declareQueue($this->queueProvider);
        }
    }

}