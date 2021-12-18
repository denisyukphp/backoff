<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Sleeper;

use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Sleeper\Sleeper;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\Timer\Timer;

class SleeperTest extends TestCase
{
    public function testSleep(): void
    {
        $sleeper = new Sleeper();

        $timer = new Timer();

        $milliseconds = new Nanoseconds(1_000);

        $timer->start();

        $sleeper->sleep($milliseconds);

        $duration = $timer->stop();

        $this->assertGreaterThanOrEqual(1_000, $duration->asNanoseconds());
    }
}
