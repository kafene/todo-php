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
                ->isInstanceOf('\Todo\Task');
        }
    }
}
