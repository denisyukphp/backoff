<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\LinearBackOff;
use Orangesoft\BackOff\Sleeper\Sleeper;
use PHPUnit\Framework\TestCase;

class LinearBackOffTest extends TestCase
{
    public function testMaxAttempts(): void
    {
        $linearBackOff = new LinearBackOff(
            maxAttempts: 3,
            baseTime: new Nanoseconds(1_000),
            capTime: new Nanoseconds(60_000),
            jitter: new NullJitter(),
            sleeper: new Sleeper(),
        );

        $throwable = new \Exception();

        $this->expectExceptionObject($throwable);

        $linearBackOff->backOff(4, $throwable);
    }

    public function testSleepDuration(): void
    {
        $linearBackOff = new LinearBackOff(
            maxAttempts: 3,
            baseTime: new Nanoseconds(1_000),
            capTime: new Nanoseconds(60_000),
            jitter: new NullJitter(),
            sleeper: $sleepChecker = new SleepChecker(),
        );

        $linearBackOff->backOff(3, new \Exception());

        $this->assertEquals(3_000, $sleepChecker->getDuration()?->asNanoseconds());
    }
}
