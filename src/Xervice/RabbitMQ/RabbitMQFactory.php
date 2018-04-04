<?php


namespace Xervice\RabbitMQ;


use phpDocumentor\Reflection\Types\This;
use DataProvider\RabbitMqConnectionConfigDataProvider;
use Xervice\Core\Factory\AbstractFactory;
use Xervice\RabbitMQ\Core\ConnectionProvider;
use Xervice\RabbitMQ\Core\ConnectionProviderInterface;
use Xervice\RabbitMQ\Core\ExchangeProvider;
use Xervice\RabbitMQ\Core\ExchangeProviderInterface;
use Xervice\RabbitMQ\Core\QueueProvider;
use Xervice\RabbitMQ\Core\QueueProviderInterface;
use Xervice\RabbitMQ\Message\MessageProvider;
use Xervice\RabbitMQ\Message\MessageProviderInterface;

/**
 * @method \Xervice\RabbitMQ\RabbitMQConfig getConfig()
 */
class RabbitMQFactory extends AbstractFactory
{
    /**
     * @var ConnectionProviderInterface
     */
    private $connection;

    /**
     * @var MessageProviderInterface
     */
    private $messageProvider;

    /**
     * @return \Xervice\RabbitMQ\Core\ExchangeProviderInterface
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createExchangeProvider() : ExchangeProviderInterface
    {
        return new ExchangeProvider(
            $this->getConnectionProvider()->getChannel()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Core\QueueProviderInterface
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createQueueProvider() : QueueProviderInterface
    {
        return new QueueProvider(
            $this->getConnectionProvider()->getChannel()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Message\MessageProviderInterface
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createMessageProvider() : MessageProviderInterface
    {
        return new MessageProvider(
            $this->getConnectionProvider()->getChannel()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Core\ConnectionProviderInterface
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function createConnectionProvider() : ConnectionProviderInterface
    {
        return new ConnectionProvider(
            $this->getConfig()->getConnectionConfig()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Message\MessageProviderInterface
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function getMessageProvider() : MessageProviderInterface
    {
        if ($this->messageProvider === null) {
            $this->messageProvider = $this->createMessageProvider();
        }

        return $this->messageProvider;
    }

    /**
     * @return \Xervice\RabbitMQ\Core\ConnectionProviderInterface
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function getConnectionProvider() : ConnectionProviderInterface
    {
        if ($this->connection === null) {
            $this->connection = $this->createConnectionProvider();
        }

        return $this->connection;
    }

}