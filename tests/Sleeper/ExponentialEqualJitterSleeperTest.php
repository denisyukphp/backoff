<?php

namespace Orangesoft\Backoff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Sleeper\ExponentialEqualJitterSleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class ExponentialEqualJitterSleeperTest extends TestCase
{
    public function testExponentialEqualJitter(): void
    {
        $sleeper = new ExponentialEqualJitterSleeper(new Milliseconds(1000));

        $this->assertInstanceOf(SleeperInterface::class, $sleeper);
    }
}
