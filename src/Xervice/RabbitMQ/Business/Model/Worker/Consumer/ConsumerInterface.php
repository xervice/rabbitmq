<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Business\Model\Worker\Consumer;

use Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface;

interface ConsumerInterface
{
    /**
     * @param \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface $listener
     *
     * @return void
     */
    public function consumeQueries(ListenerInterface $listener): void;
}