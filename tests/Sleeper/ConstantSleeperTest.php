<?php

namespace Orangesoft\Backoff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Sleeper\ConstantSleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class ConstantSleeperTest extends TestCase
{
    public function testConstant(): void
    {
        $sleeper = new ConstantSleeper(new Milliseconds(1000));

        $this->assertInstanceOf(SleeperInterface::class, $sleeper);
    }
}
