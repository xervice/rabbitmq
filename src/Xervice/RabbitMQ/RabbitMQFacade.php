<?php


namespace Xervice\RabbitMQ;


use DataProvider\RabbitMqMessageCollectionDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use Xervice\Core\Facade\AbstractFacade;

/**
 * @method \Xervice\RabbitMQ\RabbitMQFactory getFactory()
 * @method \Xervice\RabbitMQ\RabbitMQConfig getConfig()
 */
class RabbitMQFacade extends AbstractFacade
{
    /**
     * Initiate the exchanges and queues in RabbitMQ
     *
     * @api
     */
    public function init(): void
    {
        $this->getFactory()->createBootstrapper()->boot();
    }

    /**
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     */
    public function sendMessage(RabbitMqMessageDataProvider $messageDataProvider): void
    {
        $this->getFactory()->getMessageProvider()->sendMessage($messageDataProvider);
    }

    /**
     * @param \DataProvider\RabbitMqMessageCollectionDataProvider $messageCollectionDataProvider
     */
    public function sendMessages(RabbitMqMessageCollectionDataProvider $messageCollectionDataProvider): void
    {
        $this->getFactory()->getMessageProvider()->sendBulk($messageCollectionDataProvider);
    }

    /**
     * @throws \Xervice\RabbitMQ\Worker\Listener\ListenerException
     */
    public function runWorker(): void
    {
        $this->getFactory()->createWorker()->runWorker();
    }

    public function close(): void
    {
        $this->getFactory()->getConnectionProvider()->getConnection()->close();
    }
}
