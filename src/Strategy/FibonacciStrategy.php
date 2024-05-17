<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Strategy;

use Assert\Assertion;

final class FibonacciStrategy implements StrategyInterface
{
    public function calculate(int $attempt, float $duration): float
    {
        // @codeCoverageIgnoreStart
        Assertion::greaterOrEqualThan($attempt, 0);
        Assertion::greaterOrEqualThan($duration, 0);
        // @codeCoverageIgnoreEnd

        if (0 >= $attempt) {
            return 0;
        }

        $fi = (1 + sqrt(5)) / 2;

        return (($fi ** $attempt - (1 - $fi) ** $attempt) / sqrt(5)) * $duration;
    }
}
