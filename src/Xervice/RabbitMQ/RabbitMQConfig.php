<?php


namespace Xervice\RabbitMQ;


use DataProvider\RabbitMqConnectionConfigDataProvider;
use DataProvider\RabbitMqConsumerConfigDataProvider;
use Xervice\Core\Config\AbstractConfig;

class RabbitMQConfig extends AbstractConfig
{
    public const CONNECTION_HOST               = 'rabbitmq.connection.host';
    public const CONNECTION_PORT               = 'rabbitmq.connection.port';
    public const CONNECTION_USERNAME           = 'rabbitmq.connection.username';
    public const CONNECTION_PASSWORD           = 'rabbitmq.connection.password';
    public const CONNECTION_VIRTUALHOST        = 'rabbitmq.connection.virtualhost';
    public const CONNECTION_INSIST             = 'rabbitmq.connection.insist';
    public const CONNECTION_LOGIN_METHOD       = 'rabbitmq.connection.login.method';
    public const CONNECTION_LOCALE             = 'rabbitmq.connection.locale';
    public const CONNECTION_CONNECTION_TIMEOUT = 'rabbitmq.connection.connection.timeout';
    public const CONNECTION_READWRITE_TIMEOUT  = 'rabbitmq.connection.rewrite.timeout';
    public const CONNECTION_CONTEXT            = 'rabbitmq.connection.context';
    public const CONNECTION_KEEPALIVE          = 'rabbitmq.connection.keepalive';
    public const CONNECTION_HEARTBEAT          = 'rabbitmq.connection.hearthbeat';


    public const CONSUMER_TAG       = 'rabbitmq.consumer.tag';
    public const CONSUMER_NOLOCAL   = 'rabbitmq.consumer.nolocal';
    public const CONSUMER_NOACK     = 'rabbitmq.consumer.noack';
    public const CONSUMER_EXCLUSIVE = 'rabbitmq.consumer.exclusive';
    public const CONSUMER_NOWAIT    = 'rabbitmq.consumer.nowait';
    public const CONSUMER_TICKET    = 'rabbitmq.consumer.ticket';
    public const CONSUMER_ARGUMENTS = 'rabbitmq.consumer.arguments';


    /**
     * @return \DataProvider\RabbitMqConnectionConfigDataProvider
     */
    public function getConnectionConfig(): RabbitMqConnectionConfigDataProvider
    {
        $connectionConfig = new RabbitMqConnectionConfigDataProvider();
        $connectionConfig
            ->setHost($this->get(self::CONNECTION_HOST, '127.0.0.1'))
            ->setPort($this->get(self::CONNECTION_PORT, '5672'))
            ->setUsername($this->get(self::CONNECTION_USERNAME))
            ->setPassword($this->get(self::CONNECTION_PASSWORD))
            ->setVirtualHost($this->get(self::CONNECTION_VIRTUALHOST, '/'))
            ->setInsist($this->get(self::CONNECTION_INSIST, 'false'))
            ->setLoginMethod($this->get(self::CONNECTION_LOGIN_METHOD, 'AMQPLAIN'))
            ->setLocale($this->get(self::CONNECTION_LOCALE, 'de_DE'))
            ->setConnectionTimeout($this->get(self::CONNECTION_CONNECTION_TIMEOUT, 3.0))
            ->setReadWriteTimeout($this->get(self::CONNECTION_READWRITE_TIMEOUT, 3.0))
            ->setContext($this->get(self::CONNECTION_CONTEXT))
            ->setKeepAlive($this->get(self::CONNECTION_KEEPALIVE, false))
            ->setHeartbeat($this->get(self::CONNECTION_HEARTBEAT, 0))
        ;

        return $connectionConfig;
    }

    /**
     * @return \DataProvider\RabbitMqConsumerConfigDataProvider
     */
    public function getConsumerConfig(): RabbitMqConsumerConfigDataProvider
    {
        $consumerConfig = new RabbitMqConsumerConfigDataProvider();
        $consumerConfig
            ->setTag($this->get(self::CONSUMER_TAG, ''))
            ->setNoLocal($this->get(self::CONSUMER_NOLOCAL, false))
            ->setNoAck($this->get(self::CONSUMER_NOACK, false))
            ->setExclusive($this->get(self::CONSUMER_EXCLUSIVE, false))
            ->setNoWait($this->get(self::CONSUMER_NOWAIT, false))
            ->setTicket($this->get(self::CONSUMER_TICKET, null))
            ->setArguments($this->get(self::CONSUMER_ARGUMENTS, []));

        return $consumerConfig;
    }
}