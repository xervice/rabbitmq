<?php

namespace Xervice\RabbitMQ\Worker;

interface WorkerInterface
{
    /**
     * @throws \Xervice\RabbitMQ\Worker\Listener\ListenerException
     */
    public function runWorker(): void;
}