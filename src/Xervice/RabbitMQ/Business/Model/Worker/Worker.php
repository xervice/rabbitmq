<?php


namespace Xervice\RabbitMQ\Business\Model\Worker;


use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Core\Business\Model\Locator\Dynamic\Business\DynamicBusinessLocator;
use Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection;

/**
 * @method \Xervice\RabbitMQ\Business\RabbitMQFacade getFacade()
 */
class Worker implements WorkerInterface
{
    use DynamicBusinessLocator;

    /**
     * @var \Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection
     */
    private $listenerCollection;

    /**
     * Worker constructor.
     *
     * @param \Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection $listenerCollection
     */
    public function __construct(ListenerCollection $listenerCollection)
    {
        $this->listenerCollection = $listenerCollection;
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

            $this->getFacade()->consumeQueries($listener);
        }
    }
}