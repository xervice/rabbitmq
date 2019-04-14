<?php


namespace Xervice\RabbitMQ\Business\Model\Worker\Consumer;


use DataProvider\RabbitMqConsumerConfigDataProvider;
use DataProvider\RabbitMqMessageCollectionDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use DataProvider\RabbitMqQueueDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface;

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
     * @var \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface
     */
    private $listener;

    /**
     * Consumer constructor.
     *
     * @param \PhpAmqpLib\Channel\AMQPChannel $channel
     * @param \DataProvider\RabbitMqConsumerConfigDataProvider $config
     */
    public function __construct(
        AMQPChannel $channel,
        RabbitMqConsumerConfigDataProvider $config,
        ListenerInterface $listener
    ) {
        $this->channel = $channel;
        $this->config = $config;
        $this->listener = $listener;

        $this->messageCollection = new RabbitMqMessageCollectionDataProvider();
    }

    /**
     * @return void
     */
    public function consumeQueries(): void
    {
        $this->channel->basic_qos(
            0,
            $this->listener->getChunkSize(),
            false
        );

        $this->channel->basic_consume(
            $this->listener->getQueueName(),
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
            while (\count($this->channel->callbacks)) {
                $this->channel->wait(
                    null,
                    false,
                    1
                );
            }
        } catch (\Exception $e) {
        }

        $this->listener->handleMessage($this->messageCollection, $this->channel);
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