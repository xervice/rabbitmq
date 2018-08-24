<?php


namespace Xervice\RabbitMQ\Business\Model\Core;


use DataProvider\RabbitMqConnectionConfigDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConnectionProvider implements ConnectionProviderInterface
{
    /**
     * @var \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    private $connection;

    /**
     * ConnectionProvider constructor.
     *
     * @param \DataProvider\RabbitMqConnectionConfigDataProvider $configDataProvider
     */
    public function __construct(RabbitMqConnectionConfigDataProvider $configDataProvider)
    {
        $this->connection = new AMQPStreamConnection(
            $configDataProvider->getHost(),
            $configDataProvider->getPort(),
            $configDataProvider->getUsername(),
            $configDataProvider->getPassword(),
            $configDataProvider->getVirtualHost(),
            $configDataProvider->getInsist(),
            $configDataProvider->getLoginMethod(),
            null,
            $configDataProvider->getLocale(),
            $configDataProvider->getConnectionTimeout(),
            $configDataProvider->getReadWriteTimeout(),
            $configDataProvider->getContext(),
            $configDataProvider->getKeepAlive(),
            $configDataProvider->getHeartbeat()
        );
    }

    /**
     * @return \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    public function getConnection() : AMQPStreamConnection
    {
        return $this->connection;
    }

    /**
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function getChannel(): AMQPChannel
    {
        return $this->connection->channel();
    }
}