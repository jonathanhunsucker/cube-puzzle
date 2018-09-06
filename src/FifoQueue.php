<?php

class FifoQueue
{
    public function __construct()
    {
        $this->items = [];
    }

    public function hasItems()
    {
        return count($this->items) > 0;
    }

    public function push($item)
    {
        array_push($this->items, $item);
    }

    public function pushAll(iterable $items)
    {
        foreach ($items as $item) {
            $this->push($item);
        }
    }

    public function pop()
    {
        return array_shift($this->items);
    }
}
