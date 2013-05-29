<?php

namespace Todo\Task;

class Advanced extends Simple
{
    public $trash;
    public $trashed;
    public $comment;

    public function __construct($txt = null, $id = null)
    {
        $this->trash = false;

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
            if (preg_match('#^(?<trashed>\d{4}-\d{2}-\d{2}) ?(?<txt>.*)$#', $txt, $matches) === 1) {
                $this->trashed = $matches['trashed'];
                $txt = $matches['txt'];
            }
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
        if (!is_null($this->comment)) {
            $txt .= " => {$this->comment}";
        }
        return $txt;
    }
}
