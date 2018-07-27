<?php


namespace Xervice\RabbitMQ;


use Xervice\Core\Dependency\DependencyProviderInterface;
use Xervice\Core\Dependency\Provider\AbstractProvider;
use Xervice\RabbitMQ\Exchange\ExchangeCollection;
use Xervice\RabbitMQ\Queue\QueueCollection;
use Xervice\RabbitMQ\Worker\Listener\ListenerCollection;

class RabbitMQDependencyProvider extends AbstractProvider
{
    public const RABBITMQ_EXCHANGES = 'rabbitmq.exchanges';

    public const RABBITMQ_QUEUES = 'rabbitmq.queues';

    public const RABBITMQ_LISTENER = 'rabbitmq.listener';

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $dependencyProvider
     */
    public function handleDependencies(DependencyProviderInterface $dependencyProvider): void
    {
        $this->createExchangeCollection($dependencyProvider);
        $this->createQueueCollection($dependencyProvider);
        $this->createListenerCollection($dependencyProvider);
    }

    /**
     * @return \Xervice\RabbitMQ\Worker\Listener\ListenerInterface[]
     */
    protected function getListener(): array
    {
        return [];
    }

    /**
     * @return \Xervice\RabbitMQ\Queue\QueueInterface[]
     */
    protected function getQueues(): array
    {
        return [];
    }

    /**
     * @return \Xervice\RabbitMQ\Exchange\ExchangeInterface[]
     */
    protected function getExchanges(): array
    {
        return [];
    }

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $dependencyProvider
     */
    private function createExchangeCollection(DependencyProviderInterface $dependencyProvider): void
    {
        $dependencyProvider[self::RABBITMQ_EXCHANGES] = function (DependencyProviderInterface $dependencyProvider) {
            return new ExchangeCollection(
                $this->getExchanges()
            );
        };
    }

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $dependencyProvider
     */
    private function createQueueCollection(DependencyProviderInterface $dependencyProvider): void
    {
        $dependencyProvider[self::RABBITMQ_QUEUES] = function (DependencyProviderInterface $dependencyProvider) {
            return new QueueCollection(
                $this->getQueues()
            );
        };
    }

    /**
     * @param \Xervice\Core\Dependency\DependencyProviderInterface $dependencyProvider
     */
    private function createListenerCollection(DependencyProviderInterface $dependencyProvider): void
    {
        $dependencyProvider[self::RABBITMQ_LISTENER] = function (DependencyProviderInterface $dependencyProvider) {
            return new ListenerCollection(
                $this->getListener()
            );
        };
    }

}