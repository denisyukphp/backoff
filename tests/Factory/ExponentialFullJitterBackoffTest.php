<?php

namespace Orangesoft\Backoff\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\ExponentialFullJitterBackoff;

class ExponentialFullJitterBackoffTest extends TestCase
{
    public function testExponentialFullJitter(): void
    {
        $backoff = new ExponentialFullJitterBackoff(new Milliseconds(1000));

        $sleepTime = $backoff->getSleepTime(4);

        $this->assertGreaterThanOrEqual(0, $sleepTime->toMilliseconds());
        $this->assertLessThanOrEqual(16000, $sleepTime->toMilliseconds());
    }
}
