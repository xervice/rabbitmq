<?php


namespace Xervice\RabbitMQ\Business\Exception;


use DataProvider\RabbitMqMessageDataProvider;
use Xervice\Core\Business\Exception\XerviceException;

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