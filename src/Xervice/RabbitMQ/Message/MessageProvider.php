<?php


namespace Xervice\RabbitMQ\Message;


use DataProvider\RabbitMqMessageCollectionDataProvider;
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
    public function sendMessage(RabbitMqMessageDataProvider $messageDataProvider): void
    {
        $this->channel->basic_publish(
            $this->createMessage($messageDataProvider),
            $messageDataProvider->getExchange()->getName(),
            $messageDataProvider->getRoutingKey(),
            $messageDataProvider->getImmediate(),
            $messageDataProvider->getMandatory(),
            $messageDataProvider->getTicket()
        );
    }

    /**
     * @param \DataProvider\RabbitMqMessageCollectionDataProvider $messageCollectionDataProvider
     */
    public function sendBulk(RabbitMqMessageCollectionDataProvider $messageCollectionDataProvider): void
    {
        foreach ($messageCollectionDataProvider->getMessages() as $message) {
            $this->sendMessage($message);
        }
    }

    /**
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     *
     * @return \PhpAmqpLib\Message\AMQPMessage
     */
    private function createMessage(RabbitMqMessageDataProvider $messageDataDataProvider)
    {
        return new AMQPMessage(
            $messageDataDataProvider->getMessage(),
            $messageDataDataProvider->getProperties()
        );
    }

}