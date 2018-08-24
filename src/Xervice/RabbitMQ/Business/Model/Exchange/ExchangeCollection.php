<?php


namespace Xervice\RabbitMQ\Business\Model\Exchange;


use Xervice\RabbitMQ\Business\Dependency\Exchange\ExchangeInterface;

class ExchangeCollection implements \Iterator, \Countable
{
    /**
     * @var \Xervice\RabbitMQ\Business\Dependency\Exchange\ExchangeInterface[]
     */
    private $collection;

    /**
     * @var int
     */
    private $position;

    /**
     * Collection constructor.
     *
     * @param \Xervice\RabbitMQ\Business\Dependency\Exchange\ExchangeInterface[] $collection
     */
    public function __construct(array $collection)
    {
        foreach ($collection as $validator) {
            $this->add($validator);
        }
    }

    /**
     * @param \Xervice\RabbitMQ\Business\Dependency\Exchange\ExchangeInterface $validator
     */
    public function add(ExchangeInterface $validator): void
    {
        $this->collection[] = $validator;
    }

    /**
     * @return \Xervice\RabbitMQ\Business\Dependency\Exchange\ExchangeInterface
     */
    public function current(): ExchangeInterface
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