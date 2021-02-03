<?php

namespace Orangesoft\Backoff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Sleeper\ConstantEqualJitterSleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class ConstantEqualJitterSleeperTest extends TestCase
{
    public function testConstantEqualJitter(): void
    {
        $sleeper = new ConstantEqualJitterSleeper(new Milliseconds(1000));

        $this->assertInstanceOf(SleeperInterface::class, $sleeper);
    }
}
