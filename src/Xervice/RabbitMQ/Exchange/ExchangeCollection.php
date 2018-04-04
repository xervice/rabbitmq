<?php


namespace Xervice\RabbitMQ\Exchange;


class ExchangeCollection implements \Iterator, \Countable
{
    /**
     * @var \Xervice\RabbitMQ\Exchange\ExchangeInterface[]
     */
    private $collection;

    /**
     * @var int
     */
    private $position;

    /**
     * Collection constructor.
     *
     * @param \Xervice\RabbitMQ\Exchange\ExchangeInterface[] $collection
     */
    public function __construct(array $collection)
    {
        foreach ($collection as $validator) {
            $this->add($validator);
        }
    }

    /**
     * @param \Xervice\RabbitMQ\Exchange\ExchangeInterface $validator
     */
    public function add(ExchangeInterface $validator)
    {
        $this->collection[] = $validator;
    }

    /**
     * @return \Xervice\RabbitMQ\Exchange\ExchangeInterface
     */
    public function current()
    {
        return $this->collection[$this->position];
    }

    public function next()
    {
        $this->position++;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->collection[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return int
     */
    public function count()
    {
        return \count($this->collection);
    }
}