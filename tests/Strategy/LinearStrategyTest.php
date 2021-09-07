<?php

namespace Orangesoft\BackOff\Tests\Strategy;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\LinearStrategy;

class LinearStrategyTest extends TestCase
{
    public function testCalculate(): void
    {
        $linearStrategy = new LinearStrategy();

        $duration = $linearStrategy->calculate(new Milliseconds(1000), 3);

        $this->assertEquals(4000, $duration->asMilliseconds());
    }
}
