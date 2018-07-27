<?php

namespace Xervice\RabbitMQ\Exchange;


use Xervice\RabbitMQ\Core\ExchangeProviderInterface;

class ExchangeBuilder implements ExchangeBuilderInterface
{
    /**
     * @var \Xervice\RabbitMQ\Core\ExchangeProviderInterface
     */
    private $exchangeProvider;

    /**
     * @var \Xervice\RabbitMQ\Exchange\ExchangeCollection
     */
    private $exchangeCollection;

    /**
     * ExchangeBuilder constructor.
     *
     * @param \Xervice\RabbitMQ\Core\ExchangeProviderInterface $exchangeProvider
     * @param \Xervice\RabbitMQ\Exchange\ExchangeCollection $exchangeCollection
     */
    public function __construct(
        ExchangeProviderInterface $exchangeProvider,
        ExchangeCollection $exchangeCollection
    ) {
        $this->exchangeProvider = $exchangeProvider;
        $this->exchangeCollection = $exchangeCollection;
    }

    public function buildExchange(): void
    {
        foreach ($this->exchangeCollection as $exchange) {
            $exchange->declareExchange($this->exchangeProvider);
        }
    }
}