<?php

namespace Xervice\RabbitMQ\Business\Model\Worker;

use DataProvider\RabbitMqWorkerConfigDataProvider;
use Symfony\Component\Console\Output\OutputInterface;

interface WorkerInterface
{
    /**
     * @param \DataProvider\RabbitMqWorkerConfigDataProvider $workerConfigDataProvider
     */
    public function runWorker(RabbitMqWorkerConfigDataProvider $workerConfigDataProvider): void;
}
