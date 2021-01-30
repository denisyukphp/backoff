<?php

namespace Orangesoft\Backoff\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\LinearFullJitterBackoff;

class LinearFullJitterBackoffTest extends TestCase
{
    public function testLinearFullJitter(): void
    {
        $backoff = new LinearFullJitterBackoff(new Milliseconds(1000));

        $sleepTime = $backoff->getSleepTime(4);

        $this->assertGreaterThanOrEqual(0, $sleepTime->toMilliseconds());
        $this->assertLessThanOrEqual(5000, $sleepTime->toMilliseconds());
    }
}
