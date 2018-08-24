<?php

namespace Xervice\RabbitMQ\Business\Model\Exchange;


use Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface;

class ExchangeBuilder implements ExchangeBuilderInterface
{
    /**
     * @var \Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface
     */
    private $exchangeProvider;

    /**
     * @var \Xervice\RabbitMQ\Business\Model\Exchange\ExchangeCollection
     */
    private $exchangeCollection;

    /**
     * ExchangeBuilder constructor.
     *
     * @param \Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface $exchangeProvider
     * @param \Xervice\RabbitMQ\Business\Model\Exchange\ExchangeCollection $exchangeCollection
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