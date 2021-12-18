<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Tests;

use Orangesoft\BackOff\BackOff;
use Orangesoft\BackOff\Duration\Nanoseconds;
use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\Strategy\ConstantStrategy;
use PHPUnit\Framework\TestCase;

class BackOffTest extends TestCase
{
    public function testMaxAttempts(): void
    {
        $backOff = new BackOff(
            maxAttempts: 3,
            generator: new Generator(
                baseTime: new Nanoseconds(1_000),
                capTime: new Nanoseconds(60_000),
                strategy: new ConstantStrategy(),
                jitter: new NullJitter(),
            ),
            sleeper: new Sleeper(),
        );

        $throwable = new \Exception();

        $this->expectExceptionObject($throwable);

        $backOff->backOff(4, $throwable);
    }

    public function testSleepDuration(): void
    {
        $backOff = new BackOff(
            maxAttempts: 3,
            generator: new Generator(
                baseTime: new Nanoseconds(1_000),
                capTime: new Nanoseconds(60_000),
                strategy: new ConstantStrategy(),
                jitter: new NullJitter(),
            ),
            sleeper: $sleepChecker = new SleepChecker(),
        );

        $backOff->backOff(3, new \Exception());

        $this->assertEquals(1_000, $sleepChecker->getDuration()?->asNanoseconds());
    }
}
