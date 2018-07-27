<?php


namespace Xervice\RabbitMQ\Core;


use Xervice\RabbitMQ\Exchange\ExchangeBuilderInterface;
use Xervice\RabbitMQ\Queue\QueueBuilderInterface;

class Bootstrapper implements BootstrapperInterface
{
    /**
     * @var \Xervice\RabbitMQ\Exchange\ExchangeBuilderInterface
     */
    private $exchangeBuilder;

    /**
     * @var \Xervice\RabbitMQ\Queue\QueueBuilderInterface
     */
    private $queueBuilder;

    /**
     * Bootstrapper constructor.
     *
     * @param \Xervice\RabbitMQ\Exchange\ExchangeBuilderInterface $exchangeBuilder
     * @param \Xervice\RabbitMQ\Queue\QueueBuilderInterface $queueBuilder
     */
    public function __construct(
        ExchangeBuilderInterface $exchangeBuilder,
        QueueBuilderInterface $queueBuilder
    ) {
        $this->exchangeBuilder = $exchangeBuilder;
        $this->queueBuilder = $queueBuilder;
    }

    public function boot(): void
    {
        $this->exchangeBuilder->buildExchange();
        $this->queueBuilder->buildQueues();
    }

}