<?php
declare(strict_types=1);

namespace Xervice\RabbitMQ\Business\Model\Worker\Listener;

use Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface;

class ListenerCollection implements \Iterator, \Countable
{
    /**
     * @var \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface[]
     */
    private $collection;

    /**
     * @var int
     */
    private $position;

    /**
     * Collection constructor.
     *
     * @param \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface[] $collection
     */
    public function __construct(array $collection)
    {
        foreach ($collection as $validator) {
            $this->add($validator);
        }
    }

    /**
     * @param \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface $validator
     */
    public function add(ListenerInterface $validator): void
    {
        $this->collection[] = $validator;
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Dependency\Worker\Listener\ListenerInterface
     */
    public function current(): ListenerInterface
    {
        return $this->collection[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->collection[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->collection);
    }
}