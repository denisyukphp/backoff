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

        $nextTime = $backoff->getNextTime(4);

        $this->assertGreaterThanOrEqual(0, $nextTime->toMilliseconds());
        $this->assertLessThanOrEqual(5000, $nextTime->toMilliseconds());
    }
}
