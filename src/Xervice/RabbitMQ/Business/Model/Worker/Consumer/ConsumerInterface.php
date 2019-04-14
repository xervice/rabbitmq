<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Business\Model\Worker\Consumer;

use Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface;

interface ConsumerInterface
{
    /**
     * @return void
     */
    public function consumeQueries(): void;
}