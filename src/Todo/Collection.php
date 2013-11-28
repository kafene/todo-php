<?php

namespace Todo;

class Collection implements \IteratorAggregate, \ArrayAccess, \Countable
{
    private $type;
    private $tasks;

    public function __construct($txt = null, $type = 'simple')
    {
        $this->type = $type;
        $this->tasks = array();

        if (!is_null($txt)) {
            $this->load($txt);
        }
    }

    public function load($txt)
    {
        foreach (explode("\n", $txt) as $id => $line) {
            if (!empty($line)) {
                $this->tasks[] = $this->createTask($line, $id);
            }
        }
    }

    private function createTask($line, $id)
    {
        $className = 'Todo\\Task\\' . ucfirst($this->type);
        if (!class_exists($className)) {
            throw new \LogicException("Unknow task type `{$this->type}`");
        }
        return new $className($line, $id);
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
        $this->tasks[$offset] = $value;
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

    public function count()
    {
        return count($this->tasks);
    }
}
