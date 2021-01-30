<?php

namespace Orangesoft\Backoff\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\ExponentialEqualJitterBackoff;

class ExponentialEqualJitterBackoffTest extends TestCase
{
    public function testExponentialEqualJitter(): void
    {
        $backoff = new ExponentialEqualJitterBackoff(new Milliseconds(1000));

        $sleepTime = $backoff->getSleepTime(4);

        $this->assertGreaterThanOrEqual(8000, $sleepTime->toMilliseconds());
        $this->assertLessThanOrEqual(16000, $sleepTime->toMilliseconds());
    }
}
