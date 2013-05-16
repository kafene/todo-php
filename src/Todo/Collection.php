<?php

namespace Todo;

class Collection implements \IteratorAggregate
{
    private $tasks;

    public function __construct($txt = null)
    {
        $this->tasks = array();

        if (!is_null($txt)) {
            $this->load($txt);
        }
    }

    public function load($txt)
    {
        foreach (explode("\n", $txt) as $id => $line) {
            if (!empty($line)) {
                $this->tasks[] = new Task($line, $id);
            }
        }
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->tasks);
    }

    public function getTasks()
    {
        return $this->tasks;
    }
}
