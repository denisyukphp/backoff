<?php

namespace Orangesoft\Backoff\Tests\Strategy;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Strategy\ExponentialStrategy;

class ExponentialStrategyTest extends TestCase
{
    public function testWaitTime(): void
    {
        $strategy = new ExponentialStrategy(new Milliseconds(1000));

        $waitTime = $strategy->getWaitTime(4);

        $this->assertEquals(16000, $waitTime->asMilliseconds());
    }
}
