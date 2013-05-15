<?php

namespace Todo;

class Collection
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
        foreach (explode("\n", $txt) as $line) {
            $this->tasks[] = new Task($line);
        }
    }
}
