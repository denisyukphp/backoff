<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Strategy;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Nanoseconds;

final class ExponentialStrategy implements StrategyInterface
{
    public function __construct(
        private int $multiplier = 2,
    ) {
    }

    public function calculate(DurationInterface $duration, int $attempt): DurationInterface
    {
        return new Nanoseconds($duration->asNanoseconds() * ($this->multiplier ** $attempt));
    }
}
