<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Business;

use DataProvider\RabbitMqMessageCollectionDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use DataProvider\RabbitMqWorkerConfigDataProvider;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Core\Business\Model\Facade\AbstractFacade;
use Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface;


/**
 * @method \Xervice\RabbitMQ\Business\RabbitMQBusinessFactory getFactory()
 * @method \Xervice\RabbitMQ\RabbitMQConfig getConfig()
 */
class RabbitMQFacade extends AbstractFacade implements RabbitMQFacadeInterface
{
    /**
     * Initiate the exchanges and queues in RabbitMQ
     *
     * @api
     */
    public function init(): void
    {
        $this
            ->getFactory()
            ->createBootstrapper()
            ->boot();
    }

    /**
     * @param \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface $listener
     */
    public function consumeQueries(ListenerInterface $listener): void
    {
        $this->getFactory()
             ->createConsumer($listener)
             ->consumeQueries();
    }

    /**
     * @param \DataProvider\RabbitMqWorkerConfigDataProvider $workerConfigDataProvider
     */
    public function runWorker(RabbitMqWorkerConfigDataProvider $workerConfigDataProvider): void
    {
        $this
            ->getFactory()
            ->createWorker()
            ->runWorker($workerConfigDataProvider);
    }

    /**
     * @param \DataProvider\RabbitMqWorkerConfigDataProvider $workerConfigDataProvider
     */
    public function runProcessManager(RabbitMqWorkerConfigDataProvider $workerConfigDataProvider): void
    {
        $this
            ->getFactory()
            ->createProcessManager()
            ->runWorker($workerConfigDataProvider);
    }

    public function reconnect(): void
    {
        $this
            ->getFactory()
            ->getConnectionProvider()
            ->getConnection()
            ->reconnect();
    }

    /**
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     */
    public function sendMessage(RabbitMqMessageDataProvider $messageDataProvider): void
    {
        $this
            ->getFactory()
            ->getMessageProvider()
            ->sendMessage($messageDataProvider);
    }

    /**
     * @param \DataProvider\RabbitMqMessageCollectionDataProvider $messageCollectionDataProvider
     */
    public function sendMessages(RabbitMqMessageCollectionDataProvider $messageCollectionDataProvider): void
    {
        $this
            ->getFactory()
            ->getMessageProvider()
            ->sendBulk($messageCollectionDataProvider);
    }
}
