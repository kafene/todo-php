<?php

namespace Test\Unit\Todo;

class Task extends \atoum
{
    public function testCreate()
    {
        $this->object(new \Todo\Task)
            ->isInstanceOf('\Todo\Task');
    }
}
