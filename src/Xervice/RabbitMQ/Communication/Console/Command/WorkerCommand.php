<?php


namespace Xervice\RabbitMQ\Communication\Console\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
        $this
            ->setName('queue:worker:run')
            ->addOption('loop', 'l', InputOption::VALUE_NONE, 'Endless loop')
            ->addOption('runtime', 't', InputOption::VALUE_REQUIRED, 'How long running this command',60);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $loop = $input->getOption('loop');
        $loopTime = $input->getOption('runtime');

        $time = time();
        $timeEnd = $time;
        $timeLeft = $loopTime - ($timeEnd - $time);

        if ($output->isDebug()) {
            $output->writeln('Start at ' . date('H:i:s', $time));
        }

        while ($loop || $timeLeft > 0) {
            $this->runQueueWorker($output);

            $timeEnd = time();
            $timeLeft = $loopTime - ($timeEnd - $time);

            if ($output->isDebug()) {
                $output->writeln('<comment>Time left: ' . $timeLeft . ' seconds!</comment>');
            }

        }
        if ($output->isDebug()) {
            $output->writeln('');
            $output->writeln('Finished at ' . date('H:i:s', $timeEnd));
        }
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function runQueueWorker(OutputInterface $output): void
    {
        $this->getFacade()->runWorker($output);
    }
}