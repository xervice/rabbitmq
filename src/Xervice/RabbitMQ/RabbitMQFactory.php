<?php


namespace Xervice\RabbitMQ;


use phpDocumentor\Reflection\Types\This;
use DataProvider\RabbitMqConnectionConfigDataProvider;
use Xervice\Core\Factory\AbstractFactory;
use Xervice\RabbitMQ\Core\ConnectionProvider;
use Xervice\RabbitMQ\Core\ExchangeProvider;
use Xervice\RabbitMQ\Core\QueueProvider;
use Xervice\RabbitMQ\Message\MessageProvider;

/**
 * @method \Xervice\RabbitMQ\RabbitMQConfig getConfig()
 */
class RabbitMQFactory extends AbstractFactory
{
    /**
     * @var ConnectionProvider
     */
    private $connection;

    /**
     * @return \Xervice\RabbitMQ\Core\ExchangeProvider
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createExchangeProvider() : ExchangeProvider
    {
        return new ExchangeProvider(
            $this->getConnectionProvider()->getChannel()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Core\QueueProvider
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createQueueProvider() : QueueProvider
    {
        return new QueueProvider(
            $this->getConnectionProvider()->getChannel()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Message\MessageProvider
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createMessageProvider() : MessageProvider
    {
        return new MessageProvider(
            $this->getConnectionProvider()->getChannel()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Core\ConnectionProvider
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createConnectionProvider() : ConnectionProvider
    {
        return new ConnectionProvider(
            $this->getConfig()->getConnectionConfig()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Core\ConnectionProvider
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function getConnectionProvider() : ConnectionProvider
    {
        if ($this->connection === null) {
            $this->connection = $this->createConnectionProvider();
        }

        return $this->connection;
    }

}