<?php

namespace Orangesoft\Backoff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Sleeper\LinearFullJitterSleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class LinearFullJitterSleeperTest extends TestCase
{
    public function testLinearFullJitter(): void
    {
        $sleeper = new LinearFullJitterSleeper(new Milliseconds(1000));

        $this->assertInstanceOf(SleeperInterface::class, $sleeper);
    }
}
