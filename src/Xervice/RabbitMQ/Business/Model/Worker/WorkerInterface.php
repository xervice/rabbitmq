<?php

namespace Xervice\RabbitMQ\Business\Model\Worker;

use Symfony\Component\Console\Output\OutputInterface;

interface WorkerInterface
{
    /**
     * @param \Symfony\Component\Console\Output\OutputInterface|null $output
     */
    public function runWorker(OutputInterface $output = null): void;
}