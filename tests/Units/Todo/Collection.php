<?php

namespace Test\Unit\Todo;

class Collection extends \atoum
{
    private $todo;
    private $txt = <<<EOD
(A) Crack the Da Vinci Code.
(B) +winning Win.
@context Give it some context.
Just a POD: Plain old task.
(C) +project @context This one has it all!
(C) 2012-02-03 This one has a date!
(B) 2012-03-04 +project @context This one has a date and a context AND a project!
2012-04-03 This one has no priority and a date.
03-04-2012 This one has a malformed date.

EOD;

    public function beforeTestMethod($testMethod)
    {
        $this->todo = new \Todo\Collection($this->txt);
    }

    public function testCreate()
    {
        $this->object(new \Todo\Collection)
            ->isInstanceOf('\Todo\Collection');
    }

    public function testCreateWithContent()
    {
        $this->array($this->todo->getTasks())
            ->size->isEqualTo(9);
    }

    public function testLoad()
    {
        $todo = new \Todo\Collection();
        $todo->load($this->txt);
        $this->array($todo->getTasks())
            ->size->isEqualTo(9);
    }

    public function testForeach()
    {
        foreach ($this->todo as $task) {
            $this->object($task)
                ->isInstanceOf('\Todo\Task\Simple');
        }
    }

    public function testArrayAccess()
    {
        $this->object($this->todo)
            ->isInstanceOf('\ArrayAccess');
    }

    public function testArrayAccessExist()
    {
        $this->boolean(isset($this->todo[1]))
            ->isEqualTo(true);
    }

    public function testArrayAccessGet()
    {
        $this->object($this->todo[1])
            ->isInstanceOf('\Todo\Task\Simple');
    }

    public function testArrayAccessSet()
    {
        $this->todo[1] = false;
        $this->boolean($this->todo[1])
            ->isEqualTo(false);
    }

    public function testArrayAccessUnset()
    {
        unset($this->todo[1]);
        $this->boolean(isset($this->todo[1]))
            ->isEqualTo(false);
    }

    public function testToString()
    {
        $this->castToString($this->todo)
            ->isIdenticalTo(trim($this->txt));
    }

    public function testInvalidTaskType()
    {
        $this->exception(function () {
            new \Todo\Collection($this->txt, 'invalidType');
        })->hasMessage('Unknow task type `invalidType`');
    }

    public function testAdvancedTask()
    {
        $todo = new \Todo\Collection($this->txt, 'advanced');

        foreach ($todo as $task) {
            $this->object($task)
                ->isInstanceOf('\Todo\Task\Advanced');
        }
    }

    public function testCount()
    {
        $this->integer(count($this->todo))
            ->isIdenticalTo(9);
    }

    public function testAppendTask()
    {
        $task = new \Todo\Task\Simple('A new task');
        $this->todo[] = $task;

        $this->integer(count($this->todo))
            ->isIdenticalTo(10);

        $this->integer($task->id)
            ->isIdenticalTo(9);
    }
}
