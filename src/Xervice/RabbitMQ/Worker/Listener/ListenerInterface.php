<?php


namespace Xervice\RabbitMQ\Worker\Listener;


use DataProvider\RabbitMqMessageCollectionDataProvider;

interface ListenerInterface
{
    /**
     * @param \DataProvider\RabbitMqMessageCollectionDataProvider $collectionDataProvider
     *
     * @return bool
     * @throws \Xervice\RabbitMQ\Worker\Listener\ListenerException
     */
    public function handleMessage(RabbitMqMessageCollectionDataProvider $collectionDataProvider);

    /**
     * @return string
     */
    public function getQueueName() : string;

    /**
     * @return int
     */
    public function getChunkSize() : int;
}