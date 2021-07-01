<?php

namespace Orangesoft\BackOff\Strategy;

use Orangesoft\BackOff\Duration\DurationInterface;
use Orangesoft\BackOff\Duration\Nanoseconds;

final class LinearStrategy implements StrategyInterface
{
    public function calculate(DurationInterface $duration, int $attempt): DurationInterface
    {
        $nanoseconds = $duration->asNanoseconds() * ($attempt + 1);

        return new Nanoseconds($nanoseconds);
    }
}
