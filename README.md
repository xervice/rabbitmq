Xervice: RabbitMQ
=====

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/xervice/rabbitmq/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/xervice/rabbitmq/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/xervice/rabbitmq/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/xervice/rabbitmq/?branch=master)
[![Build Status](https://travis-ci.org/xervice/rabbitmq.svg?branch=master)](https://travis-ci.org/xervice/rabbitmq)

Installation
--------------
```
composer require xervice/rabbitmq
```

Configuration
---------------
First you have to define exchanges. To provide your exchanges to RabbitMQ you create an ExchangeProvider.

```php
<?php

namespace App\MyModule\Busines\Queue;

use DataProvider\RabbitMqExchangeDataProvider;
use Xervice\RabbitMQ\Core\ExchangeProviderInterface;
use Xervice\RabbitMQ\Exchange\ExchangeInterface;

class MyExchangeProvider implements ExchangeInterface
{
    /**
     * @param \Xervice\RabbitMQ\Core\ExchangeProviderInterface $exchangeProvider
     */
    public function declareExchange(ExchangeProviderInterface $exchangeProvider)
    {
        $myExchange = new RabbitMqExchangeDataProvider();
        $myExchange
            ->setName('MyExchangeName')
            ->setType('direct')
            ->setAutoDelete(false);

        $exchangeProvider->declare($myExchange);
    }
}
```

Also you have to define and provide queues to RabbitMQ. A queue have to be binded to an exchange.  s
Defining a queue and binding a queue is possible with an QueueProvider.

```php
<?php

namespace App\MyModule\Busines\Queue;

use DataProvider\RabbitMqExchangeDataProvider;
use DataProvider\RabbitMqQueueBindDataProvider;
use DataProvider\RabbitMqQueueDataProvider;
use Xervice\RabbitMQ\Core\QueueProviderInterface;
use Xervice\RabbitMQ\Queue\QueueInterface;

class MyQueue implements QueueInterface
{
    public function declareQueue(QueueProviderInterface $queueProvider)
    {
        $queue = new RabbitMqQueueDataProvider();
        $queue
            ->setName('MyQueueName')
            ->setAutoDelete(false)
            ->setArgument([]);

        $exchangeToBind = new RabbitMqExchangeDataProvider();
        $exchangeToBind->setName('MyExchangeName');

        $bind = new RabbitMqQueueBindDataProvider();
        $bind
            ->setExchange($exchangeToBind)
            ->setQueue($queue);

        $queueProvider->declare($queue);
        $queueProvider->bind($bind);
    }
}
```

If you start a worker, it will loop all defined Listener and provide queue messages to themn.


***Listener example***
```php
<?php

namespace App\MyModule\Business\Queue;

use DataProvider\RabbitMqMessageCollectionDataProvider;
use PhpAmqpLib\Channel\AMQPChannel;
use Xervice\RabbitMQ\Worker\Listener\AbstractListener;

class MyListener extends AbstractListener
{
    public function handleMessage(
        RabbitMqMessageCollectionDataProvider $collectionDataProvider,
        AMQPChannel $channel
    ): void {
        foreach ($collectionDataProvider->getMessages() as $message) {
            echo $message->getMessage()->getMessage();

            $this->sendAck($channel, $message);
        }
    }

    /**
     * @return int
     */
    public function getChunkSize(): int
    {
        return 500;
    }

    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return 'MyQueueName';
    }

}
```

The ChunkSize define, how many messages the worker want to get from RabbitMQ in one Worker instance.






To define the exchange, queue and listener, you can register them in the RabbitMQDependencyProvider:

```php
<?php


namespace App\RabbitMQ;


use Xervice\RabbitMQ\RabbitMQDependencyProvider as XerviceRabbitMQDependencyProvider;
use XerviceTest\RabbitMQ\Exchange\TestExchange;
use XerviceTest\RabbitMQ\Listener\TestListener;
use XerviceTest\RabbitMQ\Queue\TestQueue;

class RabbitMQDependencyProvider extends XerviceRabbitMQDependencyProvider
{
    /**
     * @return array
     */
    protected function getListener(): array
    {
        return [
            new MyListener()
        ];
    }

    /**
     * @return \Xervice\RabbitMQ\Queue\QueueInterface[]
     */
    protected function getQueues(): array
    {
        return [
            new TestQueue()
        ];
    }

    /**
     * @return \Xervice\RabbitMQ\Exchange\ExchangeInterface[]
     */
    protected function getExchanges(): array
    {
        return [
            new TestExchange()
        ];
    }
}
```


___To use RabbitMQ in your application, you can add the \Xervice\RabbitMQ\Kernel\RabbitMqService to your kernel stack.___


Usage
---------

***Initialize RabbitMQ***
```php
$rabbitMQFacade->init();
```

***Sending a message to rabbitmq***
```php
$exchange = new RabbitMqExchangeDataProvider();
$exchange->setName('UnitTest');

$simpleMessage = new SimpleMessageDataProvider();
$simpleMessage->setMessage('TestMessage');

$testMessage = new RabbitMqMessageDataProvider();
$testMessage
    ->setExchange($exchange)
    ->setMessage($simpleMessage);

$rabbitMQClient->sendMessage($message);
```


***Run the worker***
```php
$rabbitMQFacade->runWorker();
```