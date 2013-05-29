<?php

namespace Test\Units\Todo\Task;

class Simple extends \atoum
{
    public function testCreate()
    {
        $this->object(new \Todo\Task\Simple)
            ->isInstanceOf('\Todo\Task\Simple');
    }

    public function testCreateWithContent()
    {
        $txt = 'todo';

        $task = new \Todo\Task\Simple($txt);

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testLoad()
    {
        $txt = 'todo';

        $task = new \Todo\Task\Simple();
        $task->load($txt);

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testParsePriority()
    {
        $txt = '(A) Crack the Da Vinci Code.';
        $task = new \Todo\Task\Simple($txt);

        $this->string($task->priority)
            ->isEqualTo('A');

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testParseCreated()
    {
        $txt = '(C) 2012-02-03 This one has a date!';
        $task = new \Todo\Task\Simple($txt);

        $this->string($task->priority)
            ->isEqualTo('C');

        $this->string($task->created)
            ->isEqualTo('2012-02-03');

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testParseContexts()
    {
        $txt = '@context Give it some context.';

        $task = new \Todo\Task\Simple($txt);

        $this->string($task->description)
            ->isEqualTo('Give it some context.');

        $this->array($task->contexts)
            ->isEqualTo(['context']);

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testParseProjects()
    {
        $txt = '(B) 2012-03-04 +project @context @context2 This one has a date and a @context3 AND a project!';

        $task = new \Todo\Task\Simple($txt);

        $this->string($task->description)
            ->isEqualTo('This one has a date and a @context3 AND a project!');

        $this->array($task->contexts)
            ->isEqualTo(['context', 'context2', 'context3']);

        $this->array($task->projects)
            ->isEqualTo(['project']);

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testUncompleted()
    {
        $txt = 'Just a POD: Plain old task.';

        $task = new \Todo\Task\Simple($txt);

        $this->boolean($task->complete)
            ->isEqualTo(false);

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testCompleted()
    {
        $txt = 'x Just a POD: Plain old task.';

        $task = new \Todo\Task\Simple($txt);

        $this->boolean($task->complete)
            ->isEqualTo(true);

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testCompletedDate()
    {
        $txt = 'x 2012-04-03 Just a POD: Plain old task.';

        $task = new \Todo\Task\Simple($txt);

        $this->boolean($task->complete)
            ->isEqualTo(true);

        $this->string($task->completed)
            ->isEqualTo('2012-04-03');

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testToArray()
    {
        $txt = 'x 2012-04-03 Just a POD: Plain old task.';

        $task = new \Todo\Task($txt);

        $this->array($task->toArray())
            ->isEqualTo([
                'raw' => $txt,
                'contexts' => [],
                'projects' => [],
                'complete' => true,
                'completed' => '2012-04-03',
                'description' => 'Just a POD: Plain old task.',
            ]);
    }
}
