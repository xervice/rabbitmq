<?php

namespace Xervice\RabbitMQ\Core;

use DataProvider\RabbitMqQueueBindDataProvider;
use DataProvider\RabbitMqQueueDataProvider;

interface QueueProviderInterface
{
    /**
     * @param \DataProvider\RabbitMqQueueDataProvider $queueDataProvider
     */
    public function declare(RabbitMqQueueDataProvider $queueDataProvider);

    /**
     * @param \DataProvider\RabbitMqQueueBindDataProvider $bindDataProvider
     */
    public function bind(RabbitMqQueueBindDataProvider $bindDataProvider);
}