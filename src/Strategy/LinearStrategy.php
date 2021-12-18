<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Strategy;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Nanoseconds;

final class LinearStrategy implements StrategyInterface
{
    public function calculate(DurationInterface $duration, int $attempt): DurationInterface
    {
        return new Nanoseconds($duration->asNanoseconds() * $attempt);
    }
}
