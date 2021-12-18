<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Milliseconds;
use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\Sleeper\SleeperInterface;
use Orangesoft\BackOff\Strategy\DecorrelatedStrategy;

final class DecorrelatedBackOff implements BackOffInterface
{
    private BackOffInterface $backOff;

    public function __construct(
        int|float $maxAttempts = 3,
        DurationInterface $baseTime = new Milliseconds(1_000),
        DurationInterface $capTime = new Milliseconds(60_000),
        int $multiplier = 3,
        SleeperInterface $sleeper = new Sleeper(),
    ) {
        $generator = new Generator(
            baseTime: $baseTime,
            capTime: $capTime,
            strategy: new DecorrelatedStrategy($multiplier),
            jitter: new NullJitter(),
        );

        $this->backOff = new BackOff($maxAttempts, $generator, $sleeper);
    }

    public function backOff(int $attempt, \Throwable $throwable): void
    {
        $this->backOff->backOff($attempt, $throwable);
    }
}
