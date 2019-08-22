<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Business;


use Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface;
use Xervice\RabbitMQ\Business\Model\Core\BootstrapperInterface;
use Xervice\RabbitMQ\Business\Model\Core\ConnectionProviderInterface;
use Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface;
use Xervice\RabbitMQ\Business\Model\Core\QueueProviderInterface;
use Xervice\RabbitMQ\Business\Model\Exchange\ExchangeBuilderInterface;
use Xervice\RabbitMQ\Business\Model\Exchange\ExchangeCollection;
use Xervice\RabbitMQ\Business\Model\Message\MessageProviderInterface;
use Xervice\RabbitMQ\Business\Model\Process\ProcessManagerInterface;
use Xervice\RabbitMQ\Business\Model\Queue\QueueBuilderInterface;
use Xervice\RabbitMQ\Business\Model\Queue\QueueCollection;
use Xervice\RabbitMQ\Business\Model\Worker\Consumer\ConsumerInterface;
use Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection;
use Xervice\RabbitMQ\Business\Model\Worker\WorkerInterface;

/**
 * @method \Xervice\RabbitMQ\RabbitMQConfig getConfig()
 */
interface RabbitMQBusinessFactoryInterface
{
    /**
     * @return \Xervice\RabbitMQ\Business\Model\Core\BootstrapperInterface
     */
    public function createBootstrapper(): BootstrapperInterface;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Core\ConnectionProviderInterface
     */
    public function createConnectionProvider(): ConnectionProviderInterface;

    /**
     * @param \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface $listener
     *
     * @return \Xervice\RabbitMQ\Business\Model\Worker\Consumer\ConsumerInterface
     */
    public function createConsumer(ListenerInterface $listener): ConsumerInterface;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Exchange\ExchangeBuilderInterface
     */
    public function createExchangeBuilder(): ExchangeBuilderInterface;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Core\ExchangeProviderInterface
     */
    public function createExchangeProvider(): ExchangeProviderInterface;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Message\MessageProviderInterface
     */
    public function createMessageProvider(): MessageProviderInterface;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Process\ProcessManagerInterface
     */
    public function createProcessManager(): ProcessManagerInterface;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Queue\QueueBuilderInterface
     */
    public function createQueueBuilder(): QueueBuilderInterface;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Core\QueueProviderInterface
     */
    public function createQueueProvider(): QueueProviderInterface;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Worker\WorkerInterface
     */
    public function createWorker(): WorkerInterface;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Core\ConnectionProviderInterface
     */
    public function getConnectionProvider(): ConnectionProviderInterface;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Exchange\ExchangeCollection
     */
    public function getExchangeCollection(): ExchangeCollection;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection
     */
    public function getListenerCollection(): ListenerCollection;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Message\MessageProviderInterface
     */
    public function getMessageProvider(): MessageProviderInterface;

    /**
     * @return \Xervice\RabbitMQ\Business\Model\Queue\QueueCollection
     */
    public function getQueueCollection(): QueueCollection;
}
