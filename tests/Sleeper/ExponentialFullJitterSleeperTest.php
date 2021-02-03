<?php

namespace Orangesoft\Backoff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Sleeper\ExponentialFullJitterSleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class ExponentialFullJitterSleeperTest extends TestCase
{
    public function testExponentialFullJitter(): void
    {
        $sleeper = new ExponentialFullJitterSleeper(new Milliseconds(1000));

        $this->assertInstanceOf(SleeperInterface::class, $sleeper);
    }
}
