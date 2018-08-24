<?php


namespace Xervice\RabbitMQ\Business\Model\Queue;


use Xervice\RabbitMQ\Business\Model\Core\QueueProviderInterface;

class QueueBuilder implements QueueBuilderInterface
{
    /**
     * @var \Xervice\RabbitMQ\Business\Model\Core\QueueProviderInterface
     */
    private $queueProvider;

    /**
     * @var \Xervice\RabbitMQ\Business\Model\Queue\QueueCollection
     */
    private $queueCollection;

    /**
     * QueueBuilder constructor.
     *
     * @param \Xervice\RabbitMQ\Business\Model\Core\QueueProviderInterface $queueProvider
     * @param \Xervice\RabbitMQ\Business\Model\Queue\QueueCollection $queueCollection
     */
    public function __construct(
        QueueProviderInterface $queueProvider,
        QueueCollection $queueCollection
    ) {
        $this->queueProvider = $queueProvider;
        $this->queueCollection = $queueCollection;
    }

    public function buildQueues(): void
    {
        foreach ($this->queueCollection as $queue) {
            $queue->declareQueue($this->queueProvider);
        }
    }

}