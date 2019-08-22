<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Business\Model\Worker\Listener;


use DataProvider\RabbitMqMessageDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;
use Xervice\Core\Plugin\AbstractBusinessPlugin;
use Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface;

abstract class AbstractListener extends AbstractBusinessPlugin implements ListenerInterface
{
    protected const DEFAULT_CHUNKSIZE = 100;
    protected const DEFAULT_WORKER = 1;

    /**
     * @return int
     */
    public function getChunkSize() : int
    {
        return self::DEFAULT_CHUNKSIZE;
    }

    /**
     * @return int
     */
    public function getWorker() : int
    {
        return static::DEFAULT_WORKER;
    }

    /**
     * @param \PhpAmqpLib\Channel\AMQPChannel $channel
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     */
    public function sendAck(
        AMQPChannel $channel,
        RabbitMqMessageDataProvider $messageDataProvider,
        bool $multiple = false
    ): void
    {
        $channel->basic_ack($messageDataProvider->getDeliveryTag(), $multiple);
    }

    /**
     * @param \PhpAmqpLib\Channel\AMQPChannel $channel
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     */
    public function sendNack(
        AMQPChannel $channel,
        RabbitMqMessageDataProvider $messageDataProvider,
        bool $multiple = false,
        bool $requeue = true
    ): void
    {
        $channel->basic_nack($messageDataProvider->getDeliveryTag(), $multiple, $requeue);
    }
}
