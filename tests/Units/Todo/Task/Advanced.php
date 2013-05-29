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

   /**
    * @dataProvider datesProvider
    */
    public function testDates($pattern, $property)
    {
        $txt = "$pattern:2012-04-03 Just a POD: Plain old task.";

        $task = new \Todo\Task\Advanced($txt);

        $this->string($task->$property)
            ->isEqualTo('2012-04-03');

        $this->castToString($task)
            ->isEqualTo($txt);
    }

    public function datesProvider()
    {
        return [
            ['d', 'deprioritizable'],
            ['x', 'trashable'],
        ];
    }

    public function testPrioritize()
    {
        $txt = 'A:2012-04-03 B:2012-02-02 Just a POD: Plain old task.';

        $task = new \Todo\Task\Advanced($txt);

        $this->array($task->prioritizable)
            ->isEqualTo([
                'A' => '2012-04-03',
                'B' => '2012-02-02',
            ]);

        $this->castToString($task)
            ->isEqualTo($txt);
    }
}
