<?php


namespace Xervice\RabbitMQ\Core;


use DataProvider\RabbitMqExchangeDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;

class ExchangeProvider implements ExchangeProviderInterface
{
    public const TYPE_DIRECT = 'direct';
    public const TYPE_FANOUT = 'fanout';
    public const TYPE_TOPIC = 'topic';

    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    private $channel;

    /**
     * Exchange constructor.
     *
     * @param \PhpAmqpLib\Channel\AMQPChannel $channel
     */
    public function __construct(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @param \DataProvider\RabbitMqExchangeDataProvider $exchangeDataProvider
     */
    public function declare(RabbitMqExchangeDataProvider $exchangeDataProvider): void
    {
        $this->channel->exchange_declare(
            $exchangeDataProvider->getName(),
            $exchangeDataProvider->getType(),
            $exchangeDataProvider->getPassive(),
            $exchangeDataProvider->getDurable(),
            $exchangeDataProvider->getAutoDelete(),
            $exchangeDataProvider->getInternal(),
            $exchangeDataProvider->getNoWait(),
            $exchangeDataProvider->getArgument(),
            $exchangeDataProvider->getTicket()
        );
    }

    /**
     * @param \DataProvider\RabbitMqExchangeDataProvider $exchangeDataProvider
     */
    public function delete(RabbitMqExchangeDataProvider $exchangeDataProvider): void
    {
        $this->channel->exchange_delete(
            $exchangeDataProvider->getName()
        );
    }


}