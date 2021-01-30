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

        $nextTime = $backoff->getNextTime(4);

        $this->assertGreaterThanOrEqual(8000, $nextTime->toMilliseconds());
        $this->assertLessThanOrEqual(16000, $nextTime->toMilliseconds());
    }
}
