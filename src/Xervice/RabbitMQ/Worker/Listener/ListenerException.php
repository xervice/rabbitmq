<?php


namespace Xervice\RabbitMQ\Worker\Listener;


use DataProvider\RabbitMqMessageDataProvider;
use Xervice\Core\Exception\XerviceException;

class ListenerException extends XerviceException
{
    /**
     * @var \DataProvider\RabbitMqMessageDataProvider
     */
    private $rabbitMqMessage;

    /**
     * @return \DataProvider\RabbitMqMessageDataProvider
     */
    public function getRabbitMqMessage(): RabbitMqMessageDataProvider
    {
        return $this->rabbitMqMessage;
    }

    /**
     * @param \DataProvider\RabbitMqMessageDataProvider $rabbitMqMessage
     */
    public function setRabbitMqMessage(RabbitMqMessageDataProvider $rabbitMqMessage): void
    {
        $this->rabbitMqMessage = $rabbitMqMessage;
    }




}