<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests\Sleeper;

use Orangesoft\BackOff\Duration\Seconds;
use Orangesoft\BackOff\Sleeper\Sleeper;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\Timer\Timer;

final class SleeperTest extends TestCase
{
    /**
     * @dataProvider getSleepTimeData
     */
    public function testSleep(float $sleepTime): void
    {
        $sleeper = new Sleeper();
        $timer = new Timer();

        $timer->start();
        $sleeper->sleep(new Seconds($sleepTime));
        $duration = $timer->stop();

        $this->assertGreaterThanOrEqual($sleepTime, $duration->asSeconds());
    }

    public function getSleepTimeData(): array
    {
        return [
            [0.5],
            [1.0],
            [1.5],
        ];
    }
}
