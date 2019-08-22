<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Business;

use Xervice\Core\Business\Model\Factory\AbstractBusinessFactory;
use Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface;
use Xervice\RabbitMQ\Business\Model\Core\Bootstrapper;
use Xervice\RabbitMQ\Business\Model\Core\BootstrapperInterface;
use Xervice\RabbitMQ\Business\Model\Core\ConnectionProvider;
use Xervice\RabbitMQ\Business\Model\Core\ConnectionProviderInterface;
use Xervice\RabbitMQ\Business\Model\Core\ExchangeProvider;
use Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface;
use Xervice\RabbitMQ\Business\Model\Core\QueueProvider;
use Xervice\RabbitMQ\Business\Model\Core\QueueProviderInterface;
use Xervice\RabbitMQ\Business\Model\Exchange\ExchangeBuilder;
use Xervice\RabbitMQ\Business\Model\Exchange\ExchangeBuilderInterface;
use Xervice\RabbitMQ\Business\Model\Exchange\ExchangeCollection;
use Xervice\RabbitMQ\Business\Model\Message\MessageProvider;
use Xervice\RabbitMQ\Business\Model\Message\MessageProviderInterface;
use Xervice\RabbitMQ\Business\Model\Process\ProcessManager;
use Xervice\RabbitMQ\Business\Model\Process\ProcessManagerInterface;
use Xervice\RabbitMQ\Business\Model\Queue\QueueBuilder;
use Xervice\RabbitMQ\Business\Model\Queue\QueueBuilderInterface;
use Xervice\RabbitMQ\Business\Model\Queue\QueueCollection;
use Xervice\RabbitMQ\Business\Model\Worker\Consumer\Consumer;
use Xervice\RabbitMQ\Business\Model\Worker\Consumer\ConsumerInterface;
use Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection;
use Xervice\RabbitMQ\Business\Model\Worker\Worker;
use Xervice\RabbitMQ\Business\Model\Worker\WorkerInterface;
use Xervice\RabbitMQ\RabbitMQDependencyProvider;

/**
 * @method \Xervice\RabbitMQ\RabbitMQConfig getConfig()
 */
class RabbitMQBusinessFactory extends AbstractBusinessFactory implements RabbitMQBusinessFactoryInterface
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
     * @return \Xervice\RabbitMQ\Business\Model\Core\BootstrapperInterface
     */
    public function createBootstrapper(): BootstrapperInterface
    {
        return new Bootstrapper(
            $this->createExchangeBuilder(),
            $this->createQueueBuilder()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Core\ConnectionProviderInterface
     */
    public function createConnectionProvider() : ConnectionProviderInterface
    {
        return new ConnectionProvider(
            $this->getConfig()->getConnectionConfig()
        );
    }

    /**
     * @param \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface $listener
     *
     * @return \Xervice\RabbitMQ\Business\Model\Worker\Consumer\ConsumerInterface
     */
    public function createConsumer(ListenerInterface $listener): ConsumerInterface
    {
        return new Consumer(
            $this->getConnectionProvider()->getChannel(),
            $this->getConfig()->getConsumerConfig(),
            $listener
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Exchange\ExchangeBuilderInterface
     */
    public function createExchangeBuilder(): ExchangeBuilderInterface
    {
        return new ExchangeBuilder(
            $this->createExchangeProvider(),
            $this->getExchangeCollection()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface
     */
    public function createExchangeProvider() : ExchangeProviderInterface
    {
        return new ExchangeProvider(
            $this->getConnectionProvider()->getChannel()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Message\MessageProviderInterface
     */
    public function createMessageProvider() : MessageProviderInterface
    {
        return new MessageProvider(
            $this->getConnectionProvider()->getChannel()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Process\ProcessManagerInterface
     */
    public function createProcessManager(): ProcessManagerInterface
    {
        return new ProcessManager(
            $this->getListenerCollection()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Queue\QueueBuilderInterface
     */
    public function createQueueBuilder(): QueueBuilderInterface
    {
        return new QueueBuilder(
            $this->createQueueProvider(),
            $this->getQueueCollection()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Core\QueueProviderInterface
     */
    public function createQueueProvider() : QueueProviderInterface
    {
        return new QueueProvider(
            $this->getConnectionProvider()->getChannel()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Worker\WorkerInterface
     */
    public function createWorker(): WorkerInterface
    {
        return new Worker(
            $this->getListenerCollection()
        );
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Core\ConnectionProviderInterface
     */
    public function getConnectionProvider() : ConnectionProviderInterface
    {
        if ($this->connection === null) {
            $this->connection = $this->createConnectionProvider();
        }

        return $this->connection;
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Exchange\ExchangeCollection
     */
    public function getExchangeCollection(): ExchangeCollection
    {
        return $this->getDependency(RabbitMQDependencyProvider::RABBITMQ_EXCHANGES);
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection
     */
    public function getListenerCollection(): ListenerCollection
    {
        return $this->getDependency(RabbitMQDependencyProvider::RABBITMQ_LISTENER);
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Message\MessageProviderInterface
     */
    public function getMessageProvider() : MessageProviderInterface
    {
        if ($this->messageProvider === null) {
            $this->messageProvider = $this->createMessageProvider();
        }

        return $this->messageProvider;
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Queue\QueueCollection
     */
    public function getQueueCollection(): QueueCollection
    {
        return $this->getDependency(RabbitMQDependencyProvider::RABBITMQ_QUEUES);
    }

}
