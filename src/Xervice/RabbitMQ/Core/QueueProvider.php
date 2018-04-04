<?php


namespace Xervice\RabbitMQ\Core;


use DataProvider\RabbitMqQueueBindDataProvider;
use DataProvider\RabbitMqQueueDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;

class QueueProvider
{
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
     * @param \DataProvider\RabbitMqQueueDataProvider $queueDataProvider
     */
    public function declare(RabbitMqQueueDataProvider $queueDataProvider)
    {
        $this->channel->queue_declare(
            $queueDataProvider->getName(),
            $queueDataProvider->getPassive(),
            $queueDataProvider->getDurable(),
            $queueDataProvider->getExclusive(),
            $queueDataProvider->getAutoDelete(),
            $queueDataProvider->getNoWait(),
            $queueDataProvider->getArgument(),
            $queueDataProvider->getTicket()
        );
    }


    /**
     * @param \DataProvider\RabbitMqQueueBindDataProvider $bindDataProvider
     */
    public function bind(RabbitMqQueueBindDataProvider $bindDataProvider)
    {
        $this->channel->queue_bind(
            $bindDataProvider->getQueue()->getName(),
            $bindDataProvider->getExchange()->getName(),
            $bindDataProvider->getRoutingKey(),
            $bindDataProvider->getNoWait(),
            $bindDataProvider->getArgument(),
            $bindDataProvider->getTicket()
        );
    }


}