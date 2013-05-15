<?php

namespace Todo;

class Task
{
    public $priority;
    public $description;

    public function __construct($txt = null)
    {
        if (!is_null($txt)) {
            $this->load($txt);
        }
    }

    public function load($txt)
    {
        if (preg_match('#^\((?<priority>.)\) ?(?<txt>.*)$#', $txt, $matches) === 1) {
            $this->priority = $matches['priority'];
            $txt = $matches['txt'];
        }

        $this->description = $txt;
    }

    public function __toString()
    {
        $txt = '';

        if (!is_null($this->priority)) {
            $txt .= "({$this->priority}) ";
        }
        $txt .= $this->description;
        return $txt;
    }
}
