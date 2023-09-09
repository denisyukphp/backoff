<?php

declare(strict_types=1);

namespace Orangesoft\BackOff\Jitter;

use Assert\Assertion;

final class EqualJitter implements JitterInterface
{
    public function jitter(float $duration): float
    {
        Assertion::greaterOrEqualThan($duration, 0); // @codeCoverageIgnore

        return $duration / 2 + random_float(0, $duration / 2);
    }
}
