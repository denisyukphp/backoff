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

        $nextTime = $backoff->getNextTime(4);

        $this->assertGreaterThanOrEqual(2500, $nextTime->toMilliseconds());
        $this->assertLessThanOrEqual(5000, $nextTime->toMilliseconds());
    }
}
