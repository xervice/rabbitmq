<?php


namespace Xervice\RabbitMQ\Message;


use DataProvider\RabbitMqMessageDataDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class MessageProvider implements MessageProviderInterface
{
    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    private $channel;

    /**
     * MessageProvider constructor.
     *
     * @param \PhpAmqpLib\Channel\AMQPChannel $channel
     */
    public function __construct(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     */
    public function sendMessage(RabbitMqMessageDataProvider $messageDataProvider)
    {
        $this->channel->basic_publish(
            $this->createMessage($messageDataProvider->getMessage()),
            $messageDataProvider->getExchange()->getName(),
            $messageDataProvider->getRoutingKey(),
            $messageDataProvider->getImmediate(),
            $messageDataProvider->getMandatory(),
            $messageDataProvider->getTicket()
        );
    }

    /**
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     *
     * @return \PhpAmqpLib\Message\AMQPMessage
     */
    private function createMessage(RabbitMqMessageDataDataProvider $messageDataDataProvider)
    {
        return new AMQPMessage(
            $messageDataDataProvider->getMessage(),
            $messageDataDataProvider->getProperties()
        );
    }

}