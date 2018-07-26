<?php

namespace Xervice\RabbitMQ\Message;

use DataProvider\RabbitMqMessageCollectionDataProvider;
use DataProvider\RabbitMqMessageDataProvider;

interface MessageProviderInterface
{
    /**
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     */
    public function sendMessage(RabbitMqMessageDataProvider $messageDataProvider): void;

    /**
     * @param \DataProvider\RabbitMqMessageCollectionDataProvider $messageCollectionDataProvider
     */
    public function sendBulk(RabbitMqMessageCollectionDataProvider $messageCollectionDataProvider): void;
}