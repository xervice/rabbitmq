<?php


namespace Xervice\RabbitMQ\Worker\Consumer;


use DataProvider\RabbitMqConsumerConfigDataProvider;
use DataProvider\RabbitMqMessageCollectionDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use DataProvider\RabbitMqQueueDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Xervice\RabbitMQ\Worker\Listener\ListenerInterface;

class Consumer
{
    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    private $channel;

    /**
     * @var \DataProvider\RabbitMqConsumerConfigDataProvider
     */
    private $config;

    /**
     * @var \DataProvider\RabbitMqMessageCollectionDataProvider
     */
    private $messageCollection;

    /**
     * Consumer constructor.
     *
     * @param \PhpAmqpLib\Channel\AMQPChannel $channel
     * @param \DataProvider\RabbitMqConsumerConfigDataProvider $config
     */
    public function __construct(
        AMQPChannel $channel,
        RabbitMqConsumerConfigDataProvider $config
    ) {
        $this->channel = $channel;
        $this->config = $config;

        $this->messageCollection = new RabbitMqMessageCollectionDataProvider();
    }

    public function consumeQueries(ListenerInterface $listener)
    {
        $this->channel->basic_qos(null, $listener->getChunkSize(),  null);
        $this->channel->basic_consume(
            $listener->getQueueName(),
            $this->config->getTag(),
            $this->config->getNoLocal(),
            $this->config->getNoAck(),
            $this->config->getExclusive(),
            $this->config->getNoWait(),
            [$this, 'collectMessages'],
            $this->config->getTicket(),
            $this->config->getArguments()
        );

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    /**
     * @param \PhpAmqpLib\Message\AMQPMessage $message
     */
    public function collectMessages(AMQPMessage $message)
    {
        $rabbitMessage = new RabbitMqMessageDataProvider();
        $rabbitMessage->setMessage($message->getBody());
        $rabbitMessage->setProperties($message->get_properties());

        $queue = new RabbitMqQueueDataProvider();
        $queue->setName($message->delivery_info['exchange']);

        $this->messageCollection->addMessage($rabbitMessage);
    }
}