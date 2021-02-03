<?php

namespace Orangesoft\Backoff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use Orangesoft\Backoff\Sleeper\DummySleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;

class DummySleeperTest extends TestCase
{
    public function testDummy(): void
    {
        $sleeper = new DummySleeper();

        $this->assertInstanceOf(SleeperInterface::class, $sleeper);
    }
}
