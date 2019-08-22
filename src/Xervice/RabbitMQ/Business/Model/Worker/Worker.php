<?php


namespace Xervice\RabbitMQ\Business\Model\Worker;


use DataProvider\RabbitMqWorkerConfigDataProvider;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Core\Business\Model\Locator\Dynamic\Business\DynamicBusinessLocator;
use Xervice\Core\Plugin\AbstractBusinessPlugin;
use Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection;

/**
 * @method \Xervice\RabbitMQ\Business\RabbitMQFacade getFacade()
 * @method \Xervice\RabbitMQ\Business\RabbitMQBusinessFactory getFactory()
 */
class Worker extends AbstractBusinessPlugin implements WorkerInterface
{
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
     * @param \DataProvider\RabbitMqWorkerConfigDataProvider $workerConfigDataProvider
     */
    public function runWorker(RabbitMqWorkerConfigDataProvider $workerConfigDataProvider): void
    {
        foreach ($this->listenerCollection as $listener) {
            if (
                $workerConfigDataProvider->getConsumer() === null
                || $listener->getQueueName() === $workerConfigDataProvider->getConsumer()
            ) {
                $this->getFactory()
                     ->createConsumer($listener)
                     ->consumeQueries();
            }
        }
    }
}
