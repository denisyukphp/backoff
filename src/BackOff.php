<?php

declare(strict_types=1);

namespace Orangesoft\BackOff;

use Orangesoft\BackOff\Generator\GeneratorInterface;
use Orangesoft\BackOff\Sleeper\SleeperInterface;

final class BackOff implements BackOffInterface
{
    public function __construct(
        private int|float $maxAttempts,
        private GeneratorInterface $generator,
        private SleeperInterface $sleeper,
    ) {
    }

    public function backOff(int $attempt, \Throwable $throwable): void
    {
        if ($attempt > $this->maxAttempts) {
            throw $throwable;
        }

        $duration = $this->generator->generate($attempt);

        $this->sleeper->sleep($duration);
    }
}
