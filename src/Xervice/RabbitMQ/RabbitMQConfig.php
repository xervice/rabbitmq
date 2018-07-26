<?php


namespace Xervice\RabbitMQ;


use DataProvider\RabbitMqConnectionConfigDataProvider;
use Xervice\Core\Config\AbstractConfig;

class RabbitMQConfig extends AbstractConfig
{
    const CONNECTION_HOST = 'rabbitmq.connection.host';
    const CONNECTION_PORT = 'rabbitmq.connection.port';
    const CONNECTION_USERNAME = 'rabbitmq.connection.username';
    const CONNECTION_PASSWORD = 'rabbitmq.connection.password';
    const CONNECTION_VIRTUALHOST = 'rabbitmq.connection.virtualhost';
    const CONNECTION_INSIST = 'rabbitmq.connection.insist';
    const CONNECTION_LOGIN_METHOD = 'rabbitmq.connection.login.method';
    const CONNECTION_LOCALE = 'rabbitmq.connection.locale';
    const CONNECTION_CONNECTION_TIMEOUT = 'rabbitmq.connection.connection.timeout';
    const CONNECTION_READWRITE_TIMEOUT = 'rabbitmq.connection.rewrite.timeout';
    const CONNECTION_CONTEXT = 'rabbitmq.connection.context';
    const CONNECTION_KEEPALIVE = 'rabbitmq.connection.keepalive';
    const CONNECTION_HEARTBEAT = 'rabbitmq.connection.hearthbeat';

    /**
     * @return \DataProvider\RabbitMqConnectionConfigDataProvider
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function getConnectionConfig()
    {
        $connectionConfig = new RabbitMqConnectionConfigDataProvider();
        $connectionConfig->setHost($this->get(self::CONNECTION_HOST, '127.0.0.1'));
        $connectionConfig->setPort($this->get(self::CONNECTION_PORT, '5672'));
        $connectionConfig->setUsername($this->get(self::CONNECTION_USERNAME));
        $connectionConfig->setPassword($this->get(self::CONNECTION_PASSWORD));
        $connectionConfig->setVirtualHost($this->get(self::CONNECTION_VIRTUALHOST, '/'));
        $connectionConfig->setInsist($this->get(self::CONNECTION_INSIST, 'false'));
        $connectionConfig->setLoginMethod($this->get(self::CONNECTION_LOGIN_METHOD, 'AMQPLAIN'));
        $connectionConfig->setLocale($this->get(self::CONNECTION_LOCALE, 'de_DE'));
        $connectionConfig->setConnectionTimeout($this->get(self::CONNECTION_CONNECTION_TIMEOUT, 3.0));
        $connectionConfig->setReadWriteTimeout($this->get(self::CONNECTION_READWRITE_TIMEOUT, 3.0));
        $connectionConfig->setContext($this->get(self::CONNECTION_CONTEXT));
        $connectionConfig->setKeepAlive($this->get(self::CONNECTION_KEEPALIVE, false));
        $connectionConfig->setHeartbeat($this->get(self::CONNECTION_HEARTBEAT, 0));

        return $connectionConfig;
    }
}