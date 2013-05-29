<?php

namespace Todo\Task;

class Simple
{
    public $id;
    public $raw;
    public $created;
    public $contexts;
    public $projects;
    public $priority;
    public $complete;
    public $completed;
    public $description;

    public function __construct($txt = null, $id = null)
    {
        $this->raw = $txt;
        $this->id = $id;
        $this->contexts = array();
        $this->projects = array();
        $this->complete = false;

        if (!is_null($txt)) {
            $this->load($txt);
        }
    }

    public function load($txt)
    {
        if (preg_match('#^x (?<txt>.*)$#', $txt, $matches) === 1) {
            $this->complete = true;
            $txt = $matches['txt'];
        }

        if ($this->complete) {
            if (preg_match('#^(?<completed>\d{4}-\d{2}-\d{2}) (?<txt>.*)$#', $txt, $matches) === 1) {
                $this->completed = $matches['completed'];
                $txt = $matches['txt'];
            }
        }

        if (preg_match('#^\((?<priority>.)\) (?<txt>.*)$#', $txt, $matches) === 1) {
            $this->priority = $matches['priority'];
            $txt = $matches['txt'];
        }

        if (preg_match('#^(?<created>\d{4}-\d{2}-\d{2}) (?<txt>.*)$#', $txt, $matches) === 1) {
            $this->created = $matches['created'];
            $txt = $matches['txt'];
        }

        if (preg_match_all('#@(?<contexts>[\w_]*)#', $txt, $matches) !== 0) {
            $this->contexts = $matches['contexts'];
        }

        if (preg_match_all('#\+(?<projects>[\w_]*)#', $txt, $matches) !== 0) {
            $this->projects = $matches['projects'];
        }

        $regex = '#^([\+@][\w_]*) #';
        while (preg_match($regex, $txt) === 1) {
            $txt = preg_replace($regex, '', $txt);
        }

        $this->description = $txt;
    }

    public function __toString()
    {
        $txt = '';

        if ($this->complete) {
            $txt .= 'x ';
            if (!is_null($this->completed)) {
                $txt .= "{$this->completed} ";
            }
        }
        if (!is_null($this->priority)) {
            $txt .= "({$this->priority}) ";
        }
        if (!is_null($this->created)) {
            $txt .= "{$this->created} ";
        }

        foreach ($this->projects as $project) {
            if (strstr($this->description, "+$project ") === false) {
                $txt .= "+$project ";
            }
        }

        foreach ($this->contexts as $context) {
            if (strstr($this->description, "@$context ") === false) {
                $txt .= "@$context ";
            }
        }

        $txt .= $this->description;
        return $txt;
    }

    public function toArray()
    {
        $array = array();

        foreach ($this as $key => $value) {
            if (!is_null($value)) {
                $array[$key] = $value;
            }
        }
        return $array;
    }
}
