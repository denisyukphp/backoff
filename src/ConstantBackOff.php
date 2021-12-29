<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Seconds;
use Orangesoft\BackOff\Generator\Generator;
use Orangesoft\BackOff\Jitter\JitterInterface;
use Orangesoft\BackOff\Jitter\NullJitter;
use Orangesoft\BackOff\Sleeper\Sleeper;
use Orangesoft\BackOff\Sleeper\SleeperInterface;
use Orangesoft\BackOff\Strategy\ConstantStrategy;

final class ConstantBackOff implements BackOffInterface
{
    private BackOffInterface $backOff;

    public function __construct(
        int|float $maxAttempts = 3,
        DurationInterface $baseTime = new Seconds(1),
        DurationInterface $capTime = new Seconds(60),
        JitterInterface $jitter = new NullJitter(),
        SleeperInterface $sleeper = new Sleeper(),
    ) {
        $generator = new Generator(
            baseTime: $baseTime,
            capTime: $capTime,
            strategy: new ConstantStrategy(),
            jitter: $jitter,
        );

        $this->backOff = new BackOff($maxAttempts, $generator, $sleeper);
    }

    public function backOff(int $attempt, \Throwable $throwable): void
    {
        $this->backOff->backOff($attempt, $throwable);
    }
}
