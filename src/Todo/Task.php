<?php

namespace Todo;

class Task
{
    public $description;

    public function __construct($txt = null)
    {
        if (!is_null($txt)) {
            $this->load($txt);
        }
    }

    public function load($txt)
    {
        $this->description = $txt;
    }

    public function __toString()
    {
        return $this->description;
    }
}
