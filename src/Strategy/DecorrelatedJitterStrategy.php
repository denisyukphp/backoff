<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Strategy;

use Assert\Assertion;

final class DecorrelatedJitterStrategy implements StrategyInterface
{
    public function __construct(
        private float $multiplier,
    ) {
    }

    public function calculate(int $attempt, float $duration): float
    {
        // @codeCoverageIgnoreStart
        Assertion::greaterOrEqualThan($this->multiplier, 0);
        Assertion::greaterOrEqualThan($attempt, 0);
        Assertion::greaterOrEqualThan($duration, 0);
        // @codeCoverageIgnoreEnd

        if (0 >= $attempt) {
            return 0;
        }

        return random_float($duration, $duration * $this->multiplier * $attempt);
    }
}
