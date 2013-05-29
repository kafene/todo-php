<?php

namespace Test\Units\Todo\Task;

class Advanced extends \atoum
{
    public function testCreate()
    {
        $this->object(new \Todo\Task\Advanced)
            ->isInstanceOf('\Todo\Task\Advanced');
    }

    public function testParseComment()
    {
        $txt = '(A) Crack the Da Vinci Code. => A comment';
        $task = new \Todo\Task\Advanced($txt);

        $this->castToString($task)
            ->isEqualTo($txt);

        $this->string($task->description)
            ->isEqualTo('Crack the Da Vinci Code.');

        $this->string($task->comment)
            ->isEqualTo('A comment');
    }
}
