<?php

namespace Xervice\RabbitMQ\Core;

use PhpAmqpLib\Connection\AMQPStreamConnection;

interface ConnectionProviderInterface
{
    /**
     * @return \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    public function getConnection(): AMQPStreamConnection;

    /**
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function getChannel();
}