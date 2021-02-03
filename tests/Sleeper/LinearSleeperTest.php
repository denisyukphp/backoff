<?php

namespace Orangesoft\Backoff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Duration\Milliseconds;
use Orangesoft\Backoff\Sleeper\LinearSleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class LinearSleeperTest extends TestCase
{
    public function testLinear(): void
    {
        $sleeper = new LinearSleeper(new Milliseconds(1000));

        $this->assertInstanceOf(SleeperInterface::class, $sleeper);
    }
}
