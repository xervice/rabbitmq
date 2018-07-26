<?php


namespace Xervice\RabbitMQ\Worker\Listener;


class ListenerCollection implements \Iterator, \Countable
{
    /**
     * @var \Xervice\RabbitMQ\Worker\Listener\ListenerInterface[]
     */
    private $collection;

    /**
     * @var int
     */
    private $position;

    /**
     * Collection constructor.
     *
     * @param \Xervice\RabbitMQ\Worker\Listener\ListenerInterface[] $collection
     */
    public function __construct(array $collection)
    {
        foreach ($collection as $validator) {
            $this->add($validator);
        }
    }

    /**
     * @param \Xervice\RabbitMQ\Worker\Listener\ListenerInterface $validator
     */
    public function add(ListenerInterface $validator)
    {
        $this->collection[] = $validator;
    }

    /**
     * @return \Xervice\RabbitMQ\Worker\Listener\ListenerInterface
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