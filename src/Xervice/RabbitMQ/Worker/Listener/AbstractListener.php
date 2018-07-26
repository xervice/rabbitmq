<?php


namespace Xervice\RabbitMQ\Worker\Listener;


use Xervice\Core\Locator\AbstractWithLocator;
use Xervice\Core\Locator\Locator;

abstract class AbstractListener extends AbstractWithLocator implements ListenerInterface
{
    const DEFAULT_CHUNKSIZE = 100;

    /**
     * @return int
     */
    public function getChunkSize() : int
    {
        return self::DEFAULT_CHUNKSIZE;
    }
}