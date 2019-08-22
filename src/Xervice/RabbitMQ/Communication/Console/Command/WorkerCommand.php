<?php


namespace Xervice\RabbitMQ\Communication\Console\Command;


use DataProvider\EventDataProvider;
use DataProvider\LogMessageDataProvider;
use DataProvider\RabbitMqWorkerConfigDataProvider;
use DataProvider\SimpleMessageDataProvider;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Xervice\Console\Business\Model\Command\AbstractCommand;
use Xervice\Core\Business\Model\Locator\Locator;

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
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $workerConfig = new RabbitMqWorkerConfigDataProvider();
        $io = new SymfonyStyle($input, $output);
        $workerConfig->setDisplay($io);

        $message = new SimpleMessageDataProvider();
        $message->setMessage('Test');

        $event = new EventDataProvider();
        $event
            ->setName('Test')
            ->setMessage($message);
        Locator::getInstance()->event()->facade()->fireEvent($event);

        $this->getFacade()->runProcessManager($workerConfig);
    }
}
