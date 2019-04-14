<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Business;


use DataProvider\RabbitMqMessageCollectionDataProvider;
use DataProvider\RabbitMqMessageDataProvider;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Xervice\RabbitMQ\Business\RabbitMQBusinessFactory getFactory()
 * @method \Xervice\RabbitMQ\RabbitMQConfig getConfig()
 */
interface RabbitMQFacadeInterface
{
    /**
     * Initiate the exchanges and queues in RabbitMQ
     *
     * @api
     */
    public function init(): void;

    public function runWorker(OutputInterface $output = null): void;

    public function reconnect(): void;

    public function close(): void;

    /**
     * @param \DataProvider\RabbitMqMessageDataProvider $messageDataProvider
     */
    public function sendMessage(RabbitMqMessageDataProvider $messageDataProvider): void;

    /**
     * @param \DataProvider\RabbitMqMessageCollectionDataProvider $messageCollectionDataProvider
     */
    public function sendMessages(RabbitMqMessageCollectionDataProvider $messageCollectionDataProvider): void;
}