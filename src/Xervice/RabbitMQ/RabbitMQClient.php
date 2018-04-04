<?php


namespace Xervice\RabbitMQ;


use DataProvider\RabbitMqMessageDataProvider;
use Xervice\Core\Client\AbstractClient;

/**
 * @method \Xervice\RabbitMQ\RabbitMQFactory getFactory()
 * @method \Xervice\RabbitMQ\RabbitMQConfig getConfig()
 */
class RabbitMQClient extends AbstractClient
{
    /**
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     *
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function sendMessage(RabbitMqMessageDataProvider $messageDataProvider)
    {
        $this->getFactory()->getMessageProvider()->sendMessage($messageDataProvider);
    }
}