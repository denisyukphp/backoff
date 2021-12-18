<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Strategy;

use Orangesoft\BackOff\Duration\DurationInterface;

final class ConstantStrategy implements StrategyInterface
{
    public function calculate(DurationInterface $duration, int $attempt): DurationInterface
    {
        return $duration;
    }
}
