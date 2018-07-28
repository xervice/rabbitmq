<?php


namespace Xervice\RabbitMQ;


use Xervice\Core\Facade\AbstractFacade;

/**
 * @method \Xervice\RabbitMQ\RabbitMQFactory getFactory()
 * @method \Xervice\RabbitMQ\RabbitMQConfig getConfig()
 */
class RabbitMQFacade extends AbstractFacade
{
    /**
     * Initiate the exchanges and queues in RabbitMQ
     *
     * @api
     */
    public function init(): void
    {
        $this->getFactory()->createBootstrapper()->boot();
    }

    /**
     * @throws \Xervice\RabbitMQ\Worker\Listener\ListenerException
     */
    public function runWorker(): void
    {
        $this->getFactory()->createWorker()->runWorker();
    }

    public function close(): void
    {
        $this->getFactory()->getConnectionProvider()->getConnection()->close();
    }
}
