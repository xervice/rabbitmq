<?php


namespace Xervice\RabbitMQ\Queue;


class QueueCollection implements \Iterator, \Countable
{
    /**
     * @var \Xervice\RabbitMQ\Queue\QueueInterface[]
     */
    private $collection;

    /**
     * @var int
     */
    private $position;

    /**
     * Collection constructor.
     *
     * @param \Xervice\RabbitMQ\Queue\QueueInterface[] $collection
     */
    public function __construct(array $collection)
    {
        foreach ($collection as $validator) {
            $this->add($validator);
        }
    }

    /**
     * @param \Xervice\RabbitMQ\Queue\QueueInterface $validator
     */
    public function add(QueueInterface $validator)
    {
        $this->collection[] = $validator;
    }

    /**
     * @return \Xervice\RabbitMQ\Queue\QueueInterface
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