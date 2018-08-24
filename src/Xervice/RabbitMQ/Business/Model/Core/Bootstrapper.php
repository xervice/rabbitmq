<?php


namespace Xervice\RabbitMQ\Business\Model\Core;


use Xervice\RabbitMQ\Business\Model\Exchange\ExchangeBuilderInterface;
use Xervice\RabbitMQ\Business\Model\Queue\QueueBuilderInterface;

class Bootstrapper implements BootstrapperInterface
{
    /**
     * @var \Xervice\RabbitMQ\Business\Model\Exchange\ExchangeBuilderInterface
     */
    private $exchangeBuilder;

    /**
     * @var \Xervice\RabbitMQ\Business\Model\Queue\QueueBuilderInterface
     */
    private $queueBuilder;

    /**
     * Bootstrapper constructor.
     *
     * @param \Xervice\RabbitMQ\Business\Model\Exchange\ExchangeBuilderInterface $exchangeBuilder
     * @param \Xervice\RabbitMQ\Business\Model\Queue\QueueBuilderInterface $queueBuilder
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