<?php


namespace Xervice\RabbitMQ\Core;


use DataProvider\RabbitMqExchangeDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;

class ExchangeProvider implements ExchangeProviderInterface
{
    const TYPE_DIRECT = 'direct';
    const TYPE_FANOUT = 'fanout';
    const TYPE_TOPIC = 'topic';

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
     * @param string $name
     * @param string $type
     * @param bool $passive
     * @param bool $durable
     * @param bool $auto_delete
     * @param bool $internal
     * @param bool $nowait
     */
    public function declare(RabbitMqExchangeDataProvider $exchangeDataProvider)
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


}