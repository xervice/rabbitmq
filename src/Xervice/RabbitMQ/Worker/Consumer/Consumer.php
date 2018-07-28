<?php


namespace Xervice\RabbitMQ\Worker\Consumer;


use DataProvider\RabbitMqConsumerConfigDataProvider;
use DataProvider\RabbitMqMessageCollectionDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use DataProvider\RabbitMqQueueDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Xervice\RabbitMQ\Worker\Listener\ListenerInterface;

class Consumer implements ConsumerInterface
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

    /**
     * @param \Xervice\RabbitMQ\Worker\Listener\ListenerInterface $listener
     *
     * @return void
     */
    public function consumeQueries(ListenerInterface $listener): void
    {
        $this->channel->basic_qos(
            null,
            $listener->getChunkSize(),
            null
        );

        $this->channel->basic_consume(
            $listener->getQueueName(),
            $this->config->getTag(),
            $this->config->getNoLocal(),
            $this->config->getNoAck(),
            $this->config->getExclusive(),
            $this->config->getNoWait(),
            [
                $this,
                'collectMessages'
            ],
            $this->config->getTicket(),
            $this->config->getArguments()
        );

        try {
            $finished = false;
            while (\count($this->channel->callbacks) && !$finished) {
                $this->channel->wait(
                    null,
                    false,
                    1
                );
            }
        }
        catch (\Exception $e) {
            $finished = true;
        }

        $listener->handleMessage($this->messageCollection, $this->channel);
    }

    /**
     * @param \PhpAmqpLib\Message\AMQPMessage $message
     */
    public function collectMessages(AMQPMessage $message): void
    {
        $rabbitMessage = new RabbitMqMessageDataProvider();
        $rabbitMessage
            ->fromArray(
                json_decode(
                    $message->getBody(),
                    true
                )
            );
        $rabbitMessage
            ->setProperties($message->get_properties())
            ->setDeliveryInfo($message->delivery_info)
            ->setDeliveryTag($message->delivery_info['delivery_tag'] ?? 0);

        $queue = new RabbitMqQueueDataProvider();
        $queue->setName($message->delivery_info['exchange']);

        $this->messageCollection->addMessage($rabbitMessage);
    }
}