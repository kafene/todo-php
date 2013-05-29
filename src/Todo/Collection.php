<?php

namespace Todo;

class Collection implements \IteratorAggregate, \ArrayAccess
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
                $this->tasks[] = new Task\Simple($line, $id);
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

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->tasks[] = $value;
        } else {
            $this->tasks[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->tasks[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->tasks[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->tasks[$offset]) ? $this->tasks[$offset] : null;
    }

    public function __tostring()
    {
        return implode($this->tasks, "\n");
    }
}
