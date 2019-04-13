<?php


namespace Xervice\RabbitMQ\Business\Model\Worker;


use Symfony\Component\Console\Output\OutputInterface;
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
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function runWorker(OutputInterface $output = null): void
    {
        foreach ($this->listenerCollection as $listener) {
            if ($output !== null && $output->isDebug()) {
                $output->writeln('Run listener for queue <info>' . $listener->getQueueName() . '</info>');
            }
            $this->consumer->consumeQueries($listener);
        }
    }
}