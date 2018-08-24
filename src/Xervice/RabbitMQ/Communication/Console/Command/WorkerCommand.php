<?php


namespace Xervice\RabbitMQ\Communication\Console\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Console\Business\Model\Command\AbstractCommand;

/**
 * @method \Xervice\RabbitMQ\Business\RabbitMQFacade getFacade()
 */
class WorkerCommand extends AbstractCommand
{
    /**
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure(): void
    {
        $this->setName('queue:worker:run');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|void
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->getFacade()->runWorker();
    }
}