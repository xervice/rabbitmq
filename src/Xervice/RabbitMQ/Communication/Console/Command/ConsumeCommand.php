<?php


namespace Xervice\RabbitMQ\Communication\Console\Command;


use DataProvider\RabbitMqWorkerConfigDataProvider;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Xervice\Console\Business\Model\Command\AbstractCommand;
use Xervice\Core\Business\Exception\XerviceException;

/**
 * @method \Xervice\RabbitMQ\Business\RabbitMQFacade getFacade()
 */
class ConsumeCommand extends AbstractCommand
{
    /**
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure(): void
    {
        $this
            ->setName('queue:listener:run')
            ->addArgument('queue', InputArgument::REQUIRED, 'Queue to be consumed');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|void
     * @throws \Xervice\Core\Business\Exception\XerviceException
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $workerConfig = new RabbitMqWorkerConfigDataProvider();
        $io = new SymfonyStyle($input, $output);
        $workerConfig->setDisplay($io);
        $workerConfig->setConsumer($input->getArgument('queue'));

        $this->getFacade()->runWorker($workerConfig);
    }
}
