<?php


namespace Xervice\RabbitMQ\Worker;


use Xervice\RabbitMQ\Worker\Consumer\ConsumerInterface;
use Xervice\RabbitMQ\Worker\Listener\ListenerCollection;

class Worker implements WorkerInterface
{
    /**
     * @var \Xervice\RabbitMQ\Worker\Listener\ListenerCollection
     */
    private $listenerCollection;

    /**
     * @var \Xervice\RabbitMQ\Worker\Consumer\ConsumerInterface
     */
    private $consumer;

    /**
     * Worker constructor.
     *
     * @param \Xervice\RabbitMQ\Worker\Listener\ListenerCollection $listenerCollection
     * @param \Xervice\RabbitMQ\Worker\Consumer\ConsumerInterface $consumer
     */
    public function __construct(
        ListenerCollection $listenerCollection,
        ConsumerInterface $consumer
    ) {
        $this->listenerCollection = $listenerCollection;
        $this->consumer = $consumer;
    }

    public function runWorker(): void
    {
        foreach ($this->listenerCollection as $listener) {
            $this->consumer->consumeQueries($listener);
        }
    }
}