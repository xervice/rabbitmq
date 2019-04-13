<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Business;

use DataProvider\RabbitMqMessageCollectionDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Core\Business\Model\Facade\AbstractFacade;


/**
 * @method \Xervice\RabbitMQ\Business\RabbitMQBusinessFactory getFactory()
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

    public function runWorker(OutputInterface $output = null): void
    {
        $this->getFactory()->createWorker()->runWorker($output);
    }

    public function close(): void
    {
        $this->getFactory()->getConnectionProvider()->getConnection()->close();
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
}
