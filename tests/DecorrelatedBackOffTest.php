<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\DecorrelatedBackOff;
use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Sleeper\Sleeper;
use PHPUnit\Framework\TestCase;

class DecorrelatedBackOffTest extends TestCase
{
    public function testMaxAttempts(): void
    {
        $decorrelatedBackOff = new DecorrelatedBackOff(
            maxAttempts: 3,
            baseTime: new Nanoseconds(1_000),
            capTime: new Nanoseconds(60_000),
            sleeper: new Sleeper(),
        );

        $throwable = new \Exception();

        $this->expectExceptionObject($throwable);

        $decorrelatedBackOff->backOff(4, $throwable);
    }

    public function testSleepDuration(): void
    {
        $decorrelatedBackOff = new DecorrelatedBackOff(
            maxAttempts: 3,
            baseTime: new Nanoseconds(1_000),
            capTime: new Nanoseconds(60_000),
            sleeper: $sleepChecker = new SleepChecker(),
        );

        $decorrelatedBackOff->backOff(3, new \Exception());

        $this->assertGreaterThanOrEqual(1_000, $sleepChecker->getDuration()?->asNanoseconds());
        $this->assertLessThanOrEqual(27_000, $sleepChecker->getDuration()?->asNanoseconds());
    }
}
