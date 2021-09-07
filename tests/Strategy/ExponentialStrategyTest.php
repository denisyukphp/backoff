<?php

namespace Orangesoft\BackOff\Tests\Strategy;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\ExponentialStrategy;

class ExponentialStrategyTest extends TestCase
{
    public function testCalculate(): void
    {
        $exponentialStrategy = new ExponentialStrategy(2);

        $duration = $exponentialStrategy->calculate(new Milliseconds(1000), 3);

        $this->assertEquals(8000, $duration->asMilliseconds());
    }
}
