<?php

namespace Xervice\RabbitMQ\Message;

use DataProvider\RabbitMqMessageDataProvider;

interface MessageProviderInterface
{
    /**
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     */
    public function sendMessage(RabbitMqMessageDataProvider $messageDataProvider);
}