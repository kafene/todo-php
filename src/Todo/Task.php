<?php

namespace Todo;

class Task
{
    public $created;
    public $contexts;
    public $priority;
    public $description;

    public function __construct($txt = null)
    {
        $this->contexts = array();

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

        if (preg_match('#^(?<created>\d{4}-\d{2}-\d{2}) ?(?<txt>.*)$#', $txt, $matches) === 1) {
            $this->created = $matches['created'];
            $txt = $matches['txt'];
        }

        if (preg_match_all('#@(?<contexts>[\w_]*)#', $txt, $matches) !== 0) {
            $this->contexts = $matches['contexts'];
        }

        $this->description = $txt;
    }

    public function __toString()
    {
        $txt = '';

        if (!is_null($this->priority)) {
            $txt .= "({$this->priority}) ";
        }
        if (!is_null($this->created)) {
            $txt .= "{$this->created} ";
        }
        $txt .= $this->description;
        return $txt;
    }
}
