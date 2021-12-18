<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Strategy;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Nanoseconds;

final class DecorrelatedStrategy implements StrategyInterface
{
    public function __construct(
        private int $multiplier = 3,
    ) {
    }

    public function calculate(DurationInterface $duration, int $attempt): DurationInterface
    {
        $nanoseconds = (int) $duration->asNanoseconds();

        return new Nanoseconds(mt_rand($nanoseconds, $nanoseconds * $this->multiplier * $attempt));
    }
}
