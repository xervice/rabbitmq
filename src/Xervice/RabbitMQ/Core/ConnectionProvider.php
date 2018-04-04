<?php


namespace Xervice\RabbitMQ\Core;


use DataProvider\RabbitMqConnectionConfigDataProvider;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConnectionProvider
{
    /**
     * @var \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    private $connection;

    /**
     * Connection constructor.
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
    public function getChannel()
    {
        return $this->connection->channel();
    }
}