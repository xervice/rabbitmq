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

    /**
     * @return int
     */
    public function getChunkSize() : int
    {
        return self::DEFAULT_CHUNKSIZE;
    }

    /**
     * @param \PhpAmqpLib\Channel\AMQPChannel $channel
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     */
    public function sendAck(AMQPChannel $channel, RabbitMqMessageDataProvider $messageDataProvider): void
    {
        $channel->basic_ack($messageDataProvider->getDeliveryTag());
    }

    /**
     * @param \PhpAmqpLib\Channel\AMQPChannel $channel
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     */
    public function sendNack(AMQPChannel $channel, RabbitMqMessageDataProvider $messageDataProvider): void
    {
        $channel->basic_nack($messageDataProvider->getDeliveryTag());
    }
}