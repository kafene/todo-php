<?php

namespace Test\Units\Todo\Task;

class Advanced extends \atoum
{
    public function testCreate()
    {
        $this->object(new \Todo\Task\Advanced)
            ->isInstanceOf('\Todo\Task\Advanced');
    }
}
