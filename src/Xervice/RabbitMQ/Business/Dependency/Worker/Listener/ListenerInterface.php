<?php


namespace Xervice\RabbitMQ\Business\Dependency\Worker\Listener;


use DataProvider\RabbitMqMessageCollectionDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;

interface ListenerInterface
{
    /**
     * @param \DataProvider\RabbitMqMessageCollectionDataProvider $collectionDataProvider
     *
     * @param \PhpAmqpLib\Channel\AMQPChannel $channel
     *
     * @return void
     */
    public function handleMessage(
        RabbitMqMessageCollectionDataProvider $collectionDataProvider,
        AMQPChannel $channel
    ): void;

    /**
     * @return string
     */
    public function getQueueName() : string;

    /**
     * @return int
     */
    public function getChunkSize() : int;
}