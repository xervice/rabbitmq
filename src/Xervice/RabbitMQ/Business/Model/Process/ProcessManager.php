<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Business\Model\Process;


use DataProvider\RabbitMqWorkerConfigDataProvider;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface;
use Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection;

class ProcessManager implements ProcessManagerInterface
{
    protected const BINARY = 'vendor/bin/xervice';
    protected const COMMAND = 'queue:listener:run';
    protected const TIMEOUT = 90.0;
    protected const TIME_RUNNING = 60;

    /**
     * @var array
     */
    private static $queueProcessList = [];

    /**
     * @var \Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection
     */
    private $listenerCollection;

    /**
     * @var float
     */
    private $progress;

    /**
     * Worker constructor.
     *
     * @param \Xervice\RabbitMQ\Business\Model\Worker\Listener\ListenerCollection $listenerCollection
     */
    public function __construct(ListenerCollection $listenerCollection)
    {
        $this->listenerCollection = $listenerCollection;
    }

    /**
     * @param \DataProvider\RabbitMqWorkerConfigDataProvider $workerConfigDataProvider
     */
    public function runWorker(RabbitMqWorkerConfigDataProvider $workerConfigDataProvider): void
    {
        $currentTime = microtime(true);

        if ($workerConfigDataProvider->getDisplay() && $workerConfigDataProvider->getDisplay()->isVerbose()) {
            $workerConfigDataProvider->getDisplay()->progressStart(static::TIME_RUNNING);
            $this->progress = 0;
        }

        while (true) {
            $this->startOpenWorker();
            $this->cleanProcessStack();
            $timeDone = (microtime(true) - $currentTime);
            $timeLeft = static::TIME_RUNNING - $timeDone;
            if ($timeLeft < 0) {
                $this->waitUntilProcessAreDone();
                break;
            }
            $this->printStatus($workerConfigDataProvider->getDisplay(), (int)round($timeDone));
            usleep(1000);
        }

        if ($workerConfigDataProvider->getDisplay() && $workerConfigDataProvider->getDisplay()->isVerbose()) {
            $workerConfigDataProvider->getDisplay()->progressFinish();
        }
    }

    /**
     * @param \Symfony\Component\Console\Style\SymfonyStyle|null $display
     * @param int $progress
     */
    protected function printStatus(SymfonyStyle $display = null, int $progress): void
    {
        if ($display && $display->isVerbose()) {
            $progress = $progress - $this->progress;
            $display->progressAdvance($progress);
            $this->progress += $progress;
        }
    }

    protected function cleanProcessStack(): void
    {
        foreach (static::$queueProcessList as $queueName => $worker) {
            /**
             * @var Process $process
             */
            foreach ($worker as $index => $process) {
                if ($process->isSuccessful() || $process->isTerminated()) {
                    unset($worker[$index]);
                }
            }
        }
    }

    /**
     * @param array $command
     *
     * @return \Symfony\Component\Process\Process
     */
    protected function createProcess(array $command): Process
    {
        return new Process(
            $command,
            getcwd(),
            $_ENV,
            null,
            static::TIMEOUT
        );
    }

    protected function startOpenWorker(): void
    {
        foreach ($this->listenerCollection as $listener) {
            $this->startQueueListener($listener);
        }
    }

    /**
     * @param \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface $listener
     */
    protected function startQueueListener(ListenerInterface $listener): void {
        $command = [
            static::BINARY,
            static::COMMAND,
            $listener->getQueueName()
        ];

        if (!isset(static::$queueProcessList[$listener->getQueueName()])) {
            static::$queueProcessList[$listener->getQueueName()] = [];
        }

        for ($i = count(static::$queueProcessList[$listener->getQueueName()]); $i < $listener->getWorker(); $i++) {
            $process = $this->createProcess($command);
            $process->start();

            static::$queueProcessList[$listener->getQueueName()][] = $process;
        }
    }

    protected function waitUntilProcessAreDone(): void
    {
        foreach (static::$queueProcessList as $worker) {
            foreach ($worker as $process) {
                $process->wait();
            }
        }
    }
}
