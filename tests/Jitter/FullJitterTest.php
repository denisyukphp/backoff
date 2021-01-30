<?php

namespace Orangesoft\Backoff\Tests\Jitter;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Jitter\FullJitter;

class FullJitterTest extends TestCase
{
    public function testJitterTime(): void
    {
        $equalJitter = new FullJitter();

        $jitterTime = $equalJitter->getJitterTime(new Milliseconds(1000));

        $this->assertGreaterThanOrEqual(0, $jitterTime->toMilliseconds());
        $this->assertLessThanOrEqual(1000, $jitterTime->toMilliseconds());
    }
}
