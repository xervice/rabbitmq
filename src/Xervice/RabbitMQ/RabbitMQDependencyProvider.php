<?php


namespace Xervice\RabbitMQ;


use Xervice\Core\Dependency\DependencyProviderInterface;
use Xervice\Core\Dependency\Provider\AbstractProvider;
use Xervice\RabbitMQ\Exchange\ExchangeCollection;
use Xervice\RabbitMQ\Queue\QueueCollection;
use Xervice\RabbitMQ\Worker\Listener\ListenerCollection;

class RabbitMQDependencyProvider extends AbstractProvider
{
    const RABBITMQ_EXCHANGES = 'rabbitmq.exchanges';

    const RABBITMQ_QUEUES = 'rabbitmq.queues';

    const RABBITMQ_LISTENER = 'rabbitmq.listener';

    public function handleDependencies(DependencyProviderInterface $container)
    {
        $this->createExchangeCollection($container);
        $this->createQueueCollection($container);
        $this->createListenerCollection($container);
    }

    /**
     * @return array
     */
    protected function getListener()
    {
        return [];
    }

    /**
     * @return \Xervice\RabbitMQ\Queue\QueueInterface[]
     */
    protected function getQueues()
    {
        return [];
    }

    /**
     * @return \Xervice\RabbitMQ\Exchange\ExchangeInterface[]
     */
    protected function getExchanges()
    {
        return [];
    }

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $container
     */
    private function createExchangeCollection(DependencyProviderInterface $container): void
    {
        $container[self::RABBITMQ_EXCHANGES] = function (DependencyProviderInterface $container) {
            return new ExchangeCollection(
                $this->getExchanges()
            );
        };
    }

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $container
     */
    private function createQueueCollection(DependencyProviderInterface $container): void
    {
        $container[self::RABBITMQ_QUEUES] = function (DependencyProviderInterface $container) {
            return new QueueCollection(
                $this->getQueues()
            );
        };
    }

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $container
     */
    private function createListenerCollection(DependencyProviderInterface $container): void
    {
        $container[self::RABBITMQ_LISTENER] = function (DependencyProviderInterface $container) {
            return new ListenerCollection(
                $this->getListener()
            );
        };
    }

}