<?php

namespace Test\Unit\Todo;

class Collection extends \atoum
{
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

    public function testCreate()
    {
        $this->object(new \Todo\Collection)
            ->isInstanceOf('\Todo\Collection');
    }

    public function testCreateWithContent()
    {
        $todo = new \Todo\Collection($this->txt);
        $this->array($todo->getTasks())
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
        $todo = new \Todo\Collection($this->txt);

        foreach ($todo as $task) {
            $this->object($task)
                ->isInstanceOf('\Todo\Task\Simple');
        }
    }

    public function testArrayAccess()
    {
        $todo = new \Todo\Collection($this->txt);

        $this->object($todo)
            ->isInstanceOf('\ArrayAccess');
    }

    public function testArrayAccessExist()
    {
        $todo = new \Todo\Collection($this->txt);

        $this->boolean(isset($todo[1]))
            ->isEqualTo(true);
    }

    public function testArrayAccessGet()
    {
        $todo = new \Todo\Collection($this->txt);

        $this->object($todo[1])
            ->isInstanceOf('\Todo\Task\Simple');
    }

    public function testArrayAccessSet()
    {
        $todo = new \Todo\Collection($this->txt);

        $todo[1] = false;
        $this->boolean($todo[1])
            ->isEqualTo(false);
    }

    public function testArrayAccessUnset()
    {
        $todo = new \Todo\Collection($this->txt);

        unset($todo[1]);
        $this->boolean(isset($todo[1]))
            ->isEqualTo(false);
    }

    public function testToString()
    {
        $todo = new \Todo\Collection($this->txt);

        $this->castToString($todo)
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
}
