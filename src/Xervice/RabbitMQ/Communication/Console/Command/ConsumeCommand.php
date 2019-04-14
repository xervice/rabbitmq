<?php


namespace Xervice\RabbitMQ\Communication\Console\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
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
            ->addArgument('listener', InputArgument::REQUIRED, 'Listener classname');
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
        $listenerClass = $input->getArgument('listener');

        if (!class_exists($listenerClass)) {
            throw new XerviceException('Listener not found ' . $listenerClass);
        }

        $listener = new $listenerClass();
        $this->getFacade()->consumeQueries($listener);
    }
}