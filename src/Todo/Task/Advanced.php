<?php

namespace Todo\Task;

class Advanced extends Simple
{
    public $trash;
    public $until;
    public $future;
    public $trashed;
    public $comment;
    public $ultimate;
    public $trashable;
    public $prioritizable;
    public $deprioritizable;

    private $datePatterns = [
        'd' => 'deprioritizable',
        't' => 'future',
        'u' => 'until',
        'x' => 'trashable',
        'z' => 'ultimate',
    ];

    public function __construct($txt = null, $id = null)
    {
        $this->trash = false;
        $this->prioritizable = [];

        parent::__construct($txt, $id);
    }

    public function load($txt)
    {
        parent::load($txt);
        $txt = $this->description;

        if (preg_match('#^X (?<txt>.*)$#', $txt, $matches) === 1) {
            $this->trash = true;
            $txt = $matches['txt'];
        }

        if ($this->trash) {
            if (preg_match('#^(?<trashed>\d{4}-\d{2}-\d{2}) (?<txt>.*)$#', $txt, $matches) === 1) {
                $this->trashed = $matches['trashed'];
                $txt = $matches['txt'];
            }
        }

        foreach ($this->datePatterns as $pattern => $property) {
            $regex = "#^$pattern:(?<date>\d{4}-\d{2}-\d{2}) (?<txt>.*)$#";
            if (preg_match($regex, $txt, $matches) === 1) {
                $this->$property = $matches['date'];
                $txt = $matches['txt'];
            }
        }

        $regex = '#^(?<priority>[A-Z]):(?<date>\d{4}-\d{2}-\d{2}) (?<txt>.*)$#';
        while (preg_match($regex, $txt, $matches) === 1) {
            $this->prioritizable[$matches['priority']] = $matches['date'];
            $txt = $matches['txt'];
        }

        if (preg_match('#(?P<txt>.*?) ?=> ?(?<comment>.*)$#', $txt, $matches) === 1) {
            $this->comment = $matches['comment'];
            $txt = $matches['txt'];
        }

        $this->description = $txt;
    }

    public function __toString()
    {
        $txt = parent::__toString();

        if ($this->trash) {
            if (!is_null($this->trashed)) {
                $txt = "{$this->trashed} $txt";
            }
            $txt = "X $txt";
        }

        foreach ($this->datePatterns as $pattern => $property) {
            if (!is_null($this->$property)) {
                $txt = "$pattern:{$this->$property} $txt";
            }
        }

        foreach (array_reverse($this->prioritizable) as $priority => $date) {
            $txt = "$priority:$date $txt";
        }

        if (!is_null($this->comment)) {
            $txt .= " => {$this->comment}";
        }

        return $txt;
    }
}
