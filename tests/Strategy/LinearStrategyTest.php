<?php

namespace Orangesoft\Backoff\Tests\Strategy;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Strategy\LinearStrategy;

class LinearStrategyTest extends TestCase
{
    public function testWaitTime(): void
    {
        $strategy = new LinearStrategy(new Milliseconds(1000));

        $waitTime = $strategy->getWaitTime(4);

        $this->assertEquals(5000, $waitTime->toMilliseconds());
    }
}
