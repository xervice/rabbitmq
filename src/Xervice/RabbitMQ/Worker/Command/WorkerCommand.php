<?php


namespace Xervice\RabbitMQ\Worker\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Xervice\Console\Command\AbstractCommand;

/**
 * @method \Xervice\RabbitMQ\RabbitMQFacade getFacade()
 */
class WorkerCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('queue:worker:run');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|void
     * @throws \Core\Locator\Dynamic\ServiceNotParseable
     * @throws \Xervice\RabbitMQ\Worker\Listener\ListenerException
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->getFacade()->runWorker();
    }


}