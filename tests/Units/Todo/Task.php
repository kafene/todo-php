<?php

namespace Test\Unit\Todo;

class Task extends \atoum
{
    public function testCreate()
    {
        $this->object(new \Todo\Task)
            ->isInstanceOf('\Todo\Task');
    }

    public function testCreateWithContent()
    {
        $txt = 'todo';

        $task = new \Todo\Task($txt);
        $this->string((string)$task)
            ->isEqualTo($txt);
    }

    public function testLoad()
    {
        $txt = 'todo';

        $task = new \Todo\Task();
        $task->load($txt);
        $this->string((string)$task)
            ->isEqualTo($txt);
    }

    public function testParsePriority()
    {
        $txt = '(A) Crack the Da Vinci Code.';
        $task = new \Todo\Task($txt);

        $this->string((string)$task)
            ->isEqualTo($txt);

        $this->string($task->priority)
            ->isEqualTo('A');
    }
}
