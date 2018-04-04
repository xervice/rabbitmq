<?php


namespace Xervice\RabbitMQ;


use Xervice\Core\Dependency\DependencyProviderInterface;
use Xervice\Core\Dependency\Provider\AbstractProvider;
use Xervice\RabbitMQ\Exchange\ExchangeCollection;
use Xervice\RabbitMQ\Queue\QueueCollection;

class RabbitMQDependencyProvider extends AbstractProvider
{
    const RABBITMQ_EXCHANGES = 'rabbitmq.exchanges';

    const RABBITMQ_QUEUES = 'rabbitmq.queues';

    public function handleDependencies(DependencyProviderInterface $container)
    {
        $this->createExchangeCollection($container);
        $this->createQueueCollection($container);
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

}