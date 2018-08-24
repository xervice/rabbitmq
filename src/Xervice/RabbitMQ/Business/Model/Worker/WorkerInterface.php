<?php

namespace Xervice\RabbitMQ\Business\Model\Worker;

interface WorkerInterface
{
    /**
     * @throws \Xervice\RabbitMQ\Business\Exception\ListenerException
     */
    public function runWorker(): void;
}