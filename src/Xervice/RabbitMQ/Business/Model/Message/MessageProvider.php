<?php


namespace Xervice\RabbitMQ\Business\Model\Message;


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
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataDataProvider
     *
     * @return \PhpAmqpLib\Message\AMQPMessage
     */
    private function createMessage(RabbitMqMessageDataProvider $messageDataDataProvider): AMQPMessage
    {
        return new AMQPMessage(
            (string)json_encode(
                $messageDataDataProvider->toArray()
            ),
            $messageDataDataProvider->getProperties()
        );
    }

}