<?php


namespace XerviceTest\RabbitMQ\Listener;


use DataProvider\RabbitMqMessageCollectionDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;
use Xervice\RabbitMQ\Worker\Listener\AbstractListener;

class TestListener extends AbstractListener
{
    public function handleMessage(
        RabbitMqMessageCollectionDataProvider $collectionDataProvider,
        AMQPChannel $channel
    ): void {
        foreach ($collectionDataProvider->getMessages() as $message) {
            echo $message->getMessage();
        }
    }

    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return 'TestQueue';
    }

}