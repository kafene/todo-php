<?php

namespace Todo\Task;

class Advanced extends Simple
{
    public $comment;

    public function load($txt)
    {
        parent::load($txt);
        $txt = $this->description;

        if (preg_match('#(?P<txt>.*?) ?=> ?(?<comment>.*)$#', $txt, $matches) === 1) {
            $this->comment = $matches['comment'];
            $txt = $matches['txt'];
        }

        $this->description = $txt;
    }

    public function __toString()
    {
        $txt = parent::__toString();

        if (!is_null($this->comment)) {
            $txt .= " => {$this->comment}";
        }
        return $txt;
    }
}
