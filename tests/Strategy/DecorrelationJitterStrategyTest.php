<?php

namespace Orangesoft\Backoff\Tests\Strategy;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Strategy\DecorrelationJitterStrategy;

class DecorrelationJitterStrategyTest extends TestCase
{
    public function testWaitTime(): void
    {
        $strategy = new DecorrelationJitterStrategy(new Milliseconds(1000));

        $waitTime = $strategy->getWaitTime(0);

        $this->assertGreaterThanOrEqual(1000, $waitTime->asMilliseconds());
        $this->assertLessThanOrEqual(3000, $waitTime->asMilliseconds());
    }
}
