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

        $this->string($task->comment)
            ->isEqualTo('A comment');

        $this->string($task->description)
            ->isEqualTo('Crack the Da Vinci Code.');

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testUntrashed()
    {
        $txt = 'Just a POD: Plain old task.';

        $task = new \Todo\Task\Advanced($txt);

        $this->boolean($task->trash)
            ->isEqualTo(false);

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testTrashed()
    {
        $txt = 'X Just a POD: Plain old task.';

        $task = new \Todo\Task\Advanced($txt);

        $this->boolean($task->trash)
            ->isEqualTo(true);

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testTrashedDate()
    {
        $txt = 'X 2012-04-03 Just a POD: Plain old task.';

        $task = new \Todo\Task\Advanced($txt);

        $this->boolean($task->trash)
            ->isEqualTo(true);

        $this->string($task->trashed)
            ->isEqualTo('2012-04-03');

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testDeprioritize()
    {
        $txt = 'd:2012-04-03 Just a POD: Plain old task.';

        $task = new \Todo\Task\Advanced($txt);

        $this->string($task->deprioritizable)
            ->isEqualTo('2012-04-03');

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function testTashable()
    {
        $txt = 'x:2012-04-03 Just a POD: Plain old task.';

        $task = new \Todo\Task\Advanced($txt);

        $this->string($task->trashable)
            ->isEqualTo('2012-04-03');

        $this->castToString($task)
            ->isEqualTo($txt);
    }
}
