<?php


namespace Xervice\RabbitMQ;


use Xervice\Core\Business\Model\Dependency\DependencyContainerInterface;
use Xervice\Core\Business\Model\Dependency\Provider\AbstractDependencyProvider;
use Xervice\RabbitMQ\Business\Model\Exchange\ExchangeCollection;
use Xervice\RabbitMQ\Business\Model\Queue\QueueCollection;
use Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection;

class RabbitMQDependencyProvider extends AbstractDependencyProvider
{
    public const RABBITMQ_EXCHANGES = 'rabbitmq.exchanges';
    public const RABBITMQ_QUEUES = 'rabbitmq.queues';
    public const RABBITMQ_LISTENER = 'rabbitmq.listener';

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    public function handleDependencies(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container = $this->createExchangeCollection($container);
        $container = $this->createQueueCollection($container);
        $container = $this->createListenerCollection($container);

        return $container;
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface[]
     */
    protected function getListener(): array
    {
        return [];
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Dependency\Queue\QueueInterface[]
     */
    protected function getQueues(): array
    {
        return [];
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Dependency\Exchange\ExchangeInterface[]
     */
    protected function getExchanges(): array
    {
        return [];
    }

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    private function createExchangeCollection(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container[self::RABBITMQ_EXCHANGES] = function (DependencyContainerInterface $container) {
            return new ExchangeCollection(
                $this->getExchanges()
            );
        };

        return $container;
    }

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    private function createQueueCollection(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container[self::RABBITMQ_QUEUES] = function (DependencyContainerInterface $container) {
            return new QueueCollection(
                $this->getQueues()
            );
        };

        return $container;
    }

    /**
     * @param \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface $container
     *
     * @return \Xervice\Core\Business\Model\Dependency\DependencyContainerInterface
     */
    private function createListenerCollection(DependencyContainerInterface $container): DependencyContainerInterface
    {
        $container[self::RABBITMQ_LISTENER] = function (DependencyContainerInterface $container) {
            return new ListenerCollection(
                $this->getListener()
            );
        };

        return $container;
    }

}