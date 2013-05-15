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

    public function testParseCreated()
    {
        $txt = '(C) 2012-02-03 This one has a date!';
        $task = new \Todo\Task($txt);

        $this->string((string)$task)
            ->isEqualTo($txt);

        $this->string($task->priority)
            ->isEqualTo('C');

        $this->string($task->created)
            ->isEqualTo('2012-02-03');
    }

    public function testParseContexts()
    {
        $txt = '@context Give it some context.';

        $task = new \Todo\Task($txt);

        $this->string((string)$task)
            ->isEqualTo($txt);

        $this->array($task->contexts)
            ->isEqualTo(['context']);
    }
}
