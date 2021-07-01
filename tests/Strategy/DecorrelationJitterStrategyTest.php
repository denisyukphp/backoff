<?php

namespace Orangesoft\BackOff\Tests\Strategy;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Strategy\DecorrelationJitterStrategy;

class DecorrelationJitterStrategyTest extends TestCase
{
    public function testCalculate(): void
    {
        $strategy = new DecorrelationJitterStrategy(3);

        $duration = $strategy->calculate(new Milliseconds(1000), 0);

        $this->assertGreaterThanOrEqual(1000, $duration->asMilliseconds());
        $this->assertLessThanOrEqual(3000, $duration->asMilliseconds());
    }
}
