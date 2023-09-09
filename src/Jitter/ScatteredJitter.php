<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Jitter;

use Assert\Assertion;

final class ScatteredJitter implements JitterInterface
{
    public function __construct(
        private float $range,
    ) {
    }

    public function jitter(float $duration): float
    {
        // @codeCoverageIgnoreStart
        Assertion::greaterOrEqualThan($this->range, 0);
        Assertion::greaterOrEqualThan($duration, 0);
        // @codeCoverageIgnoreEnd

        return $duration - ($duration * $this->range) + random_float(0, $duration * $this->range * 2);
    }
}
