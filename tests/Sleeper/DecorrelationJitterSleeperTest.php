<?php

namespace Orangesoft\Backoff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Sleeper\DecorrelationJitterSleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class DecorrelationJitterSleeperTest extends TestCase
{
    public function testDecorrelationJitter(): void
    {
        $sleeper = new DecorrelationJitterSleeper(new Milliseconds(1000));

        $this->assertInstanceOf(SleeperInterface::class, $sleeper);
    }
}
