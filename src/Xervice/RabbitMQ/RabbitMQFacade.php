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
     *
     * @throws \Xervice\Config\Exception\ConfigNotFound
     */
    public function init()
    {
        $this->getFactory()->createBootstrapper()->boot();
    }

    public function close(): void
    {
        $this->getFactory()->getConnectionProvider()->getConnection()->close();
    }
}
