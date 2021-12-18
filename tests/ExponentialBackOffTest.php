<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\ExponentialBackOff;
use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;
use PHPUnit\Framework\TestCase;

class ExponentialBackOffTest extends TestCase
{
    public function testMaxAttempts(): void
    {
        $exponentialBackOff = new ExponentialBackOff(
            maxAttempts: 3,
            baseTime: new Nanoseconds(1_000),
            capTime: new Nanoseconds(60_000),
            jitter: new NullJitter(),
            sleeper: new Sleeper(),
        );

        $throwable = new \Exception();

        $this->expectExceptionObject($throwable);

        $exponentialBackOff->backOff(4, $throwable);
    }

    public function testSleepDuration(): void
    {
        $exponentialBackOff = new ExponentialBackOff(
            maxAttempts: 3,
            baseTime: new Nanoseconds(1_000),
            capTime: new Nanoseconds(60_000),
            jitter: new NullJitter(),
            sleeper: $sleepChecker = new SleepChecker(),
        );

        $exponentialBackOff->backOff(3, new \Exception());

        $this->assertEquals(8_000, $sleepChecker->getDuration()?->asNanoseconds());
    }
}
