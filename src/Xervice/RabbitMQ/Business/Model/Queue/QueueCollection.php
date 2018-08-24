<?php


namespace Xervice\RabbitMQ\Business\Model\Queue;


use Xervice\RabbitMQ\Business\Dependency\Queue\QueueInterface;

class QueueCollection implements \Iterator, \Countable
{
    /**
     * @var \Xervice\RabbitMQ\Business\Dependency\Queue\QueueInterface[]
     */
    private $collection;

    /**
     * @var int
     */
    private $position;

    /**
     * Collection constructor.
     *
     * @param \Xervice\RabbitMQ\Business\Dependency\Queue\QueueInterface[] $collection
     */
    public function __construct(array $collection)
    {
        foreach ($collection as $validator) {
            $this->add($validator);
        }
    }

    /**
     * @param \Xervice\RabbitMQ\Business\Dependency\Queue\QueueInterface $validator
     */
    public function add(QueueInterface $validator): void
    {
        $this->collection[] = $validator;
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Dependency\Queue\QueueInterface
     */
    public function current(): QueueInterface
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