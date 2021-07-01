<?php

namespace Orangesoft\BackOff\Tests\Jitter;

use PHPUnit\Framework\TestCase;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Jitter\EqualJitter;

class EqualJitterTest extends TestCase
{
    public function testJitter(): void
    {
        $equalJitter = new EqualJitter();

        $duration = $equalJitter->jitter(new Milliseconds(1000));

        $this->assertGreaterThanOrEqual(500, $duration->asMilliseconds());
        $this->assertLessThanOrEqual(1000, $duration->asMilliseconds());
    }
}
