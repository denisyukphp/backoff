<?php

namespace Orangesoft\Backoff\Tests\Jitter;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Jitter\EqualJitter;

class EqualJitterTest extends TestCase
{
    public function testJitterTime(): void
    {
        $equalJitter = new EqualJitter();

        $jitterTime = $equalJitter->getJitterTime(new Milliseconds(1000));

        $this->assertGreaterThanOrEqual(500, $jitterTime->asMilliseconds());
        $this->assertLessThanOrEqual(1000, $jitterTime->asMilliseconds());
    }
}
