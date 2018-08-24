<?php


namespace Xervice\RabbitMQ\Business\Model\Worker;


use Xervice\RabbitMQ\Business\Model\Worker\Consumer\ConsumerInterface;
use Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection;

class Worker implements WorkerInterface
{
    /**
     * @var \Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection
     */
    private $listenerCollection;

    /**
     * @var \Xervice\RabbitMQ\Business\Model\Worker\Consumer\ConsumerInterface
     */
    private $consumer;

    /**
     * Worker constructor.
     *
     * @param \Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection $listenerCollection
     * @param \Xervice\RabbitMQ\Business\Model\Worker\Consumer\ConsumerInterface $consumer
     */
    public function __construct(
        ListenerCollection $listenerCollection,
        ConsumerInterface $consumer
    ) {
        $this->listenerCollection = $listenerCollection;
        $this->consumer = $consumer;
    }

    /**
     * @throws \Xervice\RabbitMQ\Business\Exception\ListenerException
     */
    public function runWorker(): void
    {
        foreach ($this->listenerCollection as $listener) {
            $this->consumer->consumeQueries($listener);
        }
    }
}