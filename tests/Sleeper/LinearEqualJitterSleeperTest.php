<?php

namespace Orangesoft\Backoff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Sleeper\LinearEqualJitterSleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class LinearEqualJitterSleeperTest extends TestCase
{
    public function testLinearEqualJitter(): void
    {
        $sleeper = new LinearEqualJitterSleeper(new Milliseconds(1000));

        $this->assertInstanceOf(SleeperInterface::class, $sleeper);
    }
}
