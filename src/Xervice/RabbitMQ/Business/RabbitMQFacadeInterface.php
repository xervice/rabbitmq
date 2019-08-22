<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Business;


use DataProvider\RabbitMqMessageCollectionDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use DataProvider\RabbitMqWorkerConfigDataProvider;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface;

/**
 * @method \Xervice\RabbitMQ\Business\RabbitMQBusinessFactory getFactory()
 * @method \Xervice\RabbitMQ\RabbitMQConfig getConfig()
 */
interface RabbitMQFacadeInterface
{
    /**
     * @param \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface $listener
     */
    public function consumeQueries(ListenerInterface $listener): void;

    /**
     * Initiate the exchanges and queues in RabbitMQ
     *
     * @api
     */
    public function init(): void;

    /**
     * @param \DataProvider\RabbitMqWorkerConfigDataProvider $workerConfigDataProvider
     */
    public function runProcessManager(RabbitMqWorkerConfigDataProvider $workerConfigDataProvider): void;

    /**
     * @param \DataProvider\RabbitMqWorkerConfigDataProvider $workerConfigDataProvider
     */
    public function runWorker(RabbitMqWorkerConfigDataProvider $workerConfigDataProvider): void;

    public function reconnect(): void;

    /**
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     */
    public function sendMessage(RabbitMqMessageDataProvider $messageDataProvider): void;

    /**
     * @param \DataProvider\RabbitMqMessageCollectionDataProvider $messageCollectionDataProvider
     */
    public function sendMessages(RabbitMqMessageCollectionDataProvider $messageCollectionDataProvider): void;
}
