<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Strategy;

interface StrategyInterface
{
    public function calculate(int $attempt, float $duration): float;
}
