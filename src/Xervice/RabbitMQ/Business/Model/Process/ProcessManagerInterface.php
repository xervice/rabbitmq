<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Business\Model\Process;

use DataProvider\RabbitMqWorkerConfigDataProvider;

interface ProcessManagerInterface
{
    /**
     * @param \DataProvider\RabbitMqWorkerConfigDataProvider $workerConfigDataProvider
     */
    public function runWorker(RabbitMqWorkerConfigDataProvider $workerConfigDataProvider): void;
}
