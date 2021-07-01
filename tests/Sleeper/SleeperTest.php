<?php

namespace Orangesoft\BackOff\Tests\Sleeper;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Timer\Timer;
use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\Duration\Milliseconds;

class SleeperTest extends TestCase
{
    public function testSleep(): void
    {
        $sleeper = new Sleeper();

        $timer = new Timer();

        $duration = new Milliseconds(500);

        $timer->start();

        $sleeper->sleep($duration);

        $milliseconds = $timer->stop() * 1000;

        $this->assertGreaterThanOrEqual(500, $milliseconds);
    }
}
