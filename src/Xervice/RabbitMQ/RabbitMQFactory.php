<?php


namespace Xervice\RabbitMQ;


use Xervice\Core\Factory\AbstractFactory;
use Xervice\RabbitMQ\Core\Bootstrapper;
use Xervice\RabbitMQ\Core\ConnectionProvider;
use Xervice\RabbitMQ\Core\ConnectionProviderInterface;
use Xervice\RabbitMQ\Core\ExchangeProvider;
use Xervice\RabbitMQ\Core\ExchangeProviderInterface;
use Xervice\RabbitMQ\Core\QueueProvider;
use Xervice\RabbitMQ\Core\QueueProviderInterface;
use Xervice\RabbitMQ\Exchange\ExchangeBuilder;
use Xervice\RabbitMQ\Message\MessageProvider;
use Xervice\RabbitMQ\Message\MessageProviderInterface;
use Xervice\RabbitMQ\Queue\QueueBuilder;
use Xervice\RabbitMQ\Worker\Consumer\Consumer;
use Xervice\RabbitMQ\Worker\Consumer\ConsumerInterface;
use Xervice\RabbitMQ\Worker\Listener\ListenerInterface;
use Xervice\RabbitMQ\Worker\Worker;
use Xervice\RabbitMQ\Worker\WorkerInterface;

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
     * @return \Xervice\RabbitMQ\Core\BootstrapperInterface
     */
    public function createBootstrapper()
    {
        return new Bootstrapper(
            $this->createExchangeBuilder(),
            $this->createQueueBuilder()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Worker\WorkerInterface
     */
    public function createWorker(): WorkerInterface
    {
        return new Worker(
            $this->getListenerCollection(),
            $this->createConsumer()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Worker\Consumer\ConsumerInterface
     */
    public function createConsumer(): ConsumerInterface
    {
        return new Consumer(
            $this->getConnectionProvider()->getChannel(),
            $this->getConfig()->getConsumerConfig()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Queue\QueueBuilder
     */
    public function createQueueBuilder()
    {
        return new QueueBuilder(
            $this->createQueueProvider(),
            $this->getQueueCollection()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Exchange\ExchangeBuilder
     */
    public function createExchangeBuilder()
    {
        return new ExchangeBuilder(
            $this->createExchangeProvider(),
            $this->getExchangeCollection()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Core\ExchangeProviderInterface
     */
    public function createExchangeProvider() : ExchangeProviderInterface
    {
        return new ExchangeProvider(
            $this->getConnectionProvider()->getChannel()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Core\QueueProviderInterface
     */
    public function createQueueProvider() : QueueProviderInterface
    {
        return new QueueProvider(
            $this->getConnectionProvider()->getChannel()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Message\MessageProviderInterface
     */
    public function createMessageProvider() : MessageProviderInterface
    {
        return new MessageProvider(
            $this->getConnectionProvider()->getChannel()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Core\ConnectionProviderInterface
     */
    public function createConnectionProvider() : ConnectionProviderInterface
    {
        return new ConnectionProvider(
            $this->getConfig()->getConnectionConfig()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Message\MessageProviderInterface
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
     */
    public function getConnectionProvider() : ConnectionProviderInterface
    {
        if ($this->connection === null) {
            $this->connection = $this->createConnectionProvider();
        }

        return $this->connection;
    }

    /**
     * @return \Xervice\RabbitMQ\Exchange\ExchangeCollection
     */
    public function getExchangeCollection()
    {
        return $this->getDependency(RabbitMQDependencyProvider::RABBITMQ_EXCHANGES);
    }

    /**
     * @return \Xervice\RabbitMQ\Queue\QueueCollection
     */
    public function getQueueCollection()
    {
        return $this->getDependency(RabbitMQDependencyProvider::RABBITMQ_QUEUES);
    }

    /**
     * @return \Xervice\RabbitMQ\Worker\Listener\ListenerCollection
     */
    public function getListenerCollection()
    {
        return $this->getDependency(RabbitMQDependencyProvider::RABBITMQ_LISTENER);
    }

}