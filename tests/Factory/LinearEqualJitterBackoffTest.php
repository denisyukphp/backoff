<?php

namespace Orangesoft\Backoff\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\LinearEqualJitterBackoff;

class LinearEqualJitterBackoffTest extends TestCase
{
    public function testLinearEqualJitter(): void
    {
        $backoff = new LinearEqualJitterBackoff(new Milliseconds(1000));

        $sleepTime = $backoff->getSleepTime(4);

        $this->assertGreaterThanOrEqual(2500, $sleepTime->toMilliseconds());
        $this->assertLessThanOrEqual(5000, $sleepTime->toMilliseconds());
    }
}
