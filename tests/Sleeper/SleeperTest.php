<?php

namespace Orangesoft\Backoff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Timer\Timer;
use Orangesoft\Backoff\Sleeper\Sleeper;
use Orangesoft\Backoff\Sleeper\SleeperInterface;
use Orangesoft\Backoff\Sleeper\BackoffSleeperInterface;
use Orangesoft\Retry\Sleeper\SleeperInterface as RetrySleeperInterface;
use Orangesoft\Backoff\Factory\LinearBackoff;
use Orangesoft\Backoff\Duration\Milliseconds;

class SleeperTest extends TestCase
{
    public function testSleep(): void
    {
        $backoff = new LinearBackoff(new Milliseconds(500));

        $sleeper = new Sleeper($backoff);

        $timer = new Timer();

        $timer->start();

        $sleeper->sleep(0);

        $milliseconds = $timer->stop() * 1000;

        $this->assertGreaterThanOrEqual(500, $milliseconds);
        $this->assertInstanceOf(SleeperInterface::class, $sleeper);
        $this->assertInstanceOf(BackoffSleeperInterface::class, $sleeper);
        $this->assertInstanceOf(RetrySleeperInterface::class, $sleeper);
    }
}
