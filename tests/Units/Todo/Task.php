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

        $this->string($task->description)
            ->isEqualTo('Give it some context.');

        $this->string((string)$task)
            ->isEqualTo($txt);

        $this->array($task->contexts)
            ->isEqualTo(['context']);
    }

    public function testParseProjects()
    {
        $txt = '(B) 2012-03-04 +project @context @context2 This one has a date and a @context3 AND a project!';

        $task = new \Todo\Task($txt);

        $this->string((string)$task)
            ->isEqualTo($txt);

        $this->string($task->description)
            ->isEqualTo('This one has a date and a @context3 AND a project!');

        $this->array($task->contexts)
            ->isEqualTo(['context', 'context2', 'context3']);

        $this->array($task->projects)
            ->isEqualTo(['project']);
    }

    public function testUncompleted()
    {
        $txt = 'Just a POD: Plain old task.';

        $task = new \Todo\Task($txt);

        $this->string((string)$task)
            ->isEqualTo($txt);

        $this->boolean($task->complete)
            ->isEqualTo(false);
    }

    public function testCompleted()
    {
        $txt = 'x Just a POD: Plain old task.';

        $task = new \Todo\Task($txt);

        $this->string((string)$task)
            ->isEqualTo($txt);

        $this->boolean($task->complete)
            ->isEqualTo(true);
    }

    public function testCompletedDate()
    {
        $txt = 'x 2012-04-03 Just a POD: Plain old task.';

        $task = new \Todo\Task($txt);

        $this->string((string)$task)
            ->isEqualTo($txt);

        $this->boolean($task->complete)
            ->isEqualTo(true);

        $this->string($task->completed)
            ->isEqualTo('2012-04-03');
    }

    public function testToArray()
    {
        $txt = 'x 2012-04-03 Just a POD: Plain old task.';

        $task = new \Todo\Task($txt);

        $this->array($task->toArray())
            ->isEqualTo([
                'contexts' => [],
                'projects' => [],
                'complete' => true,
                'completed' => '2012-04-03',
                'description' => 'Just a POD: Plain old task.',
            ]);
    }
}
