<?php

namespace Orangesoft\Backoff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Sleeper\ConstantFullJitterSleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class ConstantFullJitterSleeperTest extends TestCase
{
    public function testConstantFullJitter(): void
    {
        $sleeper = new ConstantFullJitterSleeper(new Milliseconds(1000));

        $this->assertInstanceOf(SleeperInterface::class, $sleeper);
    }
}
