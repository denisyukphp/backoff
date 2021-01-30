<?php

namespace Orangesoft\Backoff\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Factory\DecorrelationJitterBackoff;

class DecorrelationJitterBackoffTest extends TestCase
{
    public function testDecorrelationJitter(): void
    {
        $backoff = new DecorrelationJitterBackoff(new Milliseconds(1000));

        $nextTime = $backoff->getNextTime(0);

        $this->assertGreaterThanOrEqual(1000, $nextTime->toMilliseconds());
        $this->assertLessThanOrEqual(3000, $nextTime->toMilliseconds());
    }
}
